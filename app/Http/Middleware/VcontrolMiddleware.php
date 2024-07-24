<?php

namespace App\Http\Middleware;

use App\Helpers\VcontrolHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class VcontrolMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $menus = Session::get('menus');
        $routeMenus = array_keys($menus);

        $currentRouteName = Route::currentRouteName();
        $route = explode('.', $currentRouteName);
        $routeNow = $route[0];
        $routeAccess = $route[(count($route) - 1)];

        //CRUD Only, no (E)dit or (S)tore
        if ($routeAccess == 'edit') {
            $routeAccess = 'update';
        } elseif($routeAccess == 'store'){
            $routeAccess = 'create';
        }

        if(in_array($routeNow, $routeMenus)){
            if (@$menus[$routeNow]['is_'.$routeAccess] == 1) {
                return $response;
            }
        } elseif(in_array($routeNow, ['dashboard', 'personal', 'notification'])){
            return $response;
        }

        return response()->view('errors.401');
    }
}
