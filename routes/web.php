<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login.read');
});

Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthController::class, 'login'])->name('login.read');
    Route::post('/login/process', [AuthController::class, 'goLogin'])->name('login.store');
});

Route::middleware(['auth', 'access'])->group(function (){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.read');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard.read');
    Route::get('/year/{year}', [AuthController::class, 'year'])->name('year.read');
    Route::get('/change-role/{role_id}', [AuthController::class, 'changeRole'])->name('change-role.read');
});

$slug = 'user';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [UserController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [UserController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [UserController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [UserController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [UserController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [UserController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [UserController::class, 'validate'])->name($slug.'.validate');
});

$slug = 'role';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [RoleController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [RoleController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [RoleController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [RoleController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [RoleController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [RoleController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [RoleController::class, 'validate'])->name($slug.'.validate');
});

$slug = 'menu-group';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [MenuGroupController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [MenuGroupController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [MenuGroupController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [MenuGroupController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [MenuGroupController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [MenuGroupController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [MenuGroupController::class, 'validate'])->name($slug.'.validate');
});

$slug = 'menu';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [MenuController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [MenuController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [MenuController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [MenuController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [MenuController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [MenuController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [MenuController::class, 'validate'])->name($slug.'.validate');
});

$slug = 'role-menu';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [RoleMenuController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [RoleMenuController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [RoleMenuController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [RoleMenuController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [RoleMenuController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [RoleMenuController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [RoleMenuController::class, 'validate'])->name($slug.'.validate');
});

$slug = 'user-role';
Route::middleware(['auth', 'access'])->group(function () use($slug){
    Route::get('/'.$slug, [UserRoleController::class, 'index'])->name($slug.'.read');
    Route::get('/'.$slug.'/create', [UserRoleController::class, 'create'])->name($slug.'.create');
    Route::post('/'.$slug.'/store', [UserRoleController::class, 'store'])->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [UserRoleController::class, 'edit'])->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [UserRoleController::class, 'update'])->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [UserRoleController::class, 'destroy'])->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [UserRoleController::class, 'validate'])->name($slug.'.validate');
});
