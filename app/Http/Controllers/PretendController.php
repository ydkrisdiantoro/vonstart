<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
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
        $a += 1;
    }
}
