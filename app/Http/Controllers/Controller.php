<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Apartamento;
use App\Fun;
use App\Config;
use App;
use App\Suscripcion;
use App\Opinion;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Session;
use App\Mail\ContactoMailable; 

class Controller extends BaseController {
    
    //use AuthorizesRequests, ValidatesRequests;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $config = Config::where(['id'=>1])->first();
                
        return view('home')->with([ 
            'config' => $config,   
                ]);
    }

    function obtenerNumeros($string) { return preg_replace('/[^0-9]/', '', $string); }

    public function enviarContacto(Request $request) {
        App::setLocale($request->locale);
        $data = $request->all();
        if ( isset($_REQUEST['suscribirme']) ) {
            $sus = DB::table('suscripciones')->where('email', $request->email)->get();
            if (count($sus) == 0) {
                $suscripcion = new Suscripcion;
                $suscripcion->email = $request->email;
                $suscripcion->save();
            }
        }

        /* email send */
        $correo = new ContactoMailable( $data );

        //destinatarios
        $config = Config::where( ['id'=>1] )->first();
        $destinatarios = explode(',', $config->destinatarios);
        $ccEmails = array_map('trim', $destinatarios);
        Mail::to($request->email)->cc($ccEmails)->send($correo);
        return '<div class="text-white text-center animate__animated animate__fadeIn" style="padding-top:40px"><span style="font-size:30px"><i class="fas fa-check"></i></span><br>'.__("trans.Gracias por su consulta!").' </div>';
    }

}
