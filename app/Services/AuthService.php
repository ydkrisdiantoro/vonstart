<?php

namespace App\Services;

use App\Events\AuthorizedUser;
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
    public function goLogin($email, $password, $pretend = false)
    {
        $user = (new UserService)->findUser(email: $email);
        $hashedPassword = $user->password ?? null;

        if($hashedPassword !== null && Hash::check($password, $hashedPassword)){
            if(sizeof($user->userRoles) > 0){
                event(new AuthorizedUser($user));
                $this->useYear();
                Auth::login($user);
            } else{
                abort(401);
            }
        }

        return Auth::check();
    }

    protected function useYear()
    {
        $useYear = config('vcontrol.year');
        if($useYear){
            $yearNow = date('Y');
            $yearStart = config('vcontrol.year_start') ?? ($yearNow - 3);
            $yearEnd = config('vcontrol.year_end') ?? ($yearNow + 1);
            for($i = $yearEnd; $i >= $yearStart; $i--){
                $years[] = $i;
            }
            Session::put('years', $years);
            if (!Session::has('active_year')) {
                Session::put('active_year', $yearNow);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login.read');
    }

    public function changeRole($roleId)
    {
        $user = (new UserService)->findUser(id: Auth::user()->id);
        event(new AuthorizedUser($user, $roleId));
        return ['success' => true];
    }
}
