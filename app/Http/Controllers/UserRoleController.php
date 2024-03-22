<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\UserRoleService;
use Illuminate\Support\Facades\Session;

class UserRoleController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'User Role';
    protected $route = 'user-role';
    protected $view = 'user_role';

    public function __construct(UserRoleService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        $this->validate(request(), [
            'id' => app('uuid_validation')
        ], [
            'id' => 'You are in Pluto, not Earth!'
        ]);

        $datas['id'] = request()->input('id');
        Session::put('active_menu', 'user');
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['datas'] = $this->service->getUserRole(null, 25, request()->input('id'));
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        $datas['show'] = [
            'role.name' => 'Role',
            // 'user.name' => 'User Name',
        ];
        $datas['user'] = $this->service->findUser(request()->input('id'));
        $datas['user_columns'] = [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
        ];

        return view($this->view.'.index', $datas);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'id' => app('uuid_validation'),
        ], [
            'id' => 'User not found!'
        ]);

        $datas['title'] = 'Create '.$this->title;
        $datas['id'] = $request->input('id');
        $datas['breadcrumbs'] = [
            $this->route.'.read' => [
                'title' => $this->title,
                'params' => ['id' => $datas['id']],
                'is_active' => false
            ],
        ];

        $datas['user'] = $this->service->findUser(request()->input('id'));
        $datas['user_columns'] = [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
        ];

        return view($this->view.'.create', $datas);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->service->rules());
        $alert = $this->help->returnAlert();

        $stored = $this->service->create($request->except('_token'));
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getUserRole($id);
        return view($this->route.'.edit', $datas);
    }

    public function update(Request $request)
    {
        $rules = $this->service->rules();
        $rules['email'] = 'required|email';
        $rules['id'] = 'required|string|min:36|max:36';
        unset($rules['password'], $rules['confirm_password']);
        $this->validate($request, $rules);
        $alert = $this->help->returnAlert();

        $id = $request->input('id');
        $updated = $this->service->update($id, $request->except('_token'));
        if(!$updated){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
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
}
