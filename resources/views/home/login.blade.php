
@extends('layouts.vcontrol_index')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/vonstemp.css') }}">
@endsection

@section('body')

<div id="loginPage">
    <div class="card shadow border-0">
        <div class="card-body text-center px-3 py-5 p-sm-5">
            <h4>Vonstart</h4>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="form-floating">
                    <input type="email"
                        name="email"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                        value="{{ old('email') ?? 'su@admin.dev' }}"
                        autofocus>
                    <label for="floatingInput">Email Address</label>
                </div>
                <div class="mb-3 text-start">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password"
                        name="password"
                        class="form-control"
                        id="floatingPassword"
                        placeholder="Password"
                        value="{{ old('password') !== null ? old('password') : 'sup3rUSER' }}">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="mb-3 text-start">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                @if($session['alert'] ?? false)
                    <div class="mb-3 text-{{ $session['alert'][0] }}">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        {{ $session['alert'][1] }}
                    </div>
                @endif

                <div class="mx-auto d-flex justify-content-between">
                    <a class="link" href="{{ route('forget_password') }}">
                        Forgot Password?
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Login
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
{{--  --}}
@endsection
