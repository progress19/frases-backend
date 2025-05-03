<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Orden;
use App\Models\Cliente;
use App\Fun;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class OrdenController extends Controller {

    public function viewOrdenes() {
        return view('admin.ordenes.view_ordenes');
    }
    
    /********************************************************************************************/
    /************************************ GET DATA **********************************************/
    
    public function getData() {
        $ordenes = Orden::with('cliente')->select('ordenes.*');
        return Datatables::of($ordenes)
        ->editColumn('id', function ($orden) {
            return "<a class='btn-table hvr-grow' href='edit-orden/$orden->id'>$orden->id</a>"; 
        })
        ->addColumn('fecha', function ($orden) {
            return date('d/m/Y', strtotime($orden->created_at));
        })
        ->editColumn('cliente_id', function ($orden) {
            return "<a title='Ver cliente' href='edit-cliente/$orden->cliente_id'>  ".$orden->cliente->nombre." </a>"; 
        })
        ->editColumn('asunto', function ($orden) {
            return "<a title='Clic para editar...' href='edit-orden/$orden->id'>  ".Str::limit($orden->asunto, 50)." </a>"; 
        })
        ->editColumn('importe', function ($orden) {
            return "$ " . number_format($orden->importe, 2);
        })
        ->editColumn('estado_pago', function ($orden) {
            $class = $orden->estado_pago == 'Pagado' ? 'success' : 'warning';
            return "<span class='label label-$class'>".$orden->estado_pago."</span>";
        })
        ->editColumn('estado_orden', function ($orden) {
            $class = '';
            switch ($orden->estado_orden) {
                case 'Pendiente':
                    $class = 'warning';
                    break;
                case 'En progreso':
                    $class = 'info';
                    break;
                case 'Completada':
                    $class = 'success';
                    break;
                case 'Cancelada':
                    $class = 'danger';
                    break;
            }
            return "<span class='label label-$class'>".$orden->estado_orden."</span>";
        })
        ->editColumn('tipo_trabajo', function ($orden) {
            return $orden->tipo_trabajo;
        })
        ->addColumn('acciones', function ($orden) {
            $actions = '<a href="edit-orden/'.$orden->id.'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" title="Editar orden"></i></a> ';
            $actions .= '<a href="pagos-by-orden/'.$orden->id.'" class="btn btn-xs btn-info"><i class="fa fa-credit-card" title="Ver pagos"></i></a> ';
            $actions .= '<a href="add-pago-orden/'.$orden->id.'" class="btn btn-xs btn-success"><i class="fa fa-plus" title="Agregar pago"></i></a> ';
            $actions .= '<a href="delete-orden/'.$orden->id.'" class="btn btn-xs btn-danger delReg"><i class="fa fa-trash" title="Eliminar orden"></i></a>';
            return $actions;
        })
        ->setRowAttr([ 'id' => function ($orden) { return $orden->id; } ])
        ->rawColumns(['id','fecha','cliente_id','asunto','importe','estado_pago','estado_orden','tipo_trabajo','acciones'])
        ->make(true);
    }
        
    public function editOrden(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Orden::where(['id'=>$id])->update([
                'cliente_id' => $data['cliente_id'],
                'asunto' => $data['asunto'],
                'descripcion' => $data['descripcion'],
                'importe' => $data['importe'],
                'estado_pago' => $data['estado_pago'],
                'estado_orden' => $data['estado_orden'],
                'tipo_trabajo' => $data['tipo_trabajo'],
            ]);
            return redirect('/admin/view-ordenes')->with('flash_message','Orden actualizada correctamente...');
        }
        $orden = Orden::where(['id'=>$id])->first();
        $clientes = Cliente::where('estado', 1)->pluck('nombre', 'id');
        return view('admin.ordenes.edit_orden')->with(compact('orden', 'clientes'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addOrden(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $orden = new Orden;
            $orden->cliente_id = $data['cliente_id'];
            $orden->asunto = $data['asunto'];
            $orden->descripcion = $data['descripcion'] ?? '';
            $orden->importe = $data['importe'];
            $orden->estado_pago = $data['estado_pago'];
            $orden->estado_orden = $data['estado_orden'];
            $orden->tipo_trabajo = $data['tipo_trabajo'];
            $orden->save();
            return redirect('/admin/view-ordenes')->with('flash_message','Orden creada correctamente...');
        }
        $clientes = Cliente::where('estado', 1)->pluck('nombre', 'id');
        return view('admin.ordenes.add_orden')->with(compact('clientes'));
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteOrden(Request $request, $id = null) {
        if (!empty($id)) {
            Orden::where(['id'=>$id])->delete();
            return redirect('/admin/view-ordenes')->with('flash_message','Orden eliminada...');
        }
        return view('admin.ordenes.view_ordenes');
    }

    /**
     * Get orders by client ID
     */
    public function getOrdenesByCliente($clienteId) {
        $ordenes = Orden::where('cliente_id', $clienteId)
                ->where('estado_orden', '!=', 'Cancelada')
                ->get();
        return response()->json($ordenes);
    }

}
