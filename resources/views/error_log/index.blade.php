
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                @foreach ($show as $col => $val)
                                    <td>
                                        @if ($col == 'created_at')
                                            @php
                                                $timestamp = strtotime($data->{$col});
                                                $currentDate = strtotime('today'); // Mendapatkan timestamp untuk hari ini
                                                
                                                if (date('Y-m-d', $timestamp) === date('Y-m-d', $currentDate)) {
                                                    $formattedDate = 'Today at ' . date('H:i', $timestamp);
                                                } else {
                                                    $formattedDate = date('Y F d \a\t H:i', $timestamp);
                                                }
                                            @endphp
                                            {{ $formattedDate }}
                                        @elseif ($col == 'file')
                                            {{ '...'.substr($data->{$col}, -40) }}
                                        @elseif ($data->{$col} ?? false)
                                            {{ $data->{$col} ?? '-' }}
                                        @elseif(str($col)->contains('.'))
                                            @php
                                                $print_relation = null;
                                                $relations = explode('.', $col);
                                                if(sizeof($relations) == 2){
                                                    $print_relation = @$data->{$relations[0]}->{$relations[1]};
                                                } elseif(sizeof($relations) === 3){
                                                    $print_relation = @$data->{$relations[0]}->{$relations[1]}->{$relations[2]};
                                                }
                                            @endphp
                                            @if ($print_relation)
                                                {{ $print_relation ?? '-' }}
                                            @else
                                                <span class="badge text-bg-danger">Empty</span>
                                            @endif
                                        @else
                                            <span class="badge text-bg-danger">Empty</span>
                                        @endif
                                    </td>
                                @endforeach
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

            @if (@$datas && sizeof($datas ?? []) > 0)
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
                <form action="{{ route($route.'.filter.read') }}" method="post" class="form">
                    @csrf
                    <div class="row mb-3">
                        @if (@$form_filters && sizeof($form_filters) > 0)
                            @foreach ($form_filters as $ffcol => $ff)
                                <div class="col-12 mb-2">
                                    @switch($ff['type'])
                                        @case('text')
                                            <div class="form-floating">
                                                <input autocomplete="off"
                                                    type="text"
                                                    name="{{ $ffcol }}"
                                                    class="form-control"
                                                    id="{{ $ffcol }}"
                                                    placeholder="person"
                                                    value="{{ old($ffcol) }}"
                                                    autofocus>
                                                <label for="{{ $ffcol }}">{{ $ff['title'] }}</label>
                                            </div>
                                            @break
                                        @case(2)
                                            <div>ini</div>
                                            @break
                                        @default
                                    @endswitch
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('add-js')
    
@endsection