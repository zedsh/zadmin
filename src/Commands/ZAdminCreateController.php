<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;

class ZAdminCreateController extends Command
{
    public $signature = 'admin:create {modelName}';

    public $description = 'Command for copy AdminResourceController file into your project';

    public static $app_routes = array();


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->isModelExists()) {
            $this->createController();
        }

        $this->components->error("Model name did not recognized or model don't exist in your project");
    }

    protected function createController()
    {
        $pathFrom = __DIR__ . '/assets/expand/createController/NewController.php';
        $pathTo = app_path('Http/Controllers/Admin/' . $this->argument('modelName') . 'Controller.php');

        $fillable = $this->parseModel();

        $fillableAddEdit = [];
        foreach ($fillable as $field) {
            $fillableAddEdit[] = "new TextField('" . $field . "', '" . $field . "'),\n";
        }

        $list = "            (new TextColumn('id', '#'))->setWidth(50)";
        foreach ($fillable as $field) {
            if ($field === 'name') {
                $list = $list . "
            (new TextColumn('name', 'name')),\n";
            }
        }

        $search = [
            'resource_name',
            'NewController',
            'protected $modelClass = null;',
            'use App\Http\Requests\Admin\TagStoreUpdateRequest;',
            'protected $request = null;',
            "new TextField('name', 'name'),",
            "(new TextColumn('id', '#'))->setWidth(50)"
        ];

        $replace = [
            strtolower($this->argument('modelName')),
            $this->argument('modelName') . 'Controller',
            'protected $modelClass = ' . $this->argument('modelName') . '::class' . ';',
            'use App\Http\Requests\Admin\\' . $this->argument('modelName') . 'StoreUpdateRequest;',
            'protected $request = ' . $this->argument('modelName') . 'StoreUpdateRequest::class;',
            implode('', $fillableAddEdit),
            $list
        ];

        $this->replaceInFile($search, $replace, $pathFrom, $pathTo);
        $this->createResourceRoute();
        $this->createRequest();
    }


    protected function isModelExists() {
        $modelsInDirectory = scandir(app_path() . '/Models');
        foreach ($modelsInDirectory as $modelName) {
            if (mb_strpos($modelName, $this->argument('modelName')) !== false && $modelName === $this->argument('modelName').'.php') {
                return true;
            }
        }

        return false;
    }

    protected function parseModel() {
        $parsedModel = file_get_contents(app_path() . '/Models/' . $this->argument('modelName') . '.php');
        $startFillable = strpos($parsedModel,'protected $fillable = [') + 23;
        $endFillable = strpos($parsedModel,'];');
        $fillable = mb_substr($parsedModel,$startFillable, ($endFillable-$startFillable));
        $fillable = ltrim($fillable);
        $fillable = rtrim($fillable);
        $fillable = str_replace(["\n","'"," "], ["","",""], $fillable);
        $fillable = explode(',', $fillable);

        return $fillable;
    }

    protected function createResourceRoute() {
        $routesFile = file_get_contents(app_path() . '/../routes/web.php');
        $newRoute = "       Route::resource('". strtolower($this->argument('modelName')) ."', ". $this->argument('modelName') . "Controller::class);\n";
        $updatedRoutesFile = substr($routesFile, 0, (strpos($routesFile,"->name('admin');")+18)) .
            $newRoute .
            substr($routesFile,(strpos($routesFile,"->name('admin');")+18)) ;
        file_put_contents(app_path() . '/../routes/web.php',$updatedRoutesFile);
    }

    protected function createRequest()
    {
        $data = file_get_contents(__DIR__ . '/assets/expand/createRequest/NewRequest.php');
        $data = str_replace([
            'NewRequest',
        ],
            [
                $this->argument('modelName') . 'Request',
            ], $data);
        $fillableAttributes = $this->parseModel();
        $rules = [];
        foreach ($fillableAttributes as $attribute) {
            $rules[] = "            '$attribute' => ['string'],\n";
        }
        $rules = "return [\n" . implode('',$rules) . "          ];";
        $data = str_replace('return [];', $rules, $data);
        file_put_contents(app_path('Http/Requests/Admin/'.$this->argument('modelName').'Request.php'),$data);
    }

    protected function replaceInFile($search, $replace, $pathFrom, $pathTo)
    {
        file_put_contents($pathTo, str_replace($search, $replace, file_get_contents($pathFrom)));
    }
}
