<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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

Route::get('/',[BlogController::class, 'index'])
->name('dashboard');

Route::get('/dashboard',[BlogController::class, 'index'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //admin routes
    Route::get('/profile/index',[ProfileController::class, 'index'])
        ->middleware(middleware:'can:isAdmin')
        ->name('profile.index');
    
    Route::get('/profile/index/{user_id}/{status}',[ProfileController::class, 'updateStatus'])
    ->name('profile.status.update')
    ->middleware(middleware:'can:isAdmin');
});

Route::resource('/blog', BlogController::class)
    ->only(['index', 'store','edit','update','destroy'])
    ->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';
