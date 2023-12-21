
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
        <div class="card-body text-center">
            <h4>Login</h4>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" autofocus>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="mx-auto d-flex justify-content-between mt-3">
                <a href="#" class="my-auto">Lupa Password?</a>
                <button type="submit" class="btn btn-primary">
                    <i data-feather="log-in" class="me-2"></i> Login
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
{{--  --}}
@endsection
