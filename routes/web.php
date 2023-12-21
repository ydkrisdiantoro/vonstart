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
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'goLogin'])->name('go-login');

$slug = 'user';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [UserController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [UserController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [UserController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [UserController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [UserController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [UserController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [UserController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});

$slug = 'role';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [RoleController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [RoleController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [RoleController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [RoleController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [RoleController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [RoleController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [RoleController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});

$slug = 'menu-group';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [MenuGroupController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [MenuGroupController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [MenuGroupController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [MenuGroupController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [MenuGroupController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [MenuGroupController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [MenuGroupController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});

$slug = 'menu';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [MenuController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [MenuController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [MenuController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [MenuController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [MenuController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [MenuController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [MenuController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});

$slug = 'role-menu';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [RoleMenuController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [RoleMenuController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [RoleMenuController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [RoleMenuController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [RoleMenuController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [RoleMenuController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [RoleMenuController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});

$slug = 'user-role';
Route::middleware('auth')->group(function () use($slug){
    Route::get('/'.$slug, [UserRoleController::class, 'index'])
        ->middleware('access:'.$slug.',read')
        ->name($slug.'.read');
    Route::get('/'.$slug.'/create', [UserRoleController::class, 'create'])
        ->middleware('access:'.$slug.',create')
        ->name($slug.'.create');
    Route::post('/'.$slug.'/store', [UserRoleController::class, 'store'])
        ->middleware('access:'.$slug.',store')
        ->name($slug.'.store');
    Route::get('/'.$slug.'/edit/{id}', [UserRoleController::class, 'edit'])
        ->middleware('access:'.$slug.',edit')
        ->name($slug.'.edit');
    Route::post('/'.$slug.'/update', [UserRoleController::class, 'update'])
        ->middleware('access:'.$slug.',update')
        ->name($slug.'.update');
    Route::get('/'.$slug.'/delete/{id}', [UserRoleController::class, 'delete'])
        ->middleware('access:'.$slug.',delete')
        ->name($slug.'.delete');
    Route::get('/'.$slug.'/validate', [UserRoleController::class, 'validate'])
        ->middleware('access:'.$slug.',validate')
        ->name($slug.'.validate');
});
