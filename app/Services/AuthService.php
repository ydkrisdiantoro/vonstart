<?php

namespace App\Services;

use App\Models\RoleMenu;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthService
{
    /**
     * Login Process
     * @param string $email
     * @param string $password
     * @return boolean true if logged in
     */
    public function goLogin($email, $password)
    {
        $user = (new User)->where('email', $email)->with('userRoles.role')->first();
        $hashedPassword = $user->password ?? null;

        if($hashedPassword !== null && Hash::check($password, $hashedPassword)){
            $firstRole = $user->userRoles->first();
            if ($firstRole) {
                try {
                    $mapRoles = $user->userRoles->mapWithKeys(function($item){
                        return [
                            $item->role_id => $item->role
                        ];
                    });
    
                    $menuGroups = [];
                    $menus = [];
                    $routeMenus = [];
                    $notification = [];
                    $roleMenus = RoleMenu::where('role_id', $firstRole->role_id)
                        ->whereHas('menu', function($query){
                            $query->orderBy('order', 'asc');
                        })
                        ->with('menu.menuGroup')
                        ->get();
    
                    foreach($roleMenus as $roleMenu){
                        $menuGroups[$roleMenu->menu->menu_group_id] = $roleMenu->menu->menuGroup;
                        $menus[$roleMenu->menu->menu_group_id][$roleMenu->menu_id] = $roleMenu->menu;
                        $routeMenus[$roleMenu->menu->route] = $roleMenu->menu;
                        $notification[$roleMenu->menu->route]['color'] = 'info';
                        $notification[$roleMenu->menu->route]['text'] = null;
                    }
    
                    Session::put('active_role_id', $firstRole->id);
                    Session::put('roles', $mapRoles);
                    Session::put('menu_groups', $menuGroups);
                    Session::put('menus', $menus);
                    Session::put('user', $user->toArray());
                    Session::put('active_menu', 'dashboard');
                    Session::put('notification', $notification);
                    Session::put('route_menus', $routeMenus);
                    Session::save();

                    Auth::login($user);
                } catch (\Throwable $th) {
                    if(App::environment() == 'local'){
                        dd($th);
                    }
                }
            }
        }

        return Auth::check();
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login.read');
    }
}
