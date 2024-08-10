<?php

namespace App\Services;

use App\Events\AuthorizedUser;
use App\Mail\MailPasswordResetToken;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $user = (new UserService)->findUser(email: $email);
        $hashedPassword = $user->password ?? null;

        if(($hashedPassword !== null && Hash::check($password, $hashedPassword))){
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

    public function flush()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    public function logout()
    {
        $isPretend = Session::get('back_from_pretend');
        if($isPretend){
            $canceled = $this->cancelPretend(Auth::user()->id);
            if($canceled){
                return redirect()->route('pretend.read');
            }
        }

        $this->flush();
        return redirect()->route('login.read');
    }

    public function changeRole($roleId)
    {
        $user = (new UserService)->findUser(id: Auth::user()->id);
        event(new AuthorizedUser($user, $roleId));
        return ['success' => true];
    }

    public function makeToken($email)
    {
        // Check if email already registered
        $user = User::where('email', $email)->first();
        if($user){
            $expiredAt = date('Y-m-d H:i:s', strtotime('+2 minutes', strtotime(date('Y-m-d H:i:s'))));
            $token = substr(str_shuffle(str_repeat('0123456789', 6)), 0, 6);
            $save = PasswordReset::create([
                'user_id' => $user->id,
                'token' => $token,
                'expired_at' => $expiredAt
            ]);

            // Kirim token ke email
            // Mail::to($email)->send(new MailPasswordResetToken($token));

            if($save){
                return [
                    'expired_at' => $expiredAt
                ];
            }
        }

        return false;
    }

    public function getToken($email)
    {
        $data = PasswordReset::whereRelation('user', 'email', $email)
            ->orderBy('created_at', 'desc')
            ->where('expired_at', '>=', date('Y-m-d H:i:s'))
            ->select('expired_at')
            ->first();
        
        if($data){
            return [
                'expired_at' => $data->expired_at
            ];
        }
    }

    public function checkOtp($otp)
    {
        $now = date('Y-m-d H:i:s');
        return PasswordReset::where('token', $otp)
            ->where('expired_at', '>=', $now)
            ->first();
    }

    public function pretend($userNow, $user)
    {
        $this->flush();
        event(new AuthorizedUser($user));
        $this->useYear();
        Session::put('back_from_pretend', $userNow);
        Session::put('active_menu', 'dashboard');
        Auth::login($user);

        return Auth::check();
    }

    public function cancelPretend($userId)
    {
        $userId = Session::get('back_from_pretend');
        $user = (new UserService)->findUser(id: $userId);
        $this->flush();

        event(new AuthorizedUser($user));
        $this->useYear();
        Auth::login($user);

        return Auth::check();
    }
}
