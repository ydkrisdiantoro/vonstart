
@extends('layouts.vcontrol_index')

@section('title')
{{--  --}}
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
            <span class="ms-auto me-3 my-auto d-md-none">
                <a type="button" id="btnDismissSidebar" class="fs-4 hover-icon">
                    <i data-feather="x"></i>
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

            @yield('menus')

        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="bg-light">

        <nav id="navbar" class="navbar text-dark bg-white fixed-top px-md-3 px-2 shadow"
            aria-labelledby="navbar">
            <div class="container-fluid justify-content-between">
                <a type="button" id="btnToggleSidebar" class="fs-4 hover-icon">
                    <i data-feather="menu"></i>
                </a>
                <div>

                    @yield('navbar-extra')

                    <div class="dropdown">
                        <a class="dropdown-toggle text-decoration-none d-flex"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-block">Username</span>
                            <span class="material-symbols-rounded ms-2">account_circle</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 text-right mt-4 shadow">

                            @yield('navbar-dropdown-item')

                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            
            <div class="row">
                <div class="col-12 mb-3">
                    <h4>

                        @yield('main-title')

                    </h4>
                </div>
                <div class="col-12">

                    @yield('main-content')

                </div>
            </div>

        </main>

        <footer>

            @yield('footer')

        </footer>
    </div>
</div>

@endsection

@section('extra-js')
{{--  --}}
@endsection
