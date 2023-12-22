
@extends('layouts.vcontrol_index')

@section('title')
Dashboard
@endsection

@section('extra-css')
{{--  --}}
@endsection

@section('body')

<div class="wrapper position-relative">
    <!-- Sidebar  -->
    <nav id="sidebar" class="position-fixed bg-white" aria-labelledby="sidebar">
        <div class="sidebar-header d-flex">
            <span id="brand" class="fs-5 fw-bold m-auto">{{ config('vcontrol.app_name') }}</span>
            <span class="ms-0 me-3 my-auto d-md-none">
                <a type="button" id="btnDismissSidebar" class="fs-4 hover-icon">
                    <i class="bi bi-x"></i>
                </a>
            </span>
        </div>

        <div id="sidebarMenu" class="shadow">
            <div class="p-3">
                <input id="searchMenu"
                    onkeyup="searchMenu()"
                    type="text"
                    class="form-control border-0 bg-light"
                    placeholder="Search Menu">
            </div>

            <div>
                {{-- @foreach ($menus as $menuRoute => $menuDetail) --}}
                    <div type="button" class="list-group-item border-0 mx-3 px-2 py-0"
                        data-bs-toggle="collapse"
                        data-bs-target="#group1"
                        aria-expanded="true"
                        aria-controls="group1"
                        href="#">
                        <div class="w-100 d-flex justify-content-between">
                            <span class="small">{{ $menuDetail ?? '' }}</span>
                            <i class="bi bi-three-dots"></i>
                        </div>
                    </div>
                    <div id="group1" class="collapse show">
                        <a href="#slug" class="list-group-item list-group-item-action border-0">
                            <span>
                                <i class="bi bi-speedometer me-2"></i>
                            </span>
                            <span>Dashboard</span>
                        </a>
                        <a href="#slug" class="list-group-item list-group-item-action border-0">
                            <span>
                                <i class="bi bi-speedometer me-2"></i>
                            </span>
                            <span>Inilah</span>
                        </a>
                    </div>
                {{-- @endforeach --}}

                @dd(session()->all())
            </div>

        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="bg-light">

        <nav id="navbar" class="navbar text-dark bg-white fixed-top px-md-3 px-2 shadow"
            aria-labelledby="navbar">
            <div class="container-fluid justify-content-between">
                <a type="button" id="btnToggleSidebar" class="fs-4 hover-icon">
                    <i class="bi bi-list"></i>
                </a>
                <div>

                    <div class="dropdown">
                        <a class="dropdown-toggle text-decoration-none d-flex text-dark"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person me-1 text-primary"></i>
                            <span class="d-none d-md-block me-1">Username</span>
                            <i class="bi bi-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            <li>
                                <a class="dropdown-item" href="{{ '#' }}">
                                    <i class="bi bi-gear-fill"></i> Setting
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout.read') }}">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </nav>

        <main>
            
            <div class="row">
                <div class="col-12 mb-3">
                    <h4>

                        {{ 'Dashboard' }}

                    </h4>
                </div>
                <div class="col-12">

                    {{ 'Welcome to Vonslab!' }}

                </div>
            </div>

        </main>

        <footer>

        </footer>
    </div>
</div>

@endsection

@section('extra-js')
{{--  --}}
@endsection
