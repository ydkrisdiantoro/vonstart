
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
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filter" disabled>
                    <i class="bi bi-filter-circle-fill me-1"></i> Filter
                </button>
            </div>
            <div class="col text-end">
                @if ($session['menus'][$route]['is_create'] ?? false)
                    <a href="{{ route($route.'.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill me-1"></i> Create
                    </a>
                @endif
            </div>
            <div class="col-12 mt-2">
                @if ($filters)
                    @foreach ($filters as $filterKey => $filter)
                        @if ($filter !== null)
                            <span class="badge text-bg-secondary">
                                #{{ $show[$filterKey].': '.$filter }}
                            </span>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <div class="pt-3 table-responsive">
            <table class="table tr-hover table-stripe">
                <caption class="fst-italic text-secondary">
                    <small>
                        {{ $session['menus'][$session['active_menu']]['name'] }} Table
                    </small>
                </caption>
                @if (sizeof($datas ?? []) > 0)
                    <thead>
                        <tr>
                            @foreach ($show as $column => $title)
                                <th>{{ $title }}</th>
                            @endforeach
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                @foreach ($show as $col => $val)
                                    <td>
                                        @if ($data->{$col} ?? false)
                                            @if ($col == 'icon')
                                                <i class="bi bi-{{ $data->{$col} }}"></i>
                                            @elseif($col == 'code')
                                                <span class="fst-italic">{{ $data->{$col} }}</span>
                                            @else
                                                {{ $data->{$col} ?? '-' }}
                                            @endif
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
                                    @if ($session['menus'][$role_menu_route]['is_read'] ?? false)
                                        <a href="{{ route($role_menu_route.'.read', ['id' => $data->id]) }}"
                                            class="btn btn-sm btn-primary me-1 btn-action">
                                            <i class="bi bi-person-gear"></i> Role Menus
                                        </a>
                                    @endif
                                    @if ($session['menus'][$route]['is_update'] ?? false)
                                        <a href="{{ route($route.'.edit', $data->id) }}"
                                            class="btn btn-sm btn-secondary me-1 btn-action">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endif
                                    @if ($session['menus'][$route]['is_delete'] ?? false)
                                        <a href="{{ route($route.'.delete', $data->id) }}"
                                            class="btn btn-sm btn-danger btn-action delete"
                                            data-message="{{ @$data->name }}">
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
                                    if($prevNumber < 1){
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