
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

<div class="card shadow-card border-0 mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filter">
                    <i class="bi bi-filter-circle-fill me-1"></i> Filter
                </button>
            </div>
            <div class="col text-end">
                @if ($session['access_menus'][$route]['is_create'] ?? false)
                    <a href="{{ route($route.'.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill me-1"></i> Create
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if ($datas && sizeof($datas) > 0)
                    @foreach ($datas as $data)
                        {{--  --}}
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('add-js')
    
@endsection