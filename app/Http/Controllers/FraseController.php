<?php

namespace App\Http\Controllers;

use App\Models\Frase;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Fun;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FraseController extends Controller
{

    public function viewFrases() {
        return view('admin.frases.view_frases');
    }

    public function getData() {
        $frases = Frase::select();
        return Datatables::of($frases)
        ->editColumn('frase', function ($frase) {
            return "<a title='Clic para editar...' href='edit-frase/$frase->id'>  ".Str::limit($frase->frase, 150)." </a>"; 
        })
        ->editColumn('acciones', function ($frase) {
            return '<a href="delete-frase/'.$frase->id.'" class="delReg"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($frase) { return $frase->id; } ])
        ->rawColumns(['id','frase','acciones'])
        ->make(true);
    }

    public function aleatoria(): JsonResponse
    {
        $frase = Frase::inRandomOrder()->first();
        return response()->json([
            'frase' => $frase ? $frase->frase : 'No hay frases disponibles en este momento.',
        ]);
    }

    public function editFrase(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Frase::where(['id'=>$id])->update([
                'frase' => $data['frase'],  
            ]);
            return redirect('/admin/view-frases')->with('flash_message','Frase actualizada correctamente...');
        }
        $frase = Frase::where(['id'=>$id])->first();
        return view('admin.frases.edit_frase')->with(compact('frase'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addFrase(Request $request) {
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		$opinion = new Frase;
            $opinion->frase = $data['frase'];
    		$opinion->save();
    		return redirect('/admin/view-frases')->with('flash_message','Frase creada correctamente...');
    	}
        return view('admin.frases.add_frase');
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteFrase(Request $request, $id = null) {
        if (!empty($id)) {
            Frase::where(['id'=>$id])->delete();
            return redirect('/admin/view-frases')->with('flash_message','Frase eliminada...');
        }
        return view('admin.frase.view_frases');
    }

}
