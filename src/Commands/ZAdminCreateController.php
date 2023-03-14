<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use PHPUnit\Util\Reflection;
use ReflectionClass;
use Illuminate\Support\Str;


class ZAdminCreateController extends Command
{
    public $signature = 'admin:create {modelName}';

    public $description = "Command for create Controller,Request,route for model and import auth routes in your application";

    public static $authRoutesDefinition = "\zedsh\zadmin\Helpers\AdminAuth::routes(\n
    [\n
        'login' => true,\n
        'register' => true,\n
        'logout' => true\n
    ],\n
    'admin',\n
    'admin'\n
);\n";

    public static $newAdminRoute = "Route::prefix('/admin')->middleware(['auth'])->group(function () {\n
    Route::resource('new-admin-route', NewAdminRouteController::class);\n
});\n";


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->isModelExists()) {
            $this->createController();
        } else {
            $this->components->error("Model name did not recognized or model don't exist in your project");
        }
    }

    protected function createController()
    {
        $pathFrom = __DIR__ . '/assets/expand/createController/NewController.php';
        $pathTo = app_path('Http/Controllers/Admin/' . $this->argument('modelName') . 'Controller.php');

        $fillable = $this->parseModel();

        $addEdit = [];
        foreach ($fillable as $field) {
            $addEdit[] = "            new TextField('" . $field . "', '" . $field . "'),\n";
        }

        $list = "            (new TextColumn('id', '#'))->setWidth(50),\n";
        foreach ($fillable as $field) {
            if ($field === 'name') {
                $list = $list . "            (new TextColumn('name', 'name')),\n";
            }
        }

        $searchToReaplace = [
            'resource_name' => strtolower($this->argument('modelName')),
            'NewController'=> $this->argument('modelName') . 'Controller',
            'protected $modelClass = null;' => 'protected $modelClass = ' . $this->argument('modelName') . '::class' . ';',
            'use App\Models\News;' => 'use App\Models\\' . $this->argument('modelName') . ';',
            'use App\Http\Requests\Admin\TagStoreUpdateRequest;' => 'use App\Http\Requests\Admin\\' . $this->argument('modelName') . 'Request;',
            'protected $request = null;' => 'protected $request = ' . $this->argument('modelName') . 'Request::class;',
            "return [];\n" => "return [\n" . implode('', $addEdit) . "        ];\n",
            "return [ (new TextColumn('id', '#'))->setWidth(50), ];" => "return [\n" . $list . "        ];\n"
        ];

        $this->replaceInFile($searchToReaplace, $pathFrom, $pathTo);
        $this->createRequest();
        $this->createResourceRoute();
        $this->createAuthRoutes();
    }


    protected function isModelExists()
    {
        $modelName = 'App\Models\\' . $this->argument('modelName');

        if (class_exists($modelName)) {
            return true;
        }

        return false;
    }


    protected function parseModel(): array
    {
        $modelName = 'App\Models\\' . $this->argument('modelName');
        $model = new $modelName();

        $properties = array();
        $reflection = new ReflectionClass($model);
        $properties = $reflection->getProperties();
        foreach ($properties as $property)
        {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($model);
            if (!$property->isPublic()) {
                $property->setAccessible(false);
            }
        }

        $fillable = $properties['fillable'];

        return $fillable;
    }

    protected function createResourceRoute()
    {
        $routesFilePath = app_path() . '/../routes/web.php';
        $routesFile = file_get_contents($routesFilePath);
        $searchToReplace = [
            'new-admin-route' => $this->argument('modelName'),
            'NewAdminRouteController::class' => '\App\Http\Controllers\Admin\\' . $this->argument('modelName') . "Controller::class"
        ];
        $this->replaceInFile($searchToReplace, $routesFilePath, $routesFilePath, self::$newAdminRoute, FILE_APPEND);
    }

    protected function createAuthRoutes(): int
    {
        $routesFile = file_get_contents(app_path() . '/../routes/web.php');

        if (!(Str::contains($routesFile, 'AdminAuth::routes'))) {
            file_put_contents(app_path() . "/../routes/web.php", self::$authRoutesDefinition, FILE_APPEND);

            return 1;
        }
        return 0;
    }

    protected function createRequest()
    {
        $pathFrom = __DIR__ . '/assets/expand/createRequest/NewRequest.php';
        $pathTo = app_path('Http/Requests/Admin/' . $this->argument('modelName') . 'Request.php');

        $fillable = $this->parseModel();
        $rules = [];
        foreach ($fillable as $field) {
            $rules[] = "            '$field' => ['string'],\n";
        }
        $rules = "return [\n" . implode('', $rules) . "          ];";

        $searchToReplace = [
            'NewRequest' => $this->argument('modelName') . 'Request',
            'return [];' => $rules
        ];

        $this->replaceInFile($searchToReplace, $pathFrom, $pathTo);
    }

    protected function replaceInFile($searchToReplace, $pathFrom, $pathTo, $str = '', $fileAppend = 0)
    {
        file_put_contents($pathTo,
            str_replace(array_keys($searchToReplace), array_values($searchToReplace), $str ? $str : file_get_contents($pathFrom) ),
            $fileAppend);
    }
}
