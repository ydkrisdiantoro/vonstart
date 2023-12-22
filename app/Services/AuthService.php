<?php

namespace App\Services;

use App\Models\RoleMenu;
use App\Models\User;
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
        $user = (new User)->where('email', $email)->with('userRoles')->first();
        $hashedPassword = $user->password ?? null;

        if($hashedPassword != null && Hash::check($password, $hashedPassword)){
            $firstRole = $user->userRoles->first();
            if ($firstRole) {
                // Auth::login($user);

                $mapRoles = $user->userRoles->mapWithKeys(function($item){
                    return [
                        $item->role_id => [
                            'name' => $item->name,
                            'icon' => $item->icon,
                        ]
                    ];
                });

                $menus = RoleMenu::select('role_menus.*')
                    ->join('menus', 'role_menus.menu_id', '=', 'menus.id')
                    ->selectRaw('menus.*')
                    ->get();

                $mapMenus = $menus->mapWithKeys(function($item){
                    return [
                        $item->route => [
                            'name' => $item->name,
                            'icon' => $item->icon,
                            'is_show' => $item->is_show,
                            'cluster' => $item->cluster,
                            'menu_group_id' => $item->menu_group_id,
                            'order' => $item->order,
                            'is_create' => $item->is_create,
                            'is_read' => $item->is_read,
                            'is_update' => $item->is_update,
                            'is_delete' => $item->is_delete,
                            'is_validate' => $item->is_validate,
                        ]
                    ];
                });

                dd($mapMenus, $menus->toArray(), $mapRoles);

                Session::put('active_role_id', $firstRole->id);
                Session::put('active_role', $firstRole->name);
                Session::put('roles', $mapRoles);
                Session::put('menus', $mapMenus);
                Session::save();
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
