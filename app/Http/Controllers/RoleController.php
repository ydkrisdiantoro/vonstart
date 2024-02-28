<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\RoleService;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Role';

    public function __construct(RoleService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        Session::put('active_menu', 'role');
        $datas['title'] = $this->title;
        $datas['datas'] = $this->service->getRole();

        return view('role.index', $datas);
    }

    public function create()
    {
        $datas['title'] = 'Create '.$this->title;
        return view('role.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->service->rules());
        $alert = $this->help->returnAlert();

        $stored = $this->service->create($request->except('_token'));
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route('role.index')->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getRole($id);
        return view('datas.edit', $datas);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->service->rules());
        $alert = $this->help->returnAlert();

        $updated = $this->service->update($id, $request->except('_token'));
        if(!$updated){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route('role.index')->with($alert[0], $alert[1]);
    }

    public function destroy($id)
    {
        $alert = $this->help->returnAlert();

        $deleted = $this->service->delete($id);
        if(!$deleted){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route('role.index')->with($alert[0], $alert[1]);
    }
}
