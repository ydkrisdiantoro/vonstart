<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\MenuService;
use App\Services\RoleMenuService;
use App\Services\RoleService;
use Barryvdh\Debugbar\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class RoleMenuController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Role Menu';
    protected $route = 'role-menu';
    protected $view = 'role_menu';

    public function __construct(RoleMenuService $service, VcontrolHelper $help)
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

        Session::put('active_menu', 'role');
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['datas'] = $this->service->getRoleMenuByRoleId(request()->input('id'), null, true);
        $datas['menus'] = (new MenuService)->getMenu()->groupBy('menu_group_id');
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        $datas['show'] = [
            'menu.name' => 'Menu',
            // 'role.name' => 'Role',
            'is_create' => 'Create?',
            'is_read' => 'Read?',
            'is_update' => 'Update?',
            'is_delete' => 'Delete?',
            'is_validate' => 'Validate?',
        ];
        $datas['role'] = (new RoleService)->getRole(request()->input('id'));
        $datas['role_columns'] = [
            'name' => 'Role Name',
            'code' => 'Role Code',
            'icon' => 'Icon',
            'order' => 'Order',
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
        $uuid_validation = app('uuid_validation');
        $uuid_validation_nullable = str_replace('required','nullable',app('uuid_validation'));
        $this->validate($request, [
            'role_id' => $uuid_validation,
            'menus.*' => $uuid_validation,
            'is_read.*' => $uuid_validation_nullable,
            'is_create.*' => $uuid_validation_nullable,
            'is_update.*' => $uuid_validation_nullable,
            'is_delete.*' => $uuid_validation_nullable,
            'is_validate.*' => $uuid_validation_nullable,
        ]);

        $alert = $this->help->returnAlert();
        $stored = $this->service->saveRoleMenu($request->except('_token'));
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->back()->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getRoleMenu($id);
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
