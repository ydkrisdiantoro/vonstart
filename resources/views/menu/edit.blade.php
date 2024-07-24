
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
        <div class="list-group shadow-card">
            <a href="{{ route($session['active_menu'].'.read') }}"
                class="list-group-item list-group-item-action">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('menu.read', ['id' => $datas->menu_group_id]) }}" class="list-group-item list-group-item-action" aria-current="true">
                <i class="bi bi-arrow-return-right"></i>
                <span class="">Menu</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                <i class="bi bi-arrow-return-right"></i>
                <span class="">{{ $title }}</span>
            </a>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <h5>{{ $title }} <span class="text-primary">in {{ $datas->menuGroup->name }}</span></h5>
                <form method="POST"
                    action="{{ route($route.'.update') }}"
                    class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datas->id }}">
                    <input type="hidden" name="menu_group_id" value="{{ $datas->menu_group_id }}">
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
                                    type="text"
                                    name="icon"
                                    class="form-control"
                                    id="icon"
                                    placeholder="person"
                                    value="{{ old('icon') ?? $datas->icon }}"
                                    autofocus>
                                <label for="icon">Icon</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('icon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="text"
                                    name="route"
                                    class="form-control"
                                    id="route"
                                    placeholder="profil"
                                    value="{{ old('route') ?? $datas->route }}"
                                    autofocus>
                                <label for="route">Route</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('route')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="text"
                                    name="cluster"
                                    class="form-control"
                                    id="cluster"
                                    placeholder="person"
                                    value="{{ old('cluster') ?? $datas->cluster }}"
                                    autofocus>
                                <label for="cluster">Cluster</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('cluster')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="number"
                                    name="order"
                                    class="form-control"
                                    id="order"
                                    placeholder="0"
                                    value="{{ old('order') ?? $datas->order }}"
                                    autofocus>
                                <label for="order">Order</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('order')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-check form-check-inline">
                                <input name="is_show" class="form-check-input" type="radio" id="show" value="1" checked>
                                <label class="form-check-label" for="show">Show Menu in Sidebar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="is_show" class="form-check-input" type="radio" id="hide" value="0">
                                <label class="form-check-label" for="hide">Hide Menu</label>
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