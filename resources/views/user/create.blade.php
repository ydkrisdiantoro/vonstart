
@extends('layouts.vcontrol_dashboard')

@section('add-title')

@endsection

@section('add-css')
{{--  --}}
@endsection

@section('add-navbar-dropdown')
    
@endsection

@section('add-content-title')
<span class="fs-6"> | {{ $title }}</span>
@endsection

@section('add-content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body row">
                <div class="col"></div>
                <div class="col-12 col-lg-10 col-xl-8">
                    <h5 class="text-center">{{ $title }}</h5>
                    <form method="POST"
                        action="{{ route($session['active_menu'].'.store') }}"
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
                                autofocus
                                required>
                            <label for="floatingName">Name <span class="text-danger">*</span></label>
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
                                        required>
                                    <label for="floatingEmail">Email Address <span class="text-danger">*</span></label>
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
                                        value="{{ old('phone') }}">
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
                                        value="{{ old('password') }}"
                                        required>
                                    <label for="floatingPassword">Password <span class="text-danger">*</span></label>
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
                                        value="{{ old('confirm_password') }}"
                                        required>
                                    <label for="floatingConfirmPassword">Confirm Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="mb-3 text-start">
                                    @error('confirm_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
        
                        <div class="mx-auto d-flex justify-content-between">
                            <a href="{{ route($session['active_menu'].'.read') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle-fill me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle-fill me-1"></i> Save
                            </button>
                        </div>
    
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('add-js')
    
@endsection