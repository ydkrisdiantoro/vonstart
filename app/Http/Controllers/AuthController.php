<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\AuthService;

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
            'email' => ['required','unique:users, email'],
            'password' => ['required','min:6'],
        ]);

        $datas = $request->except('_token');
        $logged = $this->service->goLogin($datas('email'), $datas['password']);

        if($logged){
            $dashboardRoute = config('dashboard_route');
            return redirect()->route($dashboardRoute);
        } else{
            $alert = $this->help->returnAlert(false);
            return redirect()->back()->with($alert[0], $alert[1]);
        }
    }

    public function dashboard()
    {
        $datas['title'] = 'Dahsboard';
        return view('home.dashboard', $datas);
    }
}
