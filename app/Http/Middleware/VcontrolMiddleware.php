<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VcontrolMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $menus = Session::get('menus');
        $routeName = explode('.', $request->route()->getName());
        $slug = $routeName[0] ?? null;
        $access = $routeName[1] ?? null;

        // dd($routeName, $menu, $access, $menus, session()->all());

        if($menus != null){
            $mapAccess = config('vcontrol.map_access.'.$access);
            $hasAccess = false;
            foreach ($menus as $route => $listAccess) {
                if($slug == $route){
                    if($listAccess[$mapAccess] == 1){
                        $hasAccess = true;
                    }
                }
            }
    
            if (!$hasAccess) {
                return redirect('/dashboard')->withErrors('error');
            }
            return $response;
        }

        return $response;
    }
}
