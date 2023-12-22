ADA DI SINI HARUSNYA WOY

@extends('layouts.vcontrol_dashboard')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
{{--  --}}
@endsection

@section('body')

    @section('menus')
        <div class="list-group-item border-0">
            <small class="ms-3">GRUP MENU</small>
        </div>
        <a href="#slug" class="list-group-item list-group-item-action border-0">
            <span class="material-symbols-rounded me-2">home</span>
            <span>Dashboard</span>
        </a>
        <a href="login.html" class="list-group-item list-group-item-action border-0">
            <span class="material-symbols-rounded me-2">home</span>
            <span>Login Page</span>
        </a>
    @endsection

    @section('navbar-extra')
    @endsection

    @section('navbar-dropdown-item')
        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
    @endsection

    @section('main-title')
        {{ 'Dashboard' }}
    @endsection

    @section('main-content')
        {{ 'Welcome to Vonslab!' }}
    @endsection

    @section('footer')
    @endsection

@endsection

@section('extra-js')
{{--  --}}
@endsection
