<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Config;
use App\ImgsHome;
use App\ApartamentoImagenes;
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

    public function dashboard(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            return redirect('/admin/dashboard')->with('flash_message','Notas actualizadas...');
        }
        $config = Config::where(['id'=>1])->first();
        return view('admin.dashboard')->with(compact('config')); 
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
