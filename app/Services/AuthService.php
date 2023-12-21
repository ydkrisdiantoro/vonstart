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
        $logged = false;
        $user = (new User)->where('email', $email)->first();
        $hashedPassword = (isset($user->password) ? $user->password : null);

        if($hashedPassword != null && Hash::check($password, $hashedPassword)){
            $firstRole = $user->roles->first();
            if ($firstRole) {
                Auth::login($user);

                $menus = RoleMenu::select('role_menus.*')
                    ->join('menus', 'role_menus.menu_id', '=', 'menus.id')
                    ->selectRaw('menus.*')
                    ->get();

                Session::put('active_role_id', $firstRole->id);
                Session::put('roles', $user->roles);
                Session::put('menus', $menus);

                $logged = true;
            }
        }

        return $logged;
    }
}
