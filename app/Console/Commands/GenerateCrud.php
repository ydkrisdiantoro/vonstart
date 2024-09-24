<?php

namespace App\Console\Commands;

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
        if ($isModelExists) {
            $modelName = $this->ask('Type new Model Name (singular form in English):');
            $controllerName = $modelName.'Controller';
            $serviceName = $modelName.'Service';
        }

        // View type
        $viewType = $this->ask('View type: [1] Common blade template [2] Livewire', 1);
        while (!in_array($viewType, ['1', '2'])) {
            $this->error('Invalid input. Please enter 1 or 2.');
            $viewType = $this->ask('View type: [1] Common blade template [2] Livewire');
        }

        // Try to generate CRUD
        try {
            $this->generateModel($modelName, $tableName);
            $this->generateService($tableName, $modelName, $serviceName);
            $this->generateController($controllerName, $singularTableName);
            $this->generateViews($singularTableName);
            $this->generateRoutes($singularTableName);

            $info = 'CRUD from '.$tableName.' generated successfully';
        } catch (\Throwable $th) {
            $info = 'ERROR '.$th->getMessage();
        }

        $this->info($info);
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
    }

    protected function generateController($name, $tableName)
    {
        $serviceName = $name.'Service';
        $controllerName = $name.'Controller';
        $title = "'".ucwords(str_replace('_', ' ', $tableName), ' ')."'";
        $route = "'".$tableName."'";
        $view = "'".$tableName."'";
        $tableColumns = '';
        $columns = collect(Schema::getColumnListing($tableName));
        foreach($columns as $column){
            if ($column != 'id' && substr($column, -3) != '_id') {
                $tableColumns .= "'".$column."' => '".ucwords(str_replace('_', ' ', $column), ' ')."',";
            } elseif(substr($column, -3) == '_id'){
                $newColumn = '';
                $tableColumns .= "'".$newColumn."' => '".ucwords(str_replace('_', ' ', $column), ' ')."',";
            }
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
            ],
            [
                $serviceName,
                $controllerName,
                $title,
                $route,
                $view,
                $tableColumns,
            ],
            $stub
        );

        File::put(app_path("/Http/Controllers/{$name}Controller.php"), $controllerContent);
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
        dd('sampe sini dulu ygy');
    }

    protected function generateViews($name)
    {
        // $stub = File::get(base_path('stubs/view.stub'));
        // $viewContent = str_replace('{{ modelName }}', $name, $stub);

        // $viewPath = resource_path("views/{$name}");
        // if (!File::exists($viewPath)) {
        //     File::makeDirectory($viewPath);
        // }

        // File::put("{$viewPath}/index.blade.php", $viewContent);
        // File::put("{$viewPath}/create.blade.php", $viewContent);
        // File::put("{$viewPath}/edit.blade.php", $viewContent);
        // File::put("{$viewPath}/show.blade.php", $viewContent);
    }
}
