<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController; 
use App\Http\Controllers\UsuarioController; 
use App\Http\Controllers\TraduccionController; 
use App\Http\Controllers\ConfigController; 
use App\Http\Controllers\TipoController; 

use App\Http\Controllers\Controller; 
use App\Http\Controllers\HomeController; 


use App\Mail\TestMailable; 

use App\Http\Controllers\FraseController;


Auth::routes();

Route::get('testEmail', function() {
    $correo = new TestMailable;
    Mail::to('mauriciolav@gmail.com')->send($correo);
    return 'Enviado!!!';
});

/* BACKEND */

Route::match(['get', 'post'], 'admin', [AdminController::class, 'login']);
Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('login');
Route::match(['get', 'post'], 'logout', [AdminController::class, 'logout']);

Route::group(['middleware' => ['auth']], function () {
    
	//Route::get('/', function () { return view('admin/dashboard'); });
    //Route::get('/', 'Controller@index');
	Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

	/* DATATABLES */

	Route::get('dataUsuarios', [UsuarioController::class, 'getData'])->name('dataUsuarios');
	Route::get('dataFrases', [FraseController::class, 'getData'])->name('dataFrases');
	Route::get('dataTipos', [TipoController::class, 'getData'])->name('dataTipos');
		
	//cambiar estados desde datatables
	Route::get('cambiarEstado/{id}/{model}', [AdminController::class ,'cambiarEstado']);
			
	Route::get('/admin/settings', 'AdminController@settings');
	Route::get('/admin/edit-user', 'AdminController@editUser');
	Route::get('/admin/check-pwd','AdminController@chkPassword');
	Route::match(['get','post'], '/admin/update-pwd', 'AdminController@updatePassword');
	
	Route::get( 'admin/reset-pwd', [AdminController::class, 'resetPassword']);

	// Usuarios 
	Route::match(['get', 'post'], 'admin/agregar-usuario', [UsuarioController::class, 'addUsuario']);
	Route::match(['get','post'],'/admin/editar-usuario/{id}', [UsuarioController::class, 'editarUsuario']);
	Route::match(['get','post'],'/admin/eliminar-usuario/{id}', [UsuarioController::class, 'eliminarUsuario']);
	Route::get('/admin/ver-usuarios', [UsuarioController::class, 'viewUsuarios']);

	//Config Routes (Admin)
	Route::match(['get','post'],'/admin/edit-config/{id}', [ConfigController::class, 'editConfig']);

	//Frases (Admin)
	Route::match(['get','post'],'/admin/edit-frase/{id}',[FraseController::class, 'editFrase']);
	Route::match(['get','post'],'/admin/delete-frase/{id}',[FraseController::class, 'deleteFrase']);
	Route::match(['get', 'post'], 'admin/add-frase', [FraseController::class, 'addFrase']);
	Route::get('/admin/view-frases',[FraseController::class, 'viewFrases']);

	//Tipos (Admin)
	Route::match(['get','post'],'/admin/add-tipo',[TipoController::class, 'addTipo']);
	Route::match(['get','post'],'/admin/edit-tipo/{id}',[TipoController::class, 'editTipo']);
	Route::match(['get','post'],'/admin/delete-tipo/{id}',[TipoController::class, 'deleteTipo']);
	Route::get('/admin/view-tipos',[TipoController::class, 'viewTipos']);
	
});

Route::post('/proxy/deepl', [TraduccionController::class, 'translate']);

/* FRONTEND */

Route::redirect('/', app()->getLocale());

Route::get('/home', [HomeController::class, 'index']);

Route::get('/frase-aleatoria', [FraseController::class, 'aleatoria']);

Route::get('/frase-general', [FraseController::class, 'fraseGeneral']);
Route::get('/frase-budista', [FraseController::class, 'fraseBudista']);
Route::get('/frase-estoica', [FraseController::class, 'fraseEstoica']);
Route::get('/frase-metafisica', [FraseController::class, 'fraseMetafisica']);


