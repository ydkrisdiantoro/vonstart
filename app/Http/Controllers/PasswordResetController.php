<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    protected $title = 'Password Reset';
    protected $route = 'password_reset';
    protected $view = 'password_reset';
    protected $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function index()
    {
        $session = session('forgot_password');
        $datas = [
            'title' => $this->title,
            'route' => $this->route,
            'expired_at' => @$session['expired_at'],
        ];

        return view($this->view.'.index', $datas);
    }

    public function sendToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ], [
            'email' => 'Email is not valid or not yet registered...'
        ]);

        $email = $request->input('email');
        $this->service->makeToken($email);

        return redirect()->back();
    }

    public function checkToken(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'otp' => 'required|numeric|min:100000|max:999999'
        ], [
            'otp' => 'OTP Code doesn`t valid!'
        ]);

        $otp = $request->input('otp');
        $check = $this->service->checkOtp($otp);

        if($check){
            
        }
    }

    public function storeNewPassword(Request $request)
    {
        dd('ini store');
    }
}
