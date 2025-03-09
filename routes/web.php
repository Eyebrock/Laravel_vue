<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/estudiantes', '\App\Http\Controllers\GeneralController@Estudiantesindex')->name('estudiantes');
    Route::post('/estudiantes', '\App\Http\Controllers\GeneralController@EstudiantesStore')->name('estudiantes.store');
    Route::post('/estudiantes_updt/{id}', '\App\Http\Controllers\GeneralController@EstudiantesUpdate')->name('estudiantes.update');
    Route::delete('/estudiantes_destroy/{id}', '\App\Http\Controllers\GeneralController@DeleteEstudiante')->name('estudiantes.destroy');


    Route::get('/cursos', '\App\Http\Controllers\GeneralController@Cursosindex')->name('cursos');
    Route::post('/cursos', '\App\Http\Controllers\GeneralController@CursosStore')->name('cursos.store');
    Route::post('/cursos_updt/{id}', '\App\Http\Controllers\GeneralController@CursosUpdate')->name('cursos.update');
    Route::delete('/cursos_destroy/{id}', '\App\Http\Controllers\GeneralController@DeleteCurso')->name('cursos.destroy');

    Route::get('/certificaciones/{id}', '\App\Http\Controllers\GeneralController@Certificacionesindex')->name('certificaciones_estudiante');
    Route::post('/certificaciones', '\App\Http\Controllers\GeneralController@CertificacionesStore')->name('estudiantes.certificaciones.store');
    Route::get('/certificaciones_updt/{id_estudiante_cert}/{id}', '\App\Http\Controllers\GeneralController@CertificacionesUpdate')->name('estudiantes.certificaciones.update');
    Route::post('/certificaciones_updt', '\App\Http\Controllers\GeneralController@CertificacionesUpdateStore')->name('estudiantes.certificaciones.update.store');

});
require __DIR__.'/auth.php';
