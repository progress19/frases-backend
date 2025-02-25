<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Config;
use Image;
use App\Fun;

class ConfigController extends Controller {
    
    public function editConfig(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            //upload logo
            if ($request->hasFile('logo')) {
                $image_tmp = $request->file('logo');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(0000000,9999999).'.'.$extension;
                    //Resize image
                    Image::make($image_tmp)->save(Fun::getPathImage('large','config',$filename));
                }
            } else {$filename = $data['current_logo'];}

            //nosotros imagen
            if ($request->hasFile('nosotros_imagen')) {
                $image_tmp = $request->file('nosotros_imagen');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename_nosotros = rand(0000000,9999999).'.'.$extension;
                    //Resize image
                    Image::make($image_tmp)->save(Fun::getPathImage('large','config',$filename_nosotros));
                }
            } else {$filename_nosotros = $data['current_nosotros_imagen'];}
            
            Config::where(['id'=>1])->update([
                'destinatarios' => $data['destinatarios'],
                'usd' => $data['usd'],
                'telefono' => $data['telefono'], 
                'whatsapp' => $data['whatsapp'], 
                'direccion' => $data['direccion'],
                'instagram' => $data['instagram'],
                'facebook' => $data['facebook'], 
                'tiktok' => $data['tiktok'], 
                'youtube' => $data['youtube'],
                'vimeo' => $data['vimeo'], 
                'logo' => $filename,
                'nosotros_es' => $data['nosotros_es'],
                'nosotros_en' => $data['nosotros_en'],
                'nosotros_pr' => $data['nosotros_pr'],
                'nosotros_imagen' => $filename_nosotros,
                'terminos_es' => $data['terminos_es'],
                'terminos_en' => $data['terminos_en'],
                'terminos_pr' => $data['terminos_pr']
            ]);

            return redirect('/admin/dashboard')->with('flash_message','Configuración actualizada correctamente...');
        
        }

        $config = Config::where(['id'=>$id])->first();
        return view('admin.config.edit_config')->with(compact('config'));
    }
}
