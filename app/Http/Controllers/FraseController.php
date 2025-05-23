<?php

namespace App\Http\Controllers;

use App\Models\Frase;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Fun;
use App\Tipo;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FraseController extends Controller
{

    public function viewFrases() {
        $tipos = Tipo::where(['estado' => 1])->orderBy('nombre', 'asc')->pluck( 'nombre', 'id');

        return view('admin.frases.view_frases')->with(compact('tipos'));
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
        $minCount = Frase::min('count');
        $frase = Frase::where('count', $minCount)
                      ->inRandomOrder()
                      ->first();
        
        if ($frase) {
            $frase->increment('count');
        }

        return response()->json([
            'frase' => $frase ? $frase->frase : 'No hay frases disponibles en este momento.',
        ]);
    }

    public function editFrase(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();

            /* save Tipos */
            $datenow = Carbon::now();
            $frase = Frase::find($id)->tipos()->detach();

            if ($request->tipos) {
                $frase = Frase::find($id);
                foreach ($request->tipos as $idtipo) {
                    $frase->tipos()->attach($idtipo, ['created_at' => $datenow]);
                }
            }

            Frase::where(['id'=>$id])->update([
                'frase' => $data['frase'],  
            ]);
            return redirect('/admin/view-frases')->with('flash_message','Frase actualizada correctamente...');
        }

        $tipos = Tipo::where(['estado' => 1])->orderBy('nombre', 'asc')->get();
        $frase = Frase::where(['id'=>$id])->first();
        return view('admin.frases.edit_frase')->with(compact('frase','tipos'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    public function addFrase(Request $request) {
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		$frase = new Frase;
            $frase->frase = $data['frase'];
    		$frase->save();

            /* Tipos */

            $datenow = Carbon::now();

            if ($request->tipos) {
                foreach ($request->tipos as $idtipo) {
                    $frase->tipos()->attach($idtipo, ['created_at' => $datenow]);
                }
            }

    		return redirect('/admin/view-frases')->with('flash_message','Frase creada correctamente...');
    	}
        $tipos = Tipo::where(['estado' => 1])->orderBy('nombre', 'asc')->get();
        return view('admin.frases.add_frase')->with(compact('tipos'));
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

    public function frasePorTipo($tipoNombre): JsonResponse
    {
        $minCount = Frase::whereHas('tipos', function($query) use ($tipoNombre) {
            $query->where('nombre', $tipoNombre);
        })->min('count');

        $frase = Frase::whereHas('tipos', function($query) use ($tipoNombre) {
            $query->where('nombre', $tipoNombre);
        })
        ->where('count', $minCount)
        ->inRandomOrder()
        ->first();

        if ($frase) {
            $frase->increment('count');
        }

        return response()->json([
            'frase' => $frase ? $frase->frase : "No hay frases {$tipoNombre}s disponibles en este momento.",
        ]);
    }

    public function fraseGeneral(): JsonResponse
    {
        return $this->frasePorTipo('general');
    }

    public function fraseBudista(): JsonResponse
    {
        return $this->frasePorTipo('budista');
    }

    public function fraseEstoica(): JsonResponse
    {
        return $this->frasePorTipo('estoica');
    }

    public function fraseMetafisica(): JsonResponse
    {
        return $this->frasePorTipo('metafisica');
    }

    public function getDataByTipo(Request $request) 
    {
        $tipo_id = $request->get('tipo');
        
        $frases = Frase::select('frases.*')
            ->when($tipo_id, function($query) use ($tipo_id) {
                return $query->join('frases_pivot_tipos', 'frases.id', '=', 'frases_pivot_tipos.frase_id')
                            ->where('frases_pivot_tipos.tipo_id', $tipo_id);
            });

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

}
