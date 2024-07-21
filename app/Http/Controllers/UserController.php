<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'User';
    protected $route = 'user';
    protected $view = 'user';

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
        $datas['datas'] = $this->service->getUser(userId: null, paginate: 25, filters: $datas['filters']);
        $datas['show'] = [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
        $datas['role_route'] = 'user-role';
        $datas['roles'] = (new RoleService)->getRole(forSelect: true);
        $datas['form_filters'] = [
            'name' => [
                'title' => 'Name',
                'type' => 'text',
            ],
            'email' => [
                'title' => 'Email',
                'type' => 'text',
            ],
            'role' => [
                'title' => 'Role',
                'type' => 'select',
                'data' => $datas['roles'],
            ],
        ];

        return view($this->view.'.index', $datas);
    }

    public function create()
    {
        $datas['title'] = 'Create '.$this->title;

        return view($this->view.'.create', $datas);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->service->rules());
        $alert = $this->help->returnAlert();
        $data = $request->except(['_token', 'confirm_password']);
        $data['password'] = Hash::make($data['password']);

        $stored = $this->service->create($data);
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getUser($id);
        return view($this->route.'.edit', $datas);
    }

    public function update(Request $request)
    {
        $rules = $this->service->rules();
        $rules['email'] = 'required|email';
        $rules['id'] = 'required|string|min:36|max:36';
        $rules['password'] = ['nullable','string'];
        $rules['confirm_password'] = ['nullable','string','same:password'];
        $this->validate($request, $rules);
        $data = $request->except(['_token', 'confirm_password']);
        if($data['password']){
            $data['password'] = Hash::make($data['password']);
        }
        $alert = $this->help->returnAlert();

        $id = $request->input('id');
        $updated = $this->service->update($id, $data);
        if(!$updated){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->back()->with($alert[0], $alert[1]);
    }

    public function destroy($id)
    {
        $alert = $this->help->returnAlert();

        $deleted = $this->service->delete($id);
        if(!$deleted){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }

    public function personal()
    {
        Session::put('active_menu', 'personal');
        $user = session('user');
        $datas['title'] = 'Hi, '.$user['name'];
        $datas['datas'] = $this->service->getUser($user['id']);

        return view($this->route.'.personal', $datas);
    }

    public function personalUpdate(Request $req)
    {
        return $this->update($req);
    }


    public function filter(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'role' => 'nullable|string|max:36',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ];

        Session::put('filters-'.session('active_menu'), $data);
        $alert = $this->help->returnAlert();

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }
}
