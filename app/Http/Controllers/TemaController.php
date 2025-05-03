<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Tema;
use App\Fun;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class TemaController extends Controller {

    public function viewTemas() {
        return view('admin.temas.view_temas');
    }
    
    /********************************************************************************************/
    /************************************ GET DATA **********************************************/
    
    public function getData() {
        $temas = Tema::select();
        return Datatables::of($temas)
        ->editColumn('id', function ($tema) {
            return "<a class='btn-table hvr-grow' href='edit-tema/$tema->id'>$tema->id</a>"; 
        })
        ->editColumn('nombre', function ($tema) {
            return "<a title='Clic para editar...' href='edit-tema/$tema->id'>  ".Str::limit($tema->nombre, 80)." </a>"; 
        })
        ->editColumn('estado', function ($tema) {
            $checked = $tema->estado ? 'checked' : '';
            $model = "Tema";
            return '<input type="checkbox" '.$checked.' class="estado-chk" onchange="elif('.$tema->id.', \''.$model.'\')" />';
        })
        ->editColumn('acciones', function ($tema) {
            return '<a href="delete-tema/'.$tema->id.'" class="delReg"><i class="fa fa-trash" title="Eliminar registro"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($tema) { return $tema->id; } ])
        ->rawColumns(['id','nombre','estado','acciones'])
        ->make(true);
    }
        
    public function editTema(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Tema::where(['id'=>$id])->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],  
            ]);
            return redirect('/admin/view-temas')->with('flash_message','Tema actualizado correctamente...');
        }
        $tema = Tema::where(['id'=>$id])->first();
        return view('admin.temas.edit_tema')->with(compact('tema'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addTema(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $tema = new Tema;
            $tema->nombre = $data['nombre'];
            $tema->descripcion = $data['descripcion'] ?? '';
            $tema->estado = 1;
            $tema->save();
            return redirect('/admin/view-temas')->with('flash_message','Tema creado correctamente...');
        }
        return view('admin.temas.add_tema');
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteTema(Request $request, $id = null) {
        if (!empty($id)) {
            Tema::where(['id'=>$id])->delete();
            return redirect('/admin/view-temas')->with('flash_message','Tema eliminado...');
        }
        return view('admin.temas.view_temas');
    }

}
