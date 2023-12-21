<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VcontrolMiddleware
{
    public function handle($request, Closure $next, $slug, $access)
    {
        $menus = Session::get('menus');

        if($menus != null){
            $mapAccess = config('vcontrol.map_access.'.$access);
            $matchingMenu = collect($menus)->first(function ($menu) use ($slug, $access, $mapAccess) {
                return $menu['route'] === $slug && $access === $mapAccess;
            });
    
            if (!$matchingMenu) {
                return redirect('/')->with('error', 'Anda tidak memiliki akses yang diperlukan.');
            }
        }

        return $next($request);
    }
}
