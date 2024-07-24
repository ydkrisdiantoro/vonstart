<?php

namespace App\Http\Controllers;

use App\Helpers\VcontrolHelper;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ErrorLogController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Error Log';
    protected $route = 'error-log';
    protected $view = 'error_log';

    public function __construct(VcontrolHelper $help)
    {
        $this->help = $help;
    }

    public function index()
    {
        Session::put('active_menu', $this->route);
        $datas['title'] = $this->title;
        $datas['route'] = $this->route;
        $datas['filters'] = session('filters-'.session('active_menu')) ?? false;
        $datas['datas'] = $this->data($datas['filters']);
        $datas['show'] = [
            'user.name' => 'User',
            'code' => 'Code',
            'file' => 'File',
            'line' => 'Line',
            'message' => 'Message',
            'created_at' => 'At',
        ];
        $datas['form_filters'] = [
            'code' => [
                'title' => 'Find Code',
                'type' => 'text',
            ],
        ];

        return view($this->view.'.index', $datas);
    }

    protected function data($filters = [])
    {
        $model = ErrorLog::orderBy('created_at', 'desc');
        
        if (@$filters && sizeof($filters) > 0) {
            foreach ($filters as $column => $value) {
                if($value){
                    $model = $model->where($column, $value);
                }
            }
        }
        return $model->paginate(25);
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'code' => 'nullable|string|max:10'
        ]);

        $data = [
            'code' => $request->input('code'),
        ];

        Session::put('filters-'.session('active_menu'), $data);
        $alert = $this->help->returnAlert();

        return redirect()->route($this->route.'.read')->with($alert[0], $alert[1]);
    }
}
