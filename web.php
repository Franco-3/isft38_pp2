<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Confirmacion;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//-----   IMPORTANTE!!  -----   IMPORTANTE!!  -----   IMPORTANTE!!   -----//
//  NO modificar web.php, hacer los cambios en los archivos de cada equipo
//  que están en la carpeta routes.
//  Cada archivo tiene el nombre de los responsables.
//                       Gracias!
//                                              Gisela
//------------------------------------------------------------------------//

//Noticias-> Gisela
Route::group([], __DIR__ . '/blog.php');

//Inicio-> Iván, Martín
Route::group([], __DIR__ . '/inicio.php');

//Carrera-> Iván, Martín
Route::group([], __DIR__ . '/carrera.php');

//Materia-> Iván, Martín
Route::group([], __DIR__ . '/materia.php');

//Programa-> Alejandro, Brian
Route::group([], __DIR__ . '/programa.php');

//Horario y Módulo horario-> Aylén, Sofía, Ulises
Route::group([], __DIR__ . '/horario.php');

//Comision y Año-> Aylén, Sofía, Ulises
Route::group([], __DIR__ . '/comision.php');

//Profesor-> Aylén, Sofía, Ulises
Route::group([], __DIR__ . '/profesor.php');

//Historia y Objetivo-> Alejo, Esteban
Route::group([], __DIR__ . '/historia.php');

//Contacto y Sede-> Alejo, Esteban
Route::group([], __DIR__ . '/contacto.php');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/formulario', [FormularioController::class, 'mostrarFormulario'])->name('formulario');

Route::post('/procesar-formulario', [FormularioController::class, 'procesarFormulario'])->name('procesarFormulario');

//Route::post('/guardar-formulario', [FormularioController::class, 'guardar'])->name('guardarFormulario');

//Route::post('/guardar-configuracion', [AdmiController::class, 'guardarConfiguracion'])->name('guardarConfiguracion');

//Route::get('/confirmacion', [AdminController::class, 'confirmacion'])->name('confirmacion');

Route::get('/formulario', [HorariosController::class, 'mostrarFormulario'])->name('mostrarFormulario');

Route::post('/guardar-horarios', [HorariosController::class, 'guardarHorarios'])->name('guardarHorarios');

Route::get('/inscribirse', [HorariosController::class, 'mostrarInscribirse'])->name('inscribirse');

Route::post('/guardarTurno', [HorariosController::class, 'guardarTurno'])->name('guardarTurno');

Route::get('/tablainscripciones', [InscripcionesController::class, 'tablaInscripciones'])->name('tablainscripciones');
Route::get('/tablainscripciones', [InscripcionesController::class, 'index'])->name('tablainscripciones.index');
Route::get('/tablainscripciones/create', [InscripcionesController::class, 'create'])->name('tablainscripciones.create');
Route::post('/tablainscripciones', [InscripcionesController::class, 'store'])->name('tablainscripciones.store');
Route::get('/tablainscripciones/{inscripcion}/edit', [InscripcionesController::class, 'edit'])->name('tablainscripciones.edit');
Route::put('/tablainscripciones/{inscripcion}', [InscripcionesController::class, 'update'])->name('tablainscripciones.update');
Route::delete('/tablainscripciones/{inscripcion}', [InscripcionesController::class, 'destroy'])->name('tablainscripciones.destroy');

////////////////////////////////////
Route::get('/comprTurno/{dni}', [MailController::class, 'create'])->name('create');
Route::get('/comprLista/{dni}', [MailController::class, 'store'])->name('store');

//
//Route::get('/convertToPDF', [PDFController::class, 'convertToPDF'])->name('convertToPDF');

Auth::routes();
