<?php

use App\Http\Controllers\DelicaController;
use App\Http\Controllers\DuplicatedProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware('auth')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('projects', ProjectController::class);
    Route::resource('delicas', DelicaController::class);

    Route::get('settings', [ProfileController::class, 'edit'])->name('settings');
    Route::get('/projects/{project}/image', [ProjectImageController::class, 'show'])->name('projects.image.show');
    Route::post('/projects/{project}/duplicate', [DuplicatedProjectController::class, 'store'])->name('projects.duplicate.store');
});

require __DIR__.'/auth.php';
