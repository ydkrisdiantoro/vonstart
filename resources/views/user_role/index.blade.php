
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
                <p class="fw-bold">User Details</p>
                @foreach ($user_columns as $user_column => $user_title)
                    <p class="{{ $loop->last ? 'mb-0' : '' }}">
                        <span class="fst-italic">{{ $user_title }}</span><br>
                        <span class="fw-bold">{{ $user->{$user_column} ?? '-' }}</span>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-9">
        <div class="card shadow-card border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col text-end">
                        @if ($session['menus'][$route]['is_create'] ?? false)
                            <form method="POST"
                                action="{{ route($route.'.store') }}"
                                class="form">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <label class="d-none" for="floatingSelect">Roles</label>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <select class="form-select" id="floatingSelect" name="role_id" required>
                                            <option>-- Select Role to Add</option>
                                            @if (@$roles && sizeof($roles) > 0)
                                                @foreach ($roles as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- <div class="form-floating">
                                        </div> --}}
                                    </div>
                                    <div class="col-auto d-flex">
                                        <div class="mx-auto d-flex justify-content-end mt-auto">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle-fill me-1"></i> Add Role
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="pt-3 table-responsive">
                    <table class="table tr-hover table-stripe">
                        <caption class="fst-italic text-secondary">
                            <small>
                                {{ $title }} Table
                            </small>
                        </caption>
                        @if (sizeof($datas ?? []) > 0)
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @foreach ($show as $column => $title)
                                        <th>{{ $title }}</th>
                                    @endforeach
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration + (($datas->currentPage() - 1) * 25) }}.</td>
                                        @foreach ($show as $col => $val)
                                            <td>
                                                @if ($data->{$col} ?? false)
                                                    {{ $data->{$col} ?? '-' }}
                                                @elseif(str($col)->contains('.'))
                                                    @php
                                                        $print_relation = '-';
                                                        $relations = explode('.', $col);
                                                        if(sizeof($relations) == 2){
                                                            $print_relation = $data->{$relations[0]}->{$relations[1]};
                                                        } elseif(sizeof($relations) === 3){
                                                            $print_relation = $data->{$relations[0]}->{$relations[1]}->{$relations[2]};
                                                        }
                                                    @endphp
                                                    {{ $print_relation }}
                                                @else
                                                    <span class="badge text-bg-danger">Empty</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="nowrap text-center">
                                            @if ($session['menus'][$route]['is_delete'] ?? false)
                                                <a href="{{ route($route.'.delete', $data->id) }}"
                                                    class="btn btn-sm btn-danger btn-action delete"
                                                    data-message="{{ @$data->role->name }}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr>
                                <th>Data</th>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="fst-italic text-danger">Empty</span></td>
                            </tr>
                        @endif
                    </table>

                    @if (sizeof($datas ?? []) > 0)
                        @if($datas->total() > 1)
                            <div class="d-flex justify-content-center">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <!-- Tombol Previous -->
                                        <li class="page-prev page-item {{ $datas->previousPageUrl() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                                        </li>
                                    
                                        <!-- Tombol Nomor Halaman -->
                                        @php
                                            $prevNumber = $datas->currentPage() - 2;
                                            $nextNumber = $datas->currentPage() + 2;
                                            if($prevNumber < 0){
                                                $prevNumber = 1;
                                            }
                                            if($nextNumber > $datas->lastPage()){
                                                $nextNumber = $datas->lastPage();
                                            }
                                        @endphp
                                        @for ($i = $prevNumber; $i <= $nextNumber; $i++)
                                            <li class="page-item {{ $i == $datas->currentPage() ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $i == $datas->currentPage() ? '#' : $datas->url($i) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
                                    
                                        <!-- Tombol Next -->
                                        <li class="page-next page-item {{ $datas->nextPageUrl() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
                                        </li>
                                    </ul>                        
                                </nav>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Modal Filter --}}
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Filters</h4>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="button" class="btn btn-primary">Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('add-js')
    
@endsection