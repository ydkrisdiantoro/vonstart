<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PretendController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Pretend';
    protected $route = 'pretend';
    protected $view = 'pretend';

    public function __construct(UserService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        Session::put('active_menu', $this->route);
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        if (isset($datas['filters']['keyword']) && !empty($datas['filters']['keyword'])) {
            $datas['datas'] = $this->service->getUserPretend($datas['filters']['keyword']);
        }
        $datas['show'] = [
            'name' => 'Name',
            'email' => 'Email',
        ];
        $datas['role_route'] = 'user-role';

        return view($this->view.'.index', $datas);
    }

    public function find(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|string'
        ]);

        Session::put('filters-'.$this->route, $request->except('_token'));
        return redirect()->back();
    }

    public function select($userId)
    {
        $authService = new AuthService;
        $userNow = Auth::user()->id;
        $user = (new UserService)->findUser($userId);
        $logged = $authService->pretend($userNow, $user);
        if($logged){
            $dashboardRoute = config('vcontrol.dashboard_route');
            return redirect()->route($dashboardRoute);
        } else{
            $cancelPretend = $authService->cancelPretend($userNow);
            if ($cancelPretend) {
                return redirect()->route($this->route.'.read');
            }

            $alert = VcontrolHelper::returnAlert(false, 'Something wrong in Mars!');
            return redirect()->route('logout.read')->with($alert[0], $alert[1]);
        }
    }
}
