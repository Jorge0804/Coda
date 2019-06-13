<?php
use Illuminate\Http\Request;
use App\Reporte_mensual;

/*Rutas del usuario*/
Route::get('/home', 'controller@Home')->name('inicio');
Route::get('/', 'UsuarioController@mostrarformlogin')->name('login');
Route::get('/FormRegistro', 'UsuarioController@mostrarformregistro');
Route::post('/Registrar', 'UsuarioController@registrar');
Route::post('/Iniciar', 'UsuarioController@iniciarsesion');
Route::get('/CerrarSesion', 'UsuarioController@CerrarSesion');

/*Rutas para graficas*/
Route::get('/graficas', 'controller@graficas');

/*Rutas de cotizaciones*/
Route::get('/CotiRegistradas', 'controller@vercoti');
Route::get('/mensuales', 'controller@mostrarmensuales');
Route::get('/formRegistrarCotiMensual', 'CotizacionController@FormrRegistrarMensual');
Route::get('prueba', function() {
    return view('vistas.pruebaexcel');
});
Route::post('/Resumenes', 'CotizacionController@SacarResumenMensual');
Route::get('/RegistrarMensual', 'CotizacionController@RegistrarMensual');
Route::get('/FormCotizar', 'CotizacionController@FormCotizar');

Route::get('/importarexcel', 'ExcelController@importar');