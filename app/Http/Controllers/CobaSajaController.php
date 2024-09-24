<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\CobaSajaService;
use Illuminate\Support\Facades\Session;

class CobaSajaController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Menus';
    protected $route = 'menus';
    protected $view = 'menus';

    public function __construct(CobaSajaService $service,VcontrolHelper $help)
    {
        $this->help = $help;
        $this->service = $service;
    }

    public function index()
    {
        Session::put('active_menu', $this->route);
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['datas'] = [];
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        $datas['show'] = ['name' => 'Name','icon' => 'Icon','route' => 'Route','cluster' => 'Cluster','is_show' => 'Is Show','order' => 'Order','created_at' => 'Created At','updated_at' => 'Updated At','deleted_at' => 'Deleted At',];

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

        $stored = $this->service->create($request->except('_token'));
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getRole($id);
        return view($this->route.'.edit', $datas);
    }

    public function update(Request $request)
    {
        $rules = $this->service->rules();
        $rules['id'] = 'required|string|min:36|max:36';
        $this->validate($request, $rules);
        $alert = $this->help->returnAlert();

        $id = $request->input('id');
        $updated = $this->service->update($id, $request->except(['_token', 'id']));
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
