<?php

return [
    'app_name' => env('APP_NAME', 'Vonslab'),
    'map_access' => [
        'create' => 'create',
        'store' => 'create',
        'read' => 'read',
        'edit' => 'update',
        'update' => 'update',
        'delete' => 'delete',
        'validate' => 'validate',
    ],
    'dashboard_route' => env('DASHBOARD_ROUTE', 'dashboard.read'),
    'year' => env('YEAR', false),
    'year_start' => env('YEAR_START', null),
    'year_end' => env('YEAR_END', null),
];
