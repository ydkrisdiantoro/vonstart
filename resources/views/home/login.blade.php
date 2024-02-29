
@extends('layouts.vcontrol_index')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
{{--  --}}
@endsection

@section('body')

<div id="loginPage">
    <div class="card shadow border-0">
        <div class="card-body text-center px-3 py-5 p-sm-5">
            <h4>Vonstart</h4>
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill"></i>
                Just click <b>Login</b> to try!
            </div>
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

                <div class="mx-auto d-flex justify-content-between">
                    <a class="icon-link icon-link-hover" href="#">
                        Forgot Password?
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
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
