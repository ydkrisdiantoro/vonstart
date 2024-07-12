
@extends('layouts.vcontrol_dashboard')

@section('add-title')
- Settings
@endsection

@section('add-css')
{{--  --}}
@endsection

@section('add-navbar-dropdown')
    
@endsection

@section('add-content-title')
<span class="fs-6"> | Settings</span>
@endsection

@section('add-content')

<div class="row">
    <div class="col-12 col-md-3">
        <div class="list-group shadow-card">
            <a href="{{ route('personal.read') }}" class="list-group-item list-group-item-action active" aria-current="true">
                <i class="bi bi-person me-2"></i>
                <span class="">Profile</span>
            </a>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <h5>{{ $title }}</h5>
                <form method="POST"
                    action="{{ route(session('active_menu').'.update') }}"
                    class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datas->id }}">
                    <div class="form-floating">
                        <input autocomplete="off"
                            type="text"
                            name="name"
                            class="form-control"
                            id="floatingName"
                            placeholder="Bambang"
                            value="{{ old('name') ?? $datas->name }}"
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
                                    value="{{ old('email') ?? $datas->email }}"
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
                                    value="{{ old('phone') ?? $datas->phone }}"
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
                        <div class="col-12">
                            <p><i class="bi bi-exclamation-triangle-fill"></i> Change Current Password</p>
                        </div>
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