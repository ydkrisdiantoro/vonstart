<?php

namespace App\Http\Controllers;

use App\Helpers\VcontrolHelper;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Notification';
    protected $route = 'notification';
    protected $view = 'notification';

    public function __construct(NotificationService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        Session::put('active_menu', $this->route);
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['datas'] = $this->service->getNotification(null, 25);

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
        $datas['datas'] = $this->service->getNotification($id);
        return view($this->view.'.edit', $datas);
    }

    public function update(Request $request)
    {
        $rules = $this->service->rules();
        $this->validate($request, $rules);
        $alert = $this->help->returnAlert();

        $id = $request->input('id');
        $updated = $this->service->update($id, $request->except(['_token', 'id']));
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

        return redirect()->back()->with($alert[0], $alert[1]);
    }
}
