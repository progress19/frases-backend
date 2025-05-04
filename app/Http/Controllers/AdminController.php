<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Config;
use App\ImgsHome;
use App\ApartamentoImagenes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller {

    public function cambiarEstado($id,$model) {
        $modelName = "App\\".$model; 
        $model = new $modelName();
        $registro = $model::find($id);
        if ($registro->estado == 1) {$registro->estado = 0;} else {$registro->estado = 1;}
        $registro->save();
    }
    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'] ])) {
                if (Auth::user()->estado==1) {
                    Session::put('adminSession', $data['email']);
                    return redirect('/admin/dashboard')->with('flash_message','Bienvenido, '.Auth::user()->name.' :)');
                } else {
                    return redirect('/admin')->with('flash_message','Usuario desactivado');
                }
            } else {
            	return redirect('/admin')->with('flash_message','Usuario o contraseña incorrecta.');
            }
    	}
    	return view('admin.admin_login');
    }

    public function dashboard() {
        // Total count of phrases
        $frases = \App\Models\Frase::count();

        // Sum of all count values (total times phrases have been shown)
        $frases_mostradas = \App\Models\Frase::sum('count');

        // Get all types with their phrase counts
        $tipos = \App\Tipo::where('estado', 1)->get();

        // For each type, calculate the total phrases and total count values
        foreach ($tipos as $tipo) {
            // Count all phrases of this type
            $tipo->total_frases = $tipo->belongsToMany(\App\Models\Frase::class, 'frases_pivot_tipos', 'tipo_id', 'frase_id')->count();

            // Sum the count values of all phrases of this type
            $tipo->frases_mostradas = $tipo->belongsToMany(\App\Models\Frase::class, 'frases_pivot_tipos', 'tipo_id', 'frase_id')
                ->sum('frases.count');
        }

        // Estadísticas básicas para el dashboard
        $basicStats = [
            'totalOrdenes' => \App\Models\Orden::count(),
            'ordenesCompletadas' => \App\Models\Orden::where('estado_orden', 'Completada')->count(),
            'ordenesPendientes' => \App\Models\Orden::where('estado_orden', 'Pendiente')->count(),
            'ordenesEnProgreso' => \App\Models\Orden::where('estado_orden', 'En progreso')->count(),
            'ordenesCanceladas' => \App\Models\Orden::where('estado_orden', 'Cancelada')->count(),
            'ingresosTotal' => \App\Models\Orden::sum('importe'),
            'clientes' => \App\Models\Cliente::where('estado', 1)->count(),
            'activeUsers' => \App\User::where('estado', 1)->count(),
            'onlineUsers' => \App\User::where('estado', 1)->count()
        ];

        return view('admin.dashboard', compact('frases', 'frases_mostradas', 'tipos', 'basicStats'));
    }

    /**
     * Get statistics for the dashboard
     */
    public function getStats()
    {
        $stats = [
            'totalOrdenes' => \App\Models\Orden::count(),
            'ordenesCompletadas' => \App\Models\Orden::where('estado_orden', 'Completada')->count(),
            'ordenesPendientes' => \App\Models\Orden::where('estado_orden', 'Pendiente')->count(),
            'ordenesEnProgreso' => \App\Models\Orden::where('estado_orden', 'En progreso')->count(),
            'ordenesCanceladas' => \App\Models\Orden::where('estado_orden', 'Cancelada')->count(),
            'ingresosTotal' => \App\Models\Orden::sum('importe'),
            'clientes' => \App\Models\Cliente::where('estado', 1)->count(),
            'activeUsers' => \App\User::where('estado', 1)->count(),
            'onlineUsers' => \App\User::where('estado', 1)->count()
        ];

        return response()->json($stats);
    }

    /**
     * Get order statistics by date for the dashboard chart
     */
    public function getOrdenStats(Request $request)
    {
        $range = $request->get('range', '30');
        
        if ($range !== 'all') {
            $days = intval($range);
            $startDate = \Carbon\Carbon::now()->subDays($days - 1)->startOfDay();
            $endDate = \Carbon\Carbon::now()->endOfDay();
        } else {
            // Para "all", limitamos a los últimos 12 meses
            $startDate = \Carbon\Carbon::now()->startOfMonth()->subMonths(11)->startOfDay();
            $endDate = \Carbon\Carbon::now()->endOfDay();
            $days = null;
        }

        // Usamos el campo fecha para agrupar las órdenes
        $query = \App\Models\Orden::selectRaw('DATE(fecha) as date, COUNT(*) as count')
                      ->whereBetween('fecha', [$startDate, $endDate])
                      ->groupBy('date')
                      ->orderBy('date');
        
        $data = $query->get();

        // Preparamos el array de resultados, rellenando con ceros las fechas sin órdenes
        if ($range !== 'all' && $days) {
            $stats = [];
            for ($i = 0; $i < $days; $i++) {
                $date = \Carbon\Carbon::now()->subDays($days - 1 - $i)->format('Y-m-d');
                $stats[$date] = 0;
            }
            foreach ($data as $row) {
                if (isset($stats[$row->date])) {
                    $stats[$row->date] = (int)$row->count;
                }
            }
            $result = [];
            foreach ($stats as $date => $count) {
                $result[] = ['date' => $date, 'count' => $count];
            }
        } else {
            $result = $data->map(function($item) {
                return ['date' => $item->date, 'count' => (int)$item->count];
            })->toArray();
        }

        return response()->json($result);
    }

    /**
     * Obtener estadísticas de importes por día para el dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImporteStats(Request $request)
    {
        $range = $request->input('range', '30');
        
        // Determinamos la fecha de inicio basada en el rango solicitado
        $startDate = now();
        if ($range !== 'all') {
            $startDate = now()->subDays($range);
        } else {
            // Si es "all", tomamos los últimos 180 días como máximo
            $startDate = now()->subDays(180);
        }
        
        // Consultamos los importes totales por día
        $stats = DB::table('ordenes')
            ->select(DB::raw('DATE(fecha) as date, SUM(importe) as total'))
            ->where('fecha', '>=', $startDate->startOfDay())
            ->groupBy(DB::raw('DATE(fecha)'))
            ->orderBy('date', 'ASC')
            ->get();
        
        return response()->json($stats);
    }

    public function settings() {
        return view('admin.settings');
    }

    public function editUser() {
        return view('admin.settings');
    }

    public function logout() {
        Session::flush();
        return redirect('/admin')->with('flash_message','Logout OK');
    }

    public function chkPassword(Request $request) {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $check_password = User::where(['admin'=>1])->first();
        if (Hash::check($current_password,$check_password->password)) {
            echo 'true'; 
        } else {
            echo 'false'; 
        }
    }


    public function updatePassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $check_password = User::where(['email' => Auth::user()->email])->first();
            $current_password = $data['current_pwd'];
            
            if (Hash::check($current_password,$check_password->password)) {
                $password = bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                Session::put('flash_message', 'Contraseña actualizada correctamente!');
                return '1';
            } else {
                Session::put('flash_message', 'La contraseña actual es incorrecta.');
                return '0';
            }
        }
    }

    public function resetPassword(Request $request) {
        $data = $request->all();
        $password = bcrypt( $data['new_password'] );
        $user = User::where( [ 'id' => $data['id'] ] )->update( ['password' => $password] );
        if ($user) {
            echo '1';
        } else {
            echo '0';
        }
    }
}
