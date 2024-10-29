<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\MenuGroupService;
use App\Services\MenuService;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Menu';
    protected $route = 'menu';
    protected $view = 'menu';

    public function __construct(MenuService $service, VcontrolHelper $help)
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

        Session::put('active_menu', 'menu-group');
        $datas['id'] = request()->input('id');
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['datas'] = $this->service->getMenuByMenuGroupId($datas['id'], 25, false);
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        $datas['show'] = [
            // 'menuGroup.name' => 'Menu Group',
            'name' => 'Name',
            'icon' => 'Icon',
            'route' => 'Route',
            'is_show' => 'Show?',
            'cluster' => 'Cluster',
            'order' => 'Order',
        ];

        $datas['menu_group'] = (new MenuGroupService)->getMenuGroup(request()->input('id'));
        $datas['menu_group_columns'] = [
            'name' => 'Menu Group Name',
            'order' => 'Order',
        ];

        return view($this->view.'.index', $datas);
    }

    public function create()
    {
        $this->validate(request(), [
            'id' => app('uuid_validation')
        ], [
            'id' => 'You are in Pluto, not Earth!'
        ]);

        $datas['id'] = request()->input('id');
        $datas['menu_group'] = (new MenuGroupService)->getMenuGroup($datas['id']);
        $datas['title'] = 'Create '.$this->title;
        $datas['route'] = $this->route;

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

        return redirect()->route($this->route.'.read', ['id' => $request->input('menu_group_id')])->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getMenu($id);
        $datas['route'] = $this->route;
        return view($this->route.'.edit', $datas);
    }

    public function update(Request $request)
    {
        $rules = $this->service->rules();
        $this->validate($request, $rules);
        $alert = $this->help->returnAlert();

        $id = $request->input('id');
        $updated = $this->service->update($id, $request->except('_token'));
        if(!$updated){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read', ['id' => $request->input('menu_group_id')])->with($alert[0], $alert[1]);
    }

    public function destroy($id)
    {
        $alert = $this->help->returnAlert();

        $deleted = $this->service->delete($id);
        if(!$deleted){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->back()->with($alert[0], $alert[1]);
    }
}
