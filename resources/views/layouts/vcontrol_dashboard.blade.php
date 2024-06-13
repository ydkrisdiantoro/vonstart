
@extends('layouts.vcontrol_index')

@section('title')
    @php
        $semuaMenu = $session['route_menus'][$session['active_menu']] ?? null;
        $namaMenuAktif = 'Dashboard';
        if($semuaMenu !== null){
            $namaMenuAktif = $semuaMenu['name'] ?? '-';
        }
    @endphp

    {{ $namaMenuAktif }}

    @yield('add-title')

    {{ env('APP_NAME') }}
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
                    class="link-hover list-group-item list-group-item-action border-0 {{ $session['active_menu'] == 'dashboard' ? 'text-primary' : '' }}">
                    <div class="my-auto">
                        <i class="bi bi-speedometer me-3 fs-5"></i>
                    </div>
                    <span class="my-auto">Dashboard</span>
                    @if (($session['notification']['dashboard']['text'] ?? false))
                        @php
                            $color = $session['active_menu'] == 'dashboard' ? $session['notification']['dashboard']['color'] : 'secondary';
                        @endphp
                        <small class="my-auto ms-2 badge text-bg-{{ $color }}">
                            {!! $session['notification']['dashboard']['text'] !!}
                        </small>
                    @endif
                </a>
                @if (sizeof($session['menu_groups'] ?? []) > 0)
                    @foreach ($session['menu_groups'] as $menu_group_id => $menu_group)
                        @if (sizeof($session['menus'][$menu_group_id] ?? []) > 0)
                            <div type="button"
                                class="list-group-item border-0 mx-3 py-0 my-2"
                                data-bs-toggle="collapse"
                                data-bs-target="#group{{ $loop->iteration }}"
                                aria-expanded="true"
                                aria-controls="group{{ $loop->iteration }}"
                                href="#">
                                <div class="row px-2 rounded fw-bold">
                                    <div class="col-auto my-auto">
                                        <div class="small m-0">{{ strtoupper($menu_group['name']) }}</div>
                                    </div>
                                    <div class="col my-auto">
                                        <hr class="m-0 text-secondary">
                                    </div>
                                    <div class="col-auto my-auto">
                                        <i class="bi bi-caret-down-fill text-primary m-0 collapse-icon" data-target="group{{ $loop->iteration }}"></i>
                                    </div>
                                </div>
                            </div>
                            <div id="group{{ $loop->iteration }}" class="collapse show">
                                @foreach ($session['menus'][$menu_group_id] as $menu)
                                    @if ($menu['is_show'] && $session['access_menus'][$menu['route']]['is_read'] == true)
                                        <a href="{{ route($menu['route'].'.read') }}"
                                            class="link-hover list-group-item list-group-item-action border-0 {{ $session['active_menu'] == $menu['route'] ? 'text-primary' : '' }}">
                                            <div class="my-auto">
                                                <i class="bi bi-{{ $menu['icon'] }} me-3 fs-5"></i>
                                            </div>
                                            <span class="my-auto">{{ $menu['name'] }}</span>
                                            @if (($session['notification'][$menu['route']]['text'] ?? false))
                                                @php
                                                    $color = $session['active_menu'] == $menu['route'] ? $session['notification'][$menu['route']]['color'] : 'secondary';
                                                @endphp
                                                <small class="my-auto ms-2 badge text-bg-{{ $color }}">
                                                    {!! $session['notification'][$menu['route']]['text'] !!}
                                                </small>
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav id="navbar" class="navbar text-dark bg-white fixed-top px-md-3 px-2 shadow"
            aria-labelledby="navbar">
            <div class="container-fluid justify-content-between">
                <a type="button" id="btnToggleSidebar" class="fs-4 hover-icon">
                    <i class="bi bi-list"></i>
                </a>
                <div class="d-flex">

                    <div class="dropdown">
                        <a class="link-hover dropdown-toggle text-decoration-none d-flex text-dark me-3"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-block me-1" style="vertical-align: center;">
                                <i class="bi bi-calendar"></i>
                            </span>
                            <span class="d-none d-md-block" style="vertical-align: center;">
                                {{ $session['active_year'] ?? date('Y') }}
                            </span>
                        </a>
                        @if ($session['years'] ?? false)
                            <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                                @foreach ($session['years'] as $year)
                                    <li>
                                        <a class="dropdown-item {{ $year == $session['active_year'] ? 'active' : '' }}"
                                            href="{{ $year == $session['active_year'] ? '#' : route('year.read', $year) }}">
                                            {{ $year }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="dropdown">
                        <a class="link-hover dropdown-toggle text-decoration-none d-flex text-dark me-3"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-block me-1" style="vertical-align: center;">
                                <i class="bi bi-shield-fill-check"></i>
                            </span>
                            <span class="d-none d-md-block" style="vertical-align: center;">
                                {{ $session['roles'][$session['active_role_id']]['name'] ?? '-' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            @if ($session['roles'])
                                @foreach ($session['roles'] as $role_id => $role)
                                    <li>
                                        <a class="dropdown-item {{ $role_id == $session['active_role_id'] ? 'active' : '' }}"
                                            href="{{ $role_id == $session['active_role_id'] ? '#' : route('change-role.read', $role_id) }}">
                                            {{ $role['name'] ?? '-' }}
                                        </a>
                                    </li>
                                    @if ($loop->last == 1)
                                        <li>
                                            <a class="dropdown-item disabled" href="#">
                                                <small>No Other Role</small>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="dropdown">
                        <a class="link-hover dropdown-toggle text-decoration-none d-flex text-dark"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear-fill me-1"></i>
                            <span class="d-none d-md-block me-2 my-auto">Tools</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            <li>
                                <a class="dropdown-item active" href="{{ '#' }}">
                                    <i class="bi bi-person me-2"></i>
                                    {{ substr($session['user']['name'], 0, 20).'...' }}
                                </a>
                            </li>

                            @yield('add-navbar-dropdown')

                            <li>
                                <a class="dropdown-item" href="{{ route('logout.read') }}">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
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
                        {{ $namaMenuAktif }}
                        @yield('add-content-title')
                    </h4>
                </div>

                @php
                    $alert = $session['alert'] ?? false;
                @endphp
                @if($alert)
                    <div class="col-12 mt-3">
                        <div class="alert alert-{{ $alert[0] }} mb-0">{{ $alert[1] }}</div>
                    </div>
                @endif

                <div class="col-12 pt-2">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var collapseIcons = document.querySelectorAll('.collapse-icon');

        collapseIcons.forEach(function(icon) {
            var targetId = icon.dataset.target;
            var collapseElement = document.getElementById(targetId);

            collapseElement.addEventListener('show.bs.collapse', function () {
                icon.classList.remove('bi-caret-right-fill');
                icon.classList.remove('bi-caret-down-fill');
                icon.classList.remove('text-secondary');
                icon.classList.remove('text-primary');
                icon.classList.add('bi-caret-down-fill');
                icon.classList.add('text-primary');
            });

            collapseElement.addEventListener('hide.bs.collapse', function () {
                icon.classList.remove('bi-caret-right-fill');
                icon.classList.remove('bi-caret-down-fill');
                icon.classList.remove('text-secondary');
                icon.classList.remove('text-primary');
                icon.classList.add('bi-caret-right-fill');
                icon.classList.add('text-secondary');
            });
        });
    });
</script>
@yield('add-js')
@endsection
