<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats()
    {
        $user = Auth::user();
        $stats = [];
        
        if ($user->rol == 1 || $user->rol == 3) { // Admin o supervisor
            // Estadísticas de órdenes
            $stats['total']        = Orden::count();
            $stats['inWorkshop']   = Orden::where('estado', 1)->count();
            $stats['closed']       = Orden::where('estado', 2)->count();
        
            // Estadísticas de usuarios (sin cambios)
            $stats['activeUsers'] = User::where('estado', 1)->count();
            $stats['onlineUsers'] = User::where('estado', 1)
                ->where('last_activity_at', '>=', Carbon::now()->subMinutes(10))
                ->count();
        } else {
            // Para usuarios normales, solo mostrar sus órdenes
            $stats['total']      = Orden::where('id_usuario', $user->id)->count();
            $stats['inWorkshop'] = Orden::where('id_usuario', $user->id)->where('estado', 1)->count();
            $stats['closed']     = Orden::where('id_usuario', $user->id)->where('estado', 2)->count();
            $stats['activeUsers'] = User::where('estado', 1)->count();
            $stats['onlineUsers'] = User::where('estado', 1)
                ->where('last_activity_at', '>=', Carbon::now()->subMinutes(10))
                ->count();
        }

        return response()->json($stats);
    }

    public function getOrdenStats(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', '30');
        
        if ($range !== 'all') {
            $days = intval($range);
            $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } else {
            // Para "all", limitamos a los últimos 12 meses para evitar datos históricos excesivos
            $startDate = Carbon::now()->startOfMonth()->subMonths(11)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $days = null;
        }

        // Usamos el campo fecha en lugar de created_at para agrupar las órdenes
        $query = Orden::selectRaw('DATE(fecha) as date, COUNT(*) as count')
                      ->whereBetween('fecha', [$startDate, $endDate]);
                      
        if (!in_array($user->rol, [1, 3])) {
            $query->where('id_usuario', $user->id);
        }
        
        $data = $query->groupBy('date')->orderBy('date')->get();

        // Debug: log para verificar los datos antes de procesarlos
        \Log::info('Orden stats query data', ['data' => $data->toArray()]);

        // Prepare result array, filling zeros for missing dates within the specified range
        if ($range !== 'all' && $days) {
            $stats = [];
            for ($i = 0; $i < $days; $i++) {
                $date = Carbon::now()->subDays($days - 1 - $i)->format('Y-m-d');
                $stats[$date] = 0;
            }
            foreach ($data as $row) {
                if (isset($stats[$row->date])) {
                    $stats[$row->date] = (int)$row->count; // Convertimos a entero para asegurar formato correcto
                }
            }
            $result = [];
            foreach ($stats as $date => $count) {
                $result[] = ['date' => $date, 'count' => $count];
            }
        } else {
            $result = $data->map(function($item) {
                return ['date' => $item->date, 'count' => (int)$item->count]; // Convertimos a entero
            })->toArray();
        }

        // Debug: log para verificar los resultados finales
        \Log::info('Orden stats final result', ['result' => $result]);

        return response()->json($result);
    }

    public function getImporteStats(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', '30');
        
        if ($range !== 'all') {
            $days = intval($range);
            $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } else {
            // Para "all", limitamos a los últimos 12 meses para evitar datos históricos excesivos
            $startDate = Carbon::now()->startOfMonth()->subMonths(11)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $days = null;
        }

        // Usamos el campo fecha para agrupar y sumamos el campo importe
        $query = Orden::selectRaw('DATE(fecha) as date, SUM(importe) as total')
                      ->whereBetween('fecha', [$startDate, $endDate]);
                      
        if (!in_array($user->rol, [1, 3])) {
            $query->where('id_usuario', $user->id);
        }
        
        $data = $query->groupBy('date')->orderBy('date')->get();

        // Debug: log para verificar los datos antes de procesarlos
        \Log::info('Importe stats query data', ['data' => $data->toArray()]);

        // Prepare result array, filling zeros for missing dates within the specified range
        if ($range !== 'all' && $days) {
            $stats = [];
            for ($i = 0; $i < $days; $i++) {
                $date = Carbon::now()->subDays($days - 1 - $i)->format('Y-m-d');
                $stats[$date] = 0;
            }
            foreach ($data as $row) {
                if (isset($stats[$row->date])) {
                    $stats[$row->date] = (float)$row->total; // Convertimos a float para asegurar formato correcto
                }
            }
            $result = [];
            foreach ($stats as $date => $total) {
                $result[] = ['date' => $date, 'total' => $total];
            }
        } else {
            $result = $data->map(function($item) {
                return ['date' => $item->date, 'total' => (float)$item->total]; // Convertimos a float
            })->toArray();
        }

        // Debug: log para verificar los resultados finales
        \Log::info('Importe stats final result', ['result' => $result]);

        return response()->json($result);
    }

}