<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Fun;
use App\Traduccion;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class TraduccionController extends Controller {

    public function viewTraducciones() {
        $traducciones = Traduccion::orderBy('es','desc')->get();
        return view('admin.traducciones.view_traducciones')->with(compact('traducciones'));
    }

    public function getData() {
      
        $traducciones = Traduccion::select()->orderBy('es', 'asc');

        return Datatables::of($traducciones)
     
            ->addColumn('es', function ($traduccion) {
                return "<a title='Clic para editar...' href='edit-traduccion/$traduccion->id'> ".Str::limit($traduccion->es, 50)." </a>"; 
            })
            ->editColumn('en_raw', function ($traduccion) {
                return "<a title='Clic para editar...' href='edit-traduccion/$traduccion->id'> ".Str::limit($traduccion->en, 30)." </a>"; 
            })
            ->editColumn('pr_raw', function ($traduccion) {
                return "<a title='Clic para editar...' href='edit-traduccion/$traduccion->id'> ".Str::limit($traduccion->pr, 30)." </a>"; 
            })
            
            ->editColumn('estado', function ($traduccion) {
                return Fun::getIconStatus($traduccion->estado); 
            })

            ->addColumn('acciones', function ($traduccion) {
                return "<a href='delete-traduccion/$traduccion->id' class='delReg'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";               
            })

            ->rawColumns(['es','en_raw','pr_raw','estado','acciones'])
            ->make(true);
    }
    
    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    
    public function addTraduccion(Request $request) {
    	
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$traduccion = new Traduccion;
    		$traduccion->es = $data['es'];
            $traduccion->en = $data['en'];
            $traduccion->pr = $data['pr'];
					
    		$traduccion->save();
    		return redirect('/admin/view-traducciones')->with('flash_message','Traducción creada correctamente...');
    	}
        return view('admin.traducciones.add_traduccion');
    }

    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editTraduccion(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Traduccion::where(['id'=>$id])->update([
                    'es' => $data['es'],
                    'en' => $data['en'],
                    'pr' => $data['pr'],
                ]);
            return redirect('/admin/view-traducciones')->with('flash_message','Traducción actualizada correctamente...');
        }
        $traduccion = Traduccion::where(['id'=>$id])->first();
        return view('admin.traducciones.edit_traduccion')->with(compact('traduccion'));
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteTraduccion(Request $request, $id = null) {

        if (!empty($id)) {
            Traduccion::where(['id'=>$id])->delete();
            return redirect('/admin/view-traducciones')->with('flash_message','Traducción eliminada...');
        }

        $traducciones = Traduccion::get();
        return view('admin.traducciones.view_paises')->with(compact('traducciones'));
    
    }

    public function translate(Request $request) {
        $data = $request->validate([
            'text' => 'required|array',
            'source_lang' => 'required|string',
            'target_lang' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'DeepL-Auth-Key ' . env('DEEPL_API_KEY'),
        ])->post('https://api-free.deepl.com/v2/translate', [
            'text' => $data['text'],
            'source_lang' => $data['source_lang'],
            'target_lang' => $data['target_lang'],
        ]);

        return response()->json($response->json());
    }


}
