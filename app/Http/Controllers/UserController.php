<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VcontrolHelper;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'User';

    public function __construct(UserService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        $datas['title'] = $this->title;
        $datas['datas'] = $this->service->getUser();

        return view('user.index', $datas);
    }

    public function create()
    {
        $datas['title'] = 'Create '.$this->title;
        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->service->rules());
        $alert = $this->help->returnAlert();

        $stored = $this->service->create($request->except('_token'));
        if(!$stored){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route('user.index')->with($alert[0], $alert[1]);
    }

    public function edit($id)
    {
        $datas['title'] = 'Edit '.$this->title;
        $datas['datas'] = $this->service->getUser($id);
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

        return redirect()->route('user.index')->with($alert[0], $alert[1]);
    }

    public function destroy($id)
    {
        $alert = $this->help->returnAlert();

        $deleted = $this->service->delete($id);
        if(!$deleted){
            $alert = $this->help->returnAlert(false);
        }

        return redirect()->route('user.index')->with($alert[0], $alert[1]);
    }
}
