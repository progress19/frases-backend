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
use App\Http\Controllers\PostController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;

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

	Route::get('dataFrasesTipo', [FraseController::class, 'getDataByTipo'])->name('dataFrasesTipo');

	Route::get('dataTipos', [TipoController::class, 'getData'])->name('dataTipos');
	Route::get('dataPosts', [PostController::class, 'getData'])->name('dataPosts');
	Route::get('dataPostsTema', [PostController::class, 'getDataByTema'])->name('dataPostsTema');
	Route::get('dataTemas', [TemaController::class, 'getData'])->name('dataTemas');
	Route::get('dataClientes', [ClienteController::class, 'getData'])->name('dataClientes');
	Route::get('dataOrdenes', [OrdenController::class, 'getData'])->name('dataOrdenes');
	Route::get('dataPagos', [PagoController::class, 'getPagos'])->name('dataPagos');
		
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
	
	//Temas (Admin)
	Route::match(['get','post'],'/admin/add-tema',[TemaController::class, 'addTema']);
	Route::match(['get','post'],'/admin/edit-tema/{id}',[TemaController::class, 'editTema']);
	Route::match(['get','post'],'/admin/delete-tema/{id}',[TemaController::class, 'deleteTema']);
	Route::get('/admin/view-temas',[TemaController::class, 'viewTemas']);
	
	//Blog Posts (Admin)
	Route::match(['get','post'],'/admin/add-post',[PostController::class, 'addPost']);
	Route::match(['get','post'],'/admin/edit-post/{id}',[PostController::class, 'editPost']);
	Route::match(['get','post'],'/admin/delete-post/{id}',[PostController::class, 'deletePost']);
	Route::get('/admin/view-posts',[PostController::class, 'viewPosts']);
	
	//Clientes (Admin)
	Route::match(['get','post'],'/admin/add-cliente',[ClienteController::class, 'addCliente']);
	Route::match(['get','post'],'/admin/edit-cliente/{id}',[ClienteController::class, 'editCliente']);
	Route::match(['get','post'],'/admin/delete-cliente/{id}',[ClienteController::class, 'deleteCliente']);
	Route::get('/admin/view-clientes',[ClienteController::class, 'viewClientes']);
	
	//Órdenes (Admin)
	Route::match(['get','post'],'/admin/add-orden',[OrdenController::class, 'addOrden']);
	Route::match(['get','post'],'/admin/edit-orden/{id}',[OrdenController::class, 'editOrden']);
	Route::match(['get','post'],'/admin/delete-orden/{id}',[OrdenController::class, 'deleteOrden']);
	Route::get('/admin/view-ordenes',[OrdenController::class, 'viewOrdenes']);
	Route::get('/admin/get-ordenes-by-cliente/{id}',[OrdenController::class, 'getOrdenesByCliente']);
	
	//Pagos (Admin)
	Route::match(['get','post'],'/admin/add-pago',[PagoController::class, 'addPago']);
	Route::match(['get','post'],'/admin/add-pago-orden/{id}',[PagoController::class, 'addPagoOrden']);
	Route::match(['get','post'],'/admin/edit-pago/{id}',[PagoController::class, 'editPago']);
	Route::match(['get','post'],'/admin/delete-pago/{id}',[PagoController::class, 'deletePago']);
	Route::get('/admin/view-pagos',[PagoController::class, 'index']);
	Route::get('/admin/pagos-by-orden/{id}',[PagoController::class, 'pagosByOrden']);
	Route::get('/admin/pagos-by-cliente/{id}',[PagoController::class, 'pagosByCliente']);
	
});

Route::post('/proxy/deepl', [TraduccionController::class, 'translate']);

/* FRONTEND */

//Route::redirect('/', app()->getLocale());

Route::get('/home', [HomeController::class, 'index']);

Route::get('/frase-aleatoria', [FraseController::class, 'aleatoria']);

Route::get('/frase-general', [FraseController::class, 'fraseGeneral']);
Route::get('/frase-budista', [FraseController::class, 'fraseBudista']);
Route::get('/frase-estoica', [FraseController::class, 'fraseEstoica']);
Route::get('/frase-metafisica', [FraseController::class, 'fraseMetafisica']);


