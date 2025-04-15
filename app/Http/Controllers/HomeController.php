<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\VcontrolHelper;
use App\Services\AuthService;

class HomeController extends Controller
{
    protected $service;
    protected $help;
    protected $title = 'Home';

    public function __construct(AuthService $service, VcontrolHelper $help)
    {
        $this->service = $service;
        $this->help = $help;
    }

    public function index()
    {
        $datas['title'] = 'Home '.$this->title;

        return view('home.index', $datas);
    }
}
