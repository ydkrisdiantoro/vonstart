
@extends('layouts.vcontrol_index')

@section('title')
Dashboard
@yield('add-title')
@endsection

@section('extra-css')
@yield('add-css')
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
                <a href="{{ route('dashboard.read') }}"
                    class="d-flex list-group-item list-group-item-action border-0 {{ session('active_menu') == 'dashboard' ? 'text-primary' : '' }}">
                    <span class="my-auto">
                        <i class="bi bi-speedometer me-3 fs-5"></i>
                    </span>
                    <span class="my-auto">Dashboard</span>
                </a>
                @if (sizeof(session('menu_groups') ?? []) > 0)
                    @foreach (session('menu_groups') as $menu_group_id => $menu_group)
                        @if (sizeof(session('menus')[$menu_group_id] ?? []) > 0)
                            <div type="button" class="list-group-item border-0 mx-3 py-0 my-2"
                                data-bs-toggle="collapse"
                                data-bs-target="#group{{ $loop->iteration }}"
                                aria-expanded="true"
                                aria-controls="group{{ $loop->iteration }}"
                                href="#">
                                <div class="row px-2 rounded fw-bold">
                                    <div class="col-auto my-auto">
                                        <span class="small m-0">{{ strtoupper($menu_group->name) }}</span>
                                    </div>
                                    <div class="col my-auto">
                                        <hr class="m-0">
                                    </div>
                                    <div class="col-auto my-auto">
                                        <i class="bi bi-three-dots m-0"></i>
                                    </div>
                                </div>
                            </div>
                            <div id="group{{ $loop->iteration }}" class="collapse show">
                                @foreach (session('menus')[$menu_group_id] as $menu)
                                    <a href="{{ route($menu->route.'.read') }}"
                                        class="d-flex list-group-item list-group-item-action border-0 {{ session('active_menu') == $menu['route'] ? 'text-primary' : '' }}">
                                        <span class="my-auto">
                                            <i class="bi bi-{{ $menu['icon'] }} me-3 fs-5"></i>
                                        </span>
                                        <span class="my-auto">{{ $menu['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
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
                            <span class="d-none d-md-block me-1">{{ session('user')['name'] ?? 'Username' }}</span>
                            <i class="bi bi-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            <li>
                                <a class="dropdown-item" href="{{ '#' }}">
                                    <i class="bi bi-gear-fill"></i> Setting
                                </a>
                            </li>

                            @yield('add-navbar-dropdown')

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
                <div class="col-12">
                    <h4>
                        @yield('add-content-title')
                    </h4>
                </div>
                <div class="col-12">
                    @yield('add-content')
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
</div>

@endsection

@section('extra-js')
@yield('add-js')
@endsection
