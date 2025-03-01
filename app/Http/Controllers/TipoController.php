<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Tipo;
use App\Fun;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TipoController extends Controller {

    public function viewTipos() {
        return view('admin.tipos.view_tipos');
    }
    
    /********************************************************************************************/
    /************************************ GET DATA **********************************************/
    
    public function getData() {
        $tipos = Tipo::select();
        return Datatables::of($tipos)
        ->editColumn('id', function ($tipo) {
            return "<a class='btn-table hvr-grow' href='edit-tipo/$tipo->id'>$tipo->id</a>"; 
        })
        ->editColumn('nombre', function ($tipo) {
            return "<a title='Clic para editar...' href='edit-tipo/$tipo->id'>  ".Str::limit($tipo->nombre, 80)." </a>"; 
        })
        ->editColumn('estado', function ($tipo) {
            $checked = $tipo->estado ? 'checked' : '';
            $model = "Tipo";
            return '<input type="checkbox" '.$checked.' class="estado-chk" onchange="elif('.$tipo->id.', \''.$model.'\')" />';
        })
        ->editColumn('acciones', function ($tipo) {
            return '<a href="delete-tipo/'.$tipo->id.'" class="delReg"><i class="fa fa-trash" title="Eliminar registro"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($tipo) { return $tipo->id; } ])
        ->rawColumns(['id','nombre','estado','acciones'])
        ->make(true);
    }
        
    public function editTipo(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Tipo::where(['id'=>$id])->update([
                'nombre' => $data['nombre'],  
            ]);
            return redirect('/admin/view-tipos')->with('flash_message','Tipo actualizado correctamente...');
        }
        $tipo = Tipo::where(['id'=>$id])->first();
        return view('admin.tipos.edit_tipo')->with(compact('tipo'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addTipo(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $tipo = new Tipo;
            $tipo->nombre = $data['nombre'];
            $tipo->save();
            return redirect('/admin/view-tipos')->with('flash_message','Tipo creado correctamente...');
        }
        return view('admin.tipos.add_tipo');
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteTipo(Request $request, $id = null) {
        if (!empty($id)) {
            Tipo::where(['id'=>$id])->delete();
            return redirect('/admin/view-tipos')->with('flash_message','Tipo eliminado...');
        }
        return view('admin.tipos.view_tipos');
    }

}
