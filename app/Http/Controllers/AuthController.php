<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Auth';

    public function __construct(AuthService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        $datas['title'] = 'Vonslab '.$this->title;

        return view('index', $datas);
    }

    public function login()
    {
        $datas['title'] = 'Login';
        return view('home.login', $datas);
    }

    public function goLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required','string','min:6', 'max:20'],
        ]);

        $datas = $request->except('_token');
        $logged = $this->service->goLogin($datas['email'], $datas['password']);

        if($logged){
            $dashboardRoute = config('vcontrol.dashboard_route');
            return redirect()->route($dashboardRoute);
        } else{
            $alert = $this->help->returnAlert(false);
            return redirect()->back()->withErrors('Error');
        }
    }

    public function logout()
    {
        return $this->service->logout();
    }

    public function dashboard()
    {
        Session::put('active_menu', 'dashboard');
        $datas['title'] = 'Dahsboard';

        return view('home.dashboard', $datas);
    }
}
