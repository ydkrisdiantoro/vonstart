
@extends('layouts.vcontrol_dashboard')

@section('add-title')

@endsection

@section('add-css')
{{--  --}}
@endsection

@section('add-navbar-dropdown')
    
@endsection

@section('add-content-title')

@endsection

@section('add-content')

<div class="row">
    <div class="col-12 col-md-3">
        <div class="list-group shadow-card mb-3">
            <a href="#" class="list-group-item border-0 fw-bold">Navigate To</a>
            <a href="{{ route(session('active_menu').'.read', []) }}"
                class="list-group-item list-group-item-action">
                <i class="bi bi-arrow-return-right"></i>
                {{ session('route_menus')[session('active_menu')]['name'] }}
            </a>
            @foreach ($breadcrumbs as $breadcrumbRoute => $breadcrumb)
                <a href="{{ route($breadcrumbRoute, $breadcrumb['params']) }}"
                    class="list-group-item list-group-item-action {{ $breadcrumb['is_active'] === true ? 'active' : '' }}"
                    aria-current="true">
                    <i class="bi bi-arrow-return-right"></i>
                    <span>{{ $breadcrumb['title'] }}</span>
                </a>
            @endforeach
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                <i class="bi bi-arrow-return-right"></i>
                <span class="">{{ $title }}</span>
                <i class="bi bi-check-circle-fill"></i>
            </a>
        </div>

        <div class="card shadow-card mb-3 border-0">
            <div class="card-body">
                <p class="fw-bold">User Details</p>
                @foreach ($user_columns as $user_column => $user_title)
                    <p class="{{ $loop->last ? 'mb-0' : '' }}">
                        <span class="fst-italic">{{ $user_title }}</span><br>
                        <span class="fw-bold">{{ $user->{$user_column} ?? '-' }}</span>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <h5>{{ $title }}</h5>
                <form method="POST"
                    action="{{ route(session('active_menu').'.store') }}"
                    class="form">
                    @csrf
                    
                    <div class="form-floating">
                        <input autocomplete="off"
                            type="text"
                            name="name"
                            class="form-control"
                            id="floatingName"
                            placeholder="Bambang"
                            value="{{ old('name') }}"
                            autofocus>
                        <label for="floatingName">Name</label>
                    </div>
                    <div class="mb-3 text-start">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="floatingEmail"
                                    placeholder="name@example.com"
                                    value="{{ old('email') }}"
                                    autofocus>
                                <label for="floatingEmail">Email Address</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    id="floatingPhone"
                                    placeholder="010100001111"
                                    value="{{ old('phone') }}"
                                    autofocus>
                                <label for="floatingPhone">Phone</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    id="floatingPassword"
                                    placeholder="Password"
                                    value="{{ old('password') }}">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="password"
                                    name="confirm_password"
                                    class="form-control"
                                    id="floatingConfirmPassword"
                                    placeholder="Confirm Password"
                                    value="{{ old('confirm_password') }}">
                                <label for="floatingConfirmPassword">Confirm Password</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('confirm_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <div class="mx-auto d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle-fill me-1"></i> Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('add-js')
    
@endsection