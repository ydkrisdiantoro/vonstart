
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
                        action="{{ route($session['active_menu'].'.update') }}"
                        class="form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $datas->id }}">
                        <div class="form-floating">
                            <input autocomplete="off"
                                type="text"
                                name="name"
                                class="form-control"
                                id="name"
                                placeholder="Administrator"
                                value="{{ $datas->name }}"
                                autofocus
                                required>
                            <label for="name">Name</label>
                        </div>
                        <div class="mb-3 text-start">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input autocomplete="off"
                                        type="text"
                                        name="code"
                                        class="form-control"
                                        id="code"
                                        placeholder="admin"
                                        value="{{ $datas->code }}"
                                        required>
                                    <label for="code">Code</label>
                                </div>
                                <div class="mb-3 text-start">
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input autocomplete="off"
                                        type="text"
                                        name="icon"
                                        class="form-control"
                                        id="icon"
                                        placeholder="person"
                                        value="{{ $datas->icon }}"
                                        required>
                                    <label for="icon">Bootstrap Icon</label>
                                </div>
                                <div class="mb-3 text-start">
                                    @error('icon')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input autocomplete="off"
                                        type="number"
                                        name="order"
                                        class="form-control"
                                        id="order"
                                        placeholder="person"
                                        value="{{ $datas->order }}"
                                        required>
                                    <label for="order">Order</label>
                                </div>
                                <div class="mb-3 text-start">
                                    @error('order')
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