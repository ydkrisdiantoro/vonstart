<?php

namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\MenuGroup;
use App\Models\RoleMenu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Model, Controller, View, & Service from migrated table';

    /**
     * Execute the console command.
     */
    public function handle(){
        // Get Table Name & Generate other resources name
        $tableName = $this->ask('Type the table name you have already migrated (plural form in English)');
        $singularTableName = Str::singular($tableName);
        $modelName = $this->camelCase($singularTableName);
        $controllerName = $modelName.'Controller';
        $serviceName = $modelName.'Service';

        // Confirm is model exists
        $isModelExists = $this->ask('Is Model with the name '.$modelName.' already exists? [yes/no]', 'no');
        while(!in_array($isModelExists, ['yes','no'])){
            $isModelExists = $this->ask('Is Model with the name '.$modelName.' already exists? [yes/no]', 'no');
        }

        if ($isModelExists == 'yes') {
            $modelName = $this->ask('Type new Model Name (singular form in English):');
            $controllerName = $modelName.'Controller';
            $serviceName = $modelName.'Service';
        }

        $menuGroups = MenuGroup::orderBy('order')->pluck('name', 'order')->toArray();
        $whichGroupMenu = $this->choice('Choose group menu:', $menuGroups, 1);
        $selectedGroupMenu = MenuGroup::where('order', array_flip($menuGroups)[$whichGroupMenu])->first()->id;
        $showMenu = $this->ask('Show menu in sidebar? [yes/no]', 'yes');
        $showMenu == 'yes' ? $showMenu = 1 : $showMenu = 0;
        $icon = $this->ask('Bootstrap icon (without bi bi-): ', 'circle');

        // Try to generate CRUD
        try {
            $this->generateModel($modelName, $tableName);
            $this->generateService($tableName, $modelName, $serviceName);
            $this->generateController($controllerName, $singularTableName, $tableName);
            $this->generateViews($tableName, $singularTableName, $modelName);
            $this->generateRoutes(Str::snake($modelName), $controllerName);
            $this->generateMenuData(Str::snake($modelName), $selectedGroupMenu, $showMenu, $icon);

            $info = 'CRUD from '.$tableName.' generated successfully';
        } catch (\Throwable $th) {
            $info = 'ERROR '.$th->getMessage();
        }

        $this->info($info);
        $this->call('optimize');
        $this->info('Optimized!');
    }

    protected function camelCase($snakeCase){
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }

    protected function generateModel($modelName, $tableName){
        $fillableList = [];
        $relationshipsMethods = '';

        $columns = Schema::getColumns($tableName);
        foreach ($columns as $column) {
            if (substr($column['name'], -3) == '_id') {
                $newColumn = str_replace('_', '', ucwords(substr($column['name'], 0, -3), '_'));
                $relationshipsMethods .= '
    public function '.lcfirst($newColumn).'(){
        return $this->belongsTo('.$newColumn.'::class);
    }';
            }

            if (!in_array($column['name'], ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                $fillableList[] = $column['name'];
            }
        }

        $fillable = "['".implode("','", $fillableList)."']";
        $stub = File::get(base_path('stubs/model.stub'));
        $modelContent = str_replace(
            ['{{ modelName }}', '{{ table }}', '{{ fillable }}', '{{ relationshipsMethods }}'],
            [$modelName, "'".$tableName."'", $fillable, $relationshipsMethods],
            $stub
        );

        File::put(app_path("/Models/{$modelName}.php"), $modelContent);
        $this->info("Model {$modelName} added.");
    }

    protected function generateController($controllerName, $singularTableName, $tableName)
    {
        $serviceName = str_replace('Controller', 'Service', $controllerName);
        $title = "'".ucwords(str_replace('_', ' ', $singularTableName), ' ')."'";
        $route = "'".$singularTableName."'";
        $view = "'".$singularTableName."'";
        $tableColumns = '';
        $refData = '';
        $importRefData = '';
        $formFilters = '[';
        $columns = collect(Schema::getColumnListing($tableName));
        foreach($columns as $column){
            if (substr($column, -3) != '_id' && !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                $tableColumns .= "
            '".$column."' => '".ucwords(str_replace('_', ' ', $column), ' ')."',";
            } elseif(substr($column, -3) == '_id'){
                $newColumn = str_replace('_', '', ucwords(substr($column, 0, -3), '_'));
                $tableColumns .= "
            '".lcfirst($newColumn).".name' => '".ucwords(str_replace('_', ' ', substr($column, 0, -3)), ' ')."',";
                $refData .= '$datas['."'".substr($column, 0, -3)."'".'] = '.$newColumn.'::pluck('."'".'name'."'".', '."'".'id'."'".');
    ';
                $importRefData .= 'use App\Models\\'.$newColumn.';
    ';
            }

            if ($column == 'names') {
                $formFilters .= '
            '."'name' => [
                'title' => 'Find Name',
                'type' => 'text',
            ],
        ";
            }
        }
        $formFilters .= ']';

        if ($formFilters == '[]') {
            $formFilters = '[
            // column => [
            //      title => Column Title
            //      type => text    
            // ]
        ]';
        }

        $stub = File::get(base_path('stubs/controller.stub'));
        $controllerContent = str_replace(
            [
                '{{ serviceName }}',
                '{{ controllerName }}',
                '{{ title }}',
                '{{ route }}',
                '{{ view }}',
                '{{ tableColumns }}',
                '{{ refData }}',
                '{{ importRefData }}',
                '{{ formFilters }}'
            ],
            [
                $serviceName,
                $controllerName,
                $title,
                $route,
                $view,
                $tableColumns,
                $refData,
                $importRefData,
                $formFilters,
            ],
            $stub
        );

        File::put(app_path("/Http/Controllers/{$controllerName}.php"), $controllerContent);
        $this->info("{$controllerName} added.");
    }

    protected function generateService($tableName, $modelName, $serviceName)
    {
        $rules = '[';

        $columns = Schema::getColumns($tableName);
        $withColumn = '[';
        foreach ($columns as $column) {
            $columnType = 'string';
            if (in_array($column['type_name'], ['int', 'tinyint', 'smallint', 'bigint', 'decimal', 'float'])){
                $columnType = 'numeric';
            } elseif($column['type'] == 'char(36)'){
                $columnType = 'string|min:36|max:36';
            } elseif($column['type'] == 'tinyint(1)'){
                $columnType = 'numeric|in:0,1';
            } elseif($column['type'] == 'datetime'){
                $columnType = 'date';
            } elseif($column['type'] == 'date'){
                $columnType = 'date';
            }

            if (!in_array($column['name'], ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                if ($column['nullable'] !== true) {
                    $rule = 'required|'.$columnType;
                } else{
                    $rule = 'nullable|'.$columnType;
                }

                $rules .= "
            '".$column['name']."' => '".$rule."',";

                if (substr($column['name'], -3) == '_id') {
                    $newColumn = str_replace('_', '', ucwords(substr($column['name'], 0, -3), '_'));
                    $withColumn .= "'".lcfirst($newColumn)."',";
                }
            }
        }
        $rules .= '
        ]';
        if ($withColumn != '[') {
            $withColumn = substr($withColumn, 0, -1).']';
        } else{
            $withColumn = '[]';
        }

        $stub = File::get(base_path('stubs/service.stub'));
        $serviceContent = str_replace(
            [
                '{{ serviceName }}',
                '{{ modelName }}',
                '{{ snakeModelName }}',
                '{{ rules }}',
                '{{ withColumn }}',
            ],
            [
                $serviceName,
                $modelName,
                lcfirst($modelName),
                $rules,
                $withColumn,
            ],
            $stub
        );

        File::put(app_path("/Services/{$modelName}Service.php"), $serviceContent);
        $this->info("Service '.$serviceName.' added.");
    }

    protected function generateViews($tableName, $singularTableName, $modelName)
    {
        $stubIndex = File::get(base_path('stubs/index.stub'));
        $stubCreate = File::get(base_path('stubs/create.stub'));
        $stubEdit = File::get(base_path('stubs/edit.stub'));
        $viewIndex = $stubIndex;

        // Buat form berdasarkan tabel
        $columns = Schema::getColumns($tableName);
        $forms = '';
        foreach ($columns as $column) {
            if (in_array($column['type_name'], ['int', 'tinyint', 'smallint', 'bigint', 'decimal', 'float'])){
                $formatNumber = true;
            }
            if (substr($column['name'], -3) == '_id') {
                $refTable = str_replace('_', ' ', ucwords(substr($column['name'], 0, -3), '_'));
                $forms .= '
                    <div class="form-floating mb-3">
                        <select class="form-select"
                            name="'.$column['name'].'"
                            id="'.$column['name'].'"
                            aria-label="Floating label '.$refTable.'">
                            @if(sizeof($'.substr($column['name'], 0, -3).' ?? []) > 0)
                                @foreach($'.substr($column['name'], 0, -3).' as $optionId => $optionName)
                                    <option value="{{ $optionId }}"
                                        {{ $optionId == @$datas->'.$column['name'].' ? "selected" : "" }}>
                                        {{ $optionName }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <label for="'.substr($column['name'], 0, -3).'">'.$refTable.'</label>
                    </div>
    ';
                if ($formatNumber ?? false) {
                    $forms = str_replace('{{ $optionName }}', '{{ number_format($optionName) }}', $forms);
                }
            }elseif(!in_array($column['name'], ['id', 'created_at', 'updated_at', 'deleted_at'])){
                $refTable = str_replace('_', ' ', ucwords(substr($column['name'], 0), '_'));
                $columnType = 'text';
                if($column['type_name'] == 'date'){
                    $columnType = 'date';
                } elseif($column['type_name'] == 'time'){
                    $columnType = 'time';
                } elseif(in_array($column['type_name'], ['datetime', 'dateTime', 'datetime-local'])){
                    $columnType = 'datetime-local';
                }

                $forms .= '
                    <div class="form-floating">
                        <input autocomplete="off"
                            type="'.$columnType.'"
                            name="'.$column['name'].'"
                            class="form-control"
                            id="floating'.$refTable.'"
                            placeholder="Bambang"
                            value="{{ old('."'".$column['name']."'".') ?? ($datas->'.$column['name'].' ?? null) }}"
                            autofocus>
                        <label for="floating'.$refTable.'">'.$refTable.'</label>
                    </div>
                    <div class="mb-3 text-start">
                        @error('."'".$column['name']."'".')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
    ';
            }
        }

        $viewCreate = str_replace('{{ forms }}', $forms, $stubCreate);
        $viewEdit = str_replace('{{ forms }}', $forms, $stubEdit);

        $snake = Str::snake($modelName);
        $viewPath = resource_path("views/{$snake}");
        if (!File::exists($viewPath)) {
            File::makeDirectory($viewPath);
        }

        File::put("{$viewPath}/index.blade.php", $viewIndex);
        File::put("{$viewPath}/create.blade.php", $viewCreate);
        File::put("{$viewPath}/edit.blade.php", $viewEdit);
        $this->info("Blade view added (index, create, edit).");
    }

    public function generateRoutes($route, $controllerName)
    {
        $routePath = base_path('routes/web.php');
        $routes = File::get($routePath);
        $useStatement = "use App\Http\Controllers\\{$controllerName};";

        if (!Str::contains($routes, $useStatement) &&
            Str::contains($routes, "use Illuminate\Support\Facades\Route;")) {
            $newRoutes = str_replace(
                "use Illuminate\Support\Facades\Route;", 
                "use Illuminate\Support\Facades\Route;\n" . $useStatement, 
                $routes
            );
            File::put($routePath, $newRoutes);
        }

        $routeDefinition = "
\$slug = '{$route}';
Route::middleware(['auth', 'access'])->group(function () use(\$slug) {
    Route::get('/'.\$slug, [{$controllerName}::class, 'index'])->name(\$slug.'.read');
    Route::get('/'.\$slug.'/create', [{$controllerName}::class, 'create'])->name(\$slug.'.create');
    Route::post('/'.\$slug.'/store', [{$controllerName}::class, 'store'])->name(\$slug.'.store');
    Route::post('/'.\$slug.'/filter', [{$controllerName}::class, 'filter'])->name(\$slug.'.filter.read');
    Route::get('/'.\$slug.'/edit/{id}', [{$controllerName}::class, 'edit'])->name(\$slug.'.edit');
    Route::post('/'.\$slug.'/update', [{$controllerName}::class, 'update'])->name(\$slug.'.update');
    Route::get('/'.\$slug.'/delete/{id}', [{$controllerName}::class, 'destroy'])->name(\$slug.'.delete');
});
";

        if (!Str::contains($routes, "\$slug = '{$route}") && 
            !Str::contains($routes, "[{$controllerName}::class, 'index']")) {
            // Jika belum ada, tambahkan ke file routes
            File::append($routePath, "\n" . $routeDefinition);
            $this->info("Route {$route} added.");
        } else {
            $this->info("Route {$route} already added. Skipped.");
        }
    }

    public function generateMenuData($route, $menuGroupId, $isShowMenu, $icon)
    {
        $last = Menu::where('menu_group_id', $menuGroupId)
            ->orderBy('order', 'desc')
            ->first();

        $order = 1;
        if ($last) {
            $order = $last->order + 1;
        }

        $saveMenu = Menu::firstOrCreate([
            'route' => $route,
            'menu_group_id' => $menuGroupId,
        ],[
            'name' => str_replace('_', ' ', ucwords($route, '_')),
            'icon' => $icon,
            'is_show' => $isShowMenu,
            'cluster' => null,
            'order' => $order,
        ]);

        if ($saveMenu) {
            $this->info("Menu added to Database.");
            $saveRoleMenu = RoleMenu::firstOrCreate([
                'menu_id' => $saveMenu->id,
                'role_id' => config('vcontrol.superuser_role_id'),
            ],[
                'is_create' => 1,
                'is_read' => 1,
                'is_update' => 1,
                'is_delete' => 1,
                'is_validate' => 1,
            ]);

            if ($saveRoleMenu) {
                $this->info("Privilege added to Database.");
            }
        }
    }
}
