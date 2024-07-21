
@extends('layouts.vcontrol_index')

@section('title')
    {{ $title ?? 'Error Page' }}
@endsection

@section('extra-css')
{{--  --}}
@endsection

@section('body')

<div id="loginPage">
    <div class="card shadow border-0">
        <div class="card-body text-center px-3 py-5 p-sm-5">
            <h1 class="text-danger fw-bold">
                <i class="bi bi-exclamation-triangle-fill"></i> Not Found!
            </h1>
            <p class="mb-0">The address is an Alien house.</p>
            <div class="alert alert-light fw-bold fs-2 border-danger text-danger">
                404
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-left"></i> Previous Page
            </a>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
{{--  --}}
@endsection
