
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
        <p>Pretend to be someone else ...</p>
        <form action="{{ route('pretend.find.read') }}" method="post" class="form">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input autocomplete="off"
                            type="text"
                            name="keyword"
                            class="form-control"
                            id="floatingName"
                            placeholder="Bambang"
                            value="{{ $filters['keyword'] ?? old('keyword') }}"
                            autofocus
                            required>
                        <label for="floatingName">Find by Name/Email</label>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if (@$datas && sizeof($datas) > 0)
    <div class="row">
        @foreach ($datas as $data)
            @php
                $sizeofRole = sizeof($data->userRoles);
            @endphp
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-card border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                @foreach ($show as $user_column => $user_title)
                                    <p>
                                        <span class="fst-italic">{{ $user_title }}</span><br>
                                        <span class="fw-bold">{{ $data->{$user_column} ?? '-' }}</span>
                                        <br>
                                    </p>
                                @endforeach
                            </div>

                            @if (sizeof($data->userRoles) > 0)
                                <a href="{{ route('pretend.select.read', ['id' => $data->id]) }}" class="btn btn-sm btn-primary mb-auto" style="white-space: nowrap">
                                    <i class="bi bi-eye"></i> Pretend
                                </a>
                            @else
                                <div href="{{ '#' }}" class="badge text-bg-danger mb-auto disabled">
                                    <i class="bi bi-ban"></i> Has No Role
                                </div>
                            @endif
                        </div>

                        <div>
                            <span class="mb-0" style="font-size: 10pt; color: #a4a4a4;">
                                <b>Roles: </b>
                                @foreach ($data->userRoles as $userRole)
                                    {{ $userRole->role->name }}
                                    @if ($sizeofRole > 1 && !$loop->last)
                                        {{ ', ' }}
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection

@section('add-js')
    
@endsection