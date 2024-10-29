
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

@error('id')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="row">
    <div class="col-12 col-lg-3">
        <div class="list-group shadow-card mb-3">
            <a href="{{ route($session['active_menu'].'.read') }}"
                class="list-group-item list-group-item-action">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="card shadow-card mb-3 border-0">
            <div class="card-body">
                <p class="fw-bold">Role Details</p>
                @foreach ($role_columns as $role_column => $role_title)
                    <p class="{{ $loop->last ? 'mb-0' : '' }}">
                        <span class="fst-italic">{{ $role_title }}</span><br>
                        <span class="fw-bold">
                            @if ($role_column == 'icon')
                                <i class="bi bi-{{ $role->{$role_column} }}"></i>
                            @else
                                {{ $role->{$role_column} ?? '-' }}
                            @endif
                        </span>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route($route.'.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        @if (sizeof($menus ?? []) > 0)
                            @php
                                $noMenu = 0;
                            @endphp
                            @foreach ($menus as $menuGroup)
                                @php
                                    $noMenu += 1;
                                @endphp
                                @foreach ($menuGroup as $menu)
                                    @if ($loop->first)
                                        <div class="col-12 fw-bold">{{ $menu->menuGroup->name }}</div>
                                    @endif
                                    <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                                    <div class="col-12 py-2">
                                        <div class="row px-3">
                                            <div class="col-4">
                                                {{ $menu->name }}
                                            </div>
                                            <div class="col-8 d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input name="is_read[]" class="form-check-input" type="checkbox" value="{{ $menu->id }}" id="read{{ $noMenu.$loop->iteration }}" {{ @$datas[$menu->id]->is_read == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="read{{ $noMenu.$loop->iteration }}" type="button">Read</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="is_create[]" class="form-check-input" type="checkbox" value="{{ $menu->id }}" id="create{{ $noMenu.$loop->iteration }}" {{ @$datas[$menu->id]->is_create == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="create{{ $noMenu.$loop->iteration }}" type="button">Create</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="is_update[]" class="form-check-input" type="checkbox" value="{{ $menu->id }}" id="update{{ $noMenu.$loop->iteration }}" {{ @$datas[$menu->id]->is_update == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="update{{ $noMenu.$loop->iteration }}" type="button">Update</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="is_delete[]" class="form-check-input" type="checkbox" value="{{ $menu->id }}" id="delete{{ $noMenu.$loop->iteration }}" {{ @$datas[$menu->id]->is_delete == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="delete{{ $noMenu.$loop->iteration }}" type="button">Delete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="is_validate[]" class="form-check-input" type="checkbox" value="{{ $menu->id }}" id="validate{{ $noMenu.$loop->iteration }}" {{ @$datas[$menu->id]->is_validate == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="validate{{ $noMenu.$loop->iteration }}" type="button">Validate</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($loop->last)
                                    <div class="col-12 text-center pt-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-check-circle-fill"></i> Save
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <p class="text-center"><span class="fst-italic text-danger">Empty</span></p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('add-js')
    
@endsection