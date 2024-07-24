
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
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                <i class="bi bi-arrow-return-right"></i>
                <span class="">{{ $title }}</span>
            </a>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <h5>{{ $title }}</h5>
                <form method="POST"
                    action="{{ route($session['active_menu'].'.store') }}"
                    class="form">
                    @csrf
                    
                    <div class="form-floating">
                        <input autocomplete="off"
                            type="text"
                            name="name"
                            class="form-control"
                            id="name"
                            placeholder="Bambang"
                            value="{{ old('name') }}"
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
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input autocomplete="off"
                                    type="number"
                                    name="order"
                                    class="form-control"
                                    id="floatingEmail"
                                    placeholder="1"
                                    value="{{ old('order') }}"
                                    required>
                                <label for="floatingEmail">Order</label>
                            </div>
                            <div class="mb-3 text-start">
                                @error('order')
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