<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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
            ->select('pagos.*', 'clientes.nombre as cliente')
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
                'cliente_id' => 'required',
                'monto' => 'required|numeric',
                'metodo_pago' => 'required',
            ]);

            $pago = new Pago;
            $pago->cliente_id = $data['cliente_id'];
            $pago->monto = $data['monto'];
            $pago->metodo_pago = $data['metodo_pago'];
            $pago->referencia = $data['referencia'] ?? null;
            $pago->comentarios = $data['comentarios'] ?? null;
            $pago->save();

            Session::flash('success_message', 'Pago registrado exitosamente!');
            return redirect('/admin/view-pagos');
        }

        $clientes = Cliente::where('estado', 1)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        return view('admin.pagos.add_pago')->with(compact('clientes'));
    }

    public function editPago(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            // Validate the data
            $request->validate([
                'cliente_id' => 'required',
                'monto' => 'required|numeric',
                'metodo_pago' => 'required',
            ]);

            $pago = Pago::find($id);
            $pago->cliente_id = $data['cliente_id'];
            $pago->monto = $data['monto'];
            $pago->metodo_pago = $data['metodo_pago'];
            $pago->referencia = $data['referencia'] ?? null;
            $pago->comentarios = $data['comentarios'] ?? null;
            $pago->save();

            Session::flash('success_message', 'Pago actualizado exitosamente!');
            return redirect('/admin/view-pagos');
        }

        $pago = Pago::find($id);
        $clientes = Cliente::all();
        return view('admin.pagos.edit_pago')->with(compact('pago', 'clientes'));
    }

    public function deletePago($id = null)
    {
        $pago = Pago::find($id);
        
        // Soft delete by changing estado
        $pago->estado = 0;
        $pago->save();

        Session::flash('success_message', 'Pago eliminado exitosamente!');
        return redirect()->back();
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
