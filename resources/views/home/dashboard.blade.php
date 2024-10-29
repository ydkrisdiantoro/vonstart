
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
    <p>Welcome back, {{ $session['user']['name'] ?? 'Sir' }}!</p>
    <div class="row">
        <div class="col-12 col-lg-2 mb-3">
            <div class="list-group">
                <a href="#" class="list-group-item text-bg-primary" disabled>LIST OF CONTENT</a>
                <a href="#modalAlert" class="list-group-item list-group-item-action">Modal Alert</a>
            </div>
        </div>
        <div class="col-12 col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="p-3 bg-light rounded mb-3">
                        <p><b>Modal Alert</b> (before redirect to href in {{ '<a>' }} tag).</p>
                        <p>
                            Use: <code>show-alert</code> class and add <code>data-message, data-button-class, data-button-icon, data-button-text</code> properties.
                        </p>
                        <p>EXAMPLE</p>
                        <a href="#url"
                            class="btn btn-sm btn-danger me-1 btn-action show-alert"
                            data-message="<b>THIS IS ALERT MESSAGE WITH HTML FORMATTING</b>"
                            data-button-class="btn btn-danger"
                            data-button-icon="bi bi-trash"
                            data-button-text="DELETE NOW">
                            <i class="bi bi-trash"></i> DELETE NOW
                        </a>
                        <div class="mt-3">
                            <code id="modalAlert">
<pre class="mb-0">
{{ '<a href="#url"
    class="btn btn-sm btn-danger me-1 btn-action show-alert"
    data-message="<b>THIS IS ALERT MESSAGE WITH HTML FORMATTING</b>"
    data-button-class="btn btn-danger"
    data-button-icon="bi bi-trash"
    data-button-text="DELETE NOW">
    <i class="bi bi-trash"></i> DELETE NOW
</a>' }}
</pre>
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-js')
    
@endsection