<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController as FrontendWelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome',[FrontendWelcomeController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/categories',[FrontendCategoryController::class,'index'])->name('categories.index');
Route::get('/categories/{category}',[FrontendCategoryController::class,'show'])->name('categories.show');
Route::get('/menus',[FrontendMenuController::class,'index'])->name('menus.index');
Route::get('/reservations/step-one',[FrontendReservationController::class,'stepOne'])->name('menus.step.one');
Route::get('/reservations/step-two',[FrontendReservationController::class,'stepTwo'])->name('menus.step.two');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->name('admin.')->prefix('admin')->group(function(){
Route::get('/',[AdminController::class,'index'])->name('index');
Route::resource('/categories',CategoryController::class);
Route::resource('/menu',MenuController::class);
Route::resource('/table',TableController::class);
Route::resource('/reservations',ReservationController::class);

});

require __DIR__.'/auth.php';
