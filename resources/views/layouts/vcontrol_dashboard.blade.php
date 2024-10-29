
@extends('layouts.vcontrol_index')

@section('title')
    @php
        $semuaMenu = $session['menus'][$session['active_menu']] ?? null;
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
                @if (sizeof($session['sidebar'] ?? []) > 0)
                    @foreach ($session['sidebar'] as $menu_group_id => $menus)
                        @if (sizeof($menus ?? []) > 0)
                            <div type="button"
                                class="list-group-item border-0 mx-3 py-0 my-2"
                                data-bs-toggle="collapse"
                                data-bs-target="#group{{ $loop->iteration }}"
                                aria-expanded="true"
                                aria-controls="group{{ $loop->iteration }}"
                                href="#">
                                <div class="row px-2 rounded fw-bold">
                                    <div class="col-auto my-auto">
                                        <div class="small m-0">{{ strtoupper($session['menu_groups'][$menu_group_id]['name']) }}</div>
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
                                @foreach ($menus as $menu)
                                    @if ($menu['is_show'] && $session['menus'][$menu['route']]['is_read'] == true)
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

                    <a href="{{ route('notification.read') }}"
                        class="link-hover dropdown-toggle text-decoration-none d-flex text-dark me-4"
                        style="vertical-align: center;">
                        <i class="bi bi-bell"></i>
                        <span class="badge text-bg-secondary p-0 mb-auto"
                            style="padding: 1px!important; margin-left: -5px!important; font-size: 10px;">
                            10
                        </span>
                    </a>

                    <div class="dropdown me-1">
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

                    <div class="dropdown me-1">
                        <a class="link-hover dropdown-toggle text-decoration-none d-flex text-dark me-3"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-block me-1" style="vertical-align: center;">
                                <i class="bi bi-{{ $session['role']['icon'] ?? 'shield-fill-check' }}"></i>
                            </span>
                            <span class="d-none d-md-block" style="vertical-align: center;">
                                <span class="fst-italic">Role:</span>
                                {{ $session['role']['name'] ?? '-' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            @if ($session['roles'])
                                @foreach ($session['roles'] as $role_id => $role)
                                    <li>
                                        <a class="dropdown-item {{ $role_id == $session['role']['id'] ? 'active' : '' }}"
                                            href="{{ $role_id == $session['role']['id'] ? '#' : route('change-role.read', $role_id) }}">
                                            {{ $role['name'] ?? '-' }}
                                        </a>
                                    </li>
                                    @if (sizeof($session['roles']) == 1 && $loop->last)
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
                            @if ($session['back_from_pretend'] ?? false)
                                <i class="bi bi-eye-fill text-danger me-2"></i>
                            @else
                                <i class="bi bi-person me-2"></i>
                            @endif

                            <span class="d-none d-md-block me-2 my-auto">
                                @if(strlen($session['user']['name']) > 16)
                                    {{ substr($session['user']['name'], 0, 16).'...' }}
                                @else
                                    {{ $session['user']['name'] }}
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">
                            <li>
                                <a class="dropdown-item" href="{{ route('personal.read') }}">
                                    <i class="bi bi-gear-fill me-1"></i> Settings
                                </a>
                            </li>

                            @yield('add-navbar-dropdown')

                            <li>
                                <a class="dropdown-item" href="{{ route('logout.read') }}">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i> 
                                    @if ($session['back_from_pretend'] ?? false)
                                        End Pretend
                                    @else
                                        Logout
                                    @endif
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
                    @if ($session['back_from_pretend'] ?? false)
                        <div class="alert alert-danger">
                            <i class="bi bi-eye-fill"></i> You are now pretending to be <b>{{ $session['user']['name'] }}</b>!
                        </div>
                    @endif
                    <h4>
                        {{ $namaMenuAktif }}
                        @yield('add-content-title')
                    </h4>
                </div>

                @if (($session['notification'][$session['active_menu']]['datas'] ?? false) && sizeof($session['notification'][$session['active_menu']]['datas']) > 0)
                    <div class="col-12">
                        <div class="alert alert-light border-primary">
                            <h6 class="text-primary"><i class="bi bi-exclamation-triangle-fill"></i> Notification</h6>
                            @foreach ($session['notification'][$session['active_menu']]['datas'] as $notif)
                                <span style="color: #999;" class="me-3">
                                    {{ date('d-m-Y H:i', strtotime($notif['created_at'])) }}
                                </span>
                                {{ $notif['notification'] }}
                            @endforeach
                        </div>
                    </div>
                @endif

                @php
                    $alert = $session['alert'] ?? false;
                @endphp
                @if($alert)
                    <div class="col-12 my-3">
                        <div class="alert alert-{{ $alert[0] }} mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            {{ $alert[1] }}
                        </div>
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

<!-- Modal Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation</h5>
                <p>Did you really want to delete this item?</p>
                <div class="bg-light rounded p-2 mb-3">
                    <span id="deleteModalMessage"></span>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Delete -->

<!-- Modal Universal Alert -->
<div class="modal fade" id="confirmAlertModal" tabindex="-1" aria-labelledby="confirmAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="confirmAlertModalLabel">Confirmation</h5>
                <div class="bg-light rounded p-2 mb-3">
                    <div id="alertModalMessage"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmAlertButton">
                        <i class="bi bi-check-fill"></i> Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Universal Alert -->

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deleteLink = null;
        const deleteElements = document.querySelectorAll('.delete');

        deleteElements.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                deleteLink = this;
                const message = this.getAttribute('data-message');
                document.getElementById('deleteModalMessage').textContent = message;
                const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                deleteModal.show();
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (deleteLink) {
                window.location.href = deleteLink.href; // Lanjutkan ke URL yang disimpan di 'href'
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let alertLink = null;
        const alertElements = document.querySelectorAll('.show-alert');

        alertElements.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                alertLink = this;
                const message = this.getAttribute('data-message');
                const buttonClass = this.getAttribute('data-button-class');
                const buttonIcon = this.getAttribute('data-button-icon');
                const buttonText = this.getAttribute('data-button-text');
                document.getElementById('alertModalMessage').innerHTML = message;
                document.getElementById('confirmAlertButton').className = buttonClass;
                document.getElementById('confirmAlertButton').innerHTML = `<i class="${buttonIcon}"></i> ${buttonText}`;
                const alertModal = new bootstrap.Modal(document.getElementById('confirmAlertModal'));
                alertModal.show();
            });
        });

        document.getElementById('confirmAlertButton').addEventListener('click', function() {
            if (alertLink) {
                window.location.href = alertLink.href; // Lanjutkan ke URL yang disimpan di 'href'
            }
        });
    });
</script>

@yield('add-js')
@endsection
