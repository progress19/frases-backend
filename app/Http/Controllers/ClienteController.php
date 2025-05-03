<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cliente;
use App\Fun;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class ClienteController extends Controller {

    public function viewClientes() {
        return view('admin.clientes.view_clientes');
    }
    
    /********************************************************************************************/
    /************************************ GET DATA **********************************************/
    
    public function getData() {
        $clientes = Cliente::select();
        return Datatables::of($clientes)
        ->editColumn('id', function ($cliente) {
            return "<a class='btn-table hvr-grow' href='edit-cliente/$cliente->id'>$cliente->id</a>"; 
        })
        ->editColumn('nombre', function ($cliente) {
            return "<a title='Clic para editar...' href='edit-cliente/$cliente->id'>  ".Str::limit($cliente->nombre, 80)." </a>"; 
        })
        ->editColumn('email', function ($cliente) {
            return $cliente->email; 
        })
        ->editColumn('cuit', function ($cliente) {
            return $cliente->cuit; 
        })
        ->editColumn('estado', function ($cliente) {
            $checked = $cliente->estado ? 'checked' : '';
            $model = "Cliente";
            return '<input type="checkbox" '.$checked.' class="estado-chk" onchange="elif('.$cliente->id.', \''.$model.'\')" />';
        })
        ->editColumn('acciones', function ($cliente) {
            return '<a href="delete-cliente/'.$cliente->id.'" class="delReg"><i class="fa fa-trash" title="Eliminar registro"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($cliente) { return $cliente->id; } ])
        ->rawColumns(['id','nombre','email','cuit','estado','acciones'])
        ->make(true);
    }
        
    public function editCliente(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Cliente::where(['id'=>$id])->update([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'cuit' => $data['cuit'],
                'domicilio' => $data['domicilio'],
            ]);
            return redirect('/admin/view-clientes')->with('flash_message','Cliente actualizado correctamente...');
        }
        $cliente = Cliente::where(['id'=>$id])->first();
        return view('admin.clientes.edit_cliente')->with(compact('cliente'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addCliente(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $cliente = new Cliente;
            $cliente->nombre = $data['nombre'];
            $cliente->email = $data['email'] ?? '';
            $cliente->cuit = $data['cuit'] ?? '';
            $cliente->domicilio = $data['domicilio'] ?? '';
            $cliente->estado = 1;
            $cliente->save();
            return redirect('/admin/view-clientes')->with('flash_message','Cliente creado correctamente...');
        }
        return view('admin.clientes.add_cliente');
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteCliente(Request $request, $id = null) {
        if (!empty($id)) {
            Cliente::where(['id'=>$id])->delete();
            return redirect('/admin/view-clientes')->with('flash_message','Cliente eliminado...');
        }
        return view('admin.clientes.view_clientes');
    }

}
