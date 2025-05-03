<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Orden;
use App\Models\Pago;
use Illuminate\Http\Request;
use Session;
use DataTables;
use DB;

class PagoController extends Controller
{
    public function index()
    {
        return view('admin.pagos.view_pagos');
    }

    public function getPagos()
    {
        $pagos = DB::table('pagos')
            ->join('clientes', 'pagos.cliente_id', '=', 'clientes.id')
            ->join('ordenes', 'pagos.orden_id', '=', 'ordenes.id')
            ->select('pagos.*', 'clientes.nombre as cliente', 'ordenes.asunto as orden')
            ->where('pagos.estado', 1)
            ->get();

        return DataTables::of($pagos)
            ->addColumn('action', function ($pago) {
                return '<a href="' . url('/admin/edit-pago/' . $pago->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Editar</a> <a id="deleteButton" rel="' . $pago->id . '" rel1="delete-pago" href="javascript:" class="btn btn-xs btn-danger deleteButton"><i class="fa fa-trash"></i> Eliminar</a>';
            })
            ->editColumn('monto', function ($pago) {
                return '$' . number_format($pago->monto, 2);
            })
            ->make(true);
    }

    public function addPago(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            // Validate the data
            $request->validate([
                'orden_id' => 'required',
                'cliente_id' => 'required',
                'monto' => 'required|numeric',
                'metodo_pago' => 'required',
            ]);

            $pago = new Pago;
            $pago->orden_id = $data['orden_id'];
            $pago->cliente_id = $data['cliente_id'];
            $pago->monto = $data['monto'];
            $pago->metodo_pago = $data['metodo_pago'];
            $pago->referencia = $data['referencia'] ?? null;
            $pago->comentarios = $data['comentarios'] ?? null;
            $pago->save();

            // Update the order payment status if needed
            $orden = Orden::find($data['orden_id']);
            $totalPagado = Pago::where('orden_id', $orden->id)->where('estado', 1)->sum('monto');
            
            // Check the existing value first to avoid potential mismatches
            $estadoPago = DB::table('ordenes')
                ->where('id', $orden->id)
                ->value('estado_pago');
                
            // Now determine the new status
            if ($totalPagado >= $orden->importe) {
                // Try to match the case of existing values
                $orden->estado_pago = 'PAGADO';
            } else if ($totalPagado > 0) {
                $orden->estado_pago = 'PARCIAL';
            } else {
                $orden->estado_pago = 'PENDIENTE';
            }
            $orden->save();

            Session::flash('success_message', 'Pago registrado exitosamente!');
            return redirect('/admin/view-pagos');
        }

        $ordenes = Orden::where('estado_orden', '!=', 'Cancelada')->get();
        $clientes = Cliente::all();
        return view('admin.pagos.add_pago')->with(compact('ordenes', 'clientes'));
    }

    public function addPagoOrden($ordenId)
    {
        $orden = Orden::find($ordenId);
        if (!$orden) {
            Session::flash('error_message', 'Orden no encontrada!');
            return redirect()->back();
        }
        
        $cliente = Cliente::find($orden->cliente_id);
        return view('admin.pagos.add_pago_orden')->with(compact('orden', 'cliente'));
    }

    public function editPago(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            // Validate the data
            $request->validate([
                'orden_id' => 'required',
                'cliente_id' => 'required',
                'monto' => 'required|numeric',
                'metodo_pago' => 'required',
            ]);

            $pago = Pago::find($id);
            $pago->orden_id = $data['orden_id'];
            $pago->cliente_id = $data['cliente_id'];
            $pago->monto = $data['monto'];
            $pago->metodo_pago = $data['metodo_pago'];
            $pago->referencia = $data['referencia'] ?? null;
            $pago->comentarios = $data['comentarios'] ?? null;
            $pago->save();

            // Update the order payment status
            $orden = Orden::find($data['orden_id']);
            $totalPagado = Pago::where('orden_id', $orden->id)->where('estado', 1)->sum('monto');
            
            if ($totalPagado >= $orden->importe) {
                $orden->estado_pago = 'PAGADO';
            } else if ($totalPagado > 0) {
                $orden->estado_pago = 'PARCIAL';
            } else {
                $orden->estado_pago = 'PENDIENTE';
            }
            $orden->save();

            Session::flash('success_message', 'Pago actualizado exitosamente!');
            return redirect('/admin/view-pagos');
        }

        $pago = Pago::find($id);
        $ordenes = Orden::where('estado_orden', '!=', 'Cancelada')->get();
        $clientes = Cliente::all();
        return view('admin.pagos.edit_pago')->with(compact('pago', 'ordenes', 'clientes'));
    }

    public function deletePago($id = null)
    {
        $pago = Pago::find($id);
        $orden_id = $pago->orden_id;
        
        // Soft delete by changing estado
        $pago->estado = 0;
        $pago->save();

        // Update the order payment status
        $orden = Orden::find($orden_id);
        $totalPagado = Pago::where('orden_id', $orden->id)->where('estado', 1)->sum('monto');
        
        if ($totalPagado >= $orden->importe) {
            $orden->estado_pago = 'PAGADO';
        } else if ($totalPagado > 0) {
            $orden->estado_pago = 'PARCIAL';
        } else {
            $orden->estado_pago = 'PENDIENTE';
        }
        $orden->save();

        Session::flash('success_message', 'Pago eliminado exitosamente!');
        return redirect()->back();
    }

    public function pagosByOrden($ordenId)
    {
        $orden = Orden::find($ordenId);
        if (!$orden) {
            Session::flash('error_message', 'Orden no encontrada!');
            return redirect()->back();
        }

        $pagos = Pago::where('orden_id', $ordenId)->where('estado', 1)->get();
        return view('admin.pagos.pagos_by_orden')->with(compact('pagos', 'orden'));
    }

    public function pagosByCliente($clienteId)
    {
        $cliente = Cliente::find($clienteId);
        if (!$cliente) {
            Session::flash('error_message', 'Cliente no encontrado!');
            return redirect()->back();
        }

        $pagos = Pago::where('cliente_id', $clienteId)->where('estado', 1)->get();
        return view('admin.pagos.pagos_by_cliente')->with(compact('pagos', 'cliente'));
    }
}
