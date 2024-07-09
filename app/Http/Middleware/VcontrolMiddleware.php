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
        $accessMenus = Session::get('access_menus');
        $routeMenus = array_keys($accessMenus);
        $currentRouteName = Route::currentRouteName();
        $route = explode('.', $currentRouteName);

        if(in_array($route[0], $routeMenus) && isset($accessMenus[$route[0]]['is_read']) && $accessMenus[$route[0]]['is_read'] == 1){
            return $response;
        } elseif($route[0] == 'dashboard'){
            return $response;
        }

        return redirect()->route('dashboard.read')->with('alert', ['danger', 'The address is on Mars. You don`t have any rockets to get there.']);
    }
}
