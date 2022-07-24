<?php

namespace zedsh\zadmin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\User;
use zedsh\zadmin\Builder\Builders\AdminBuilder;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
use zedsh\zadmin\Fields\HiddenField;
use zedsh\zadmin\Forms\BaseForm;
use zedsh\zadmin\Lists\Columns\ActionsColumn;
use zedsh\zadmin\Lists\TableList;
use zedsh\zadmin\Templates\BaseTemplate;
use function app;
use function back;
use function response;
use function route;

class BaseAdminResourceController extends Controller
{
    protected $modelClass = null;
    protected $request = null;
    protected $resourceName = 'resource_name';
    protected $indexTitle = 'title';
    protected $editTitle = 'title';
    protected $itemsOnPage = 10;
    protected $listClass = TableList::class;
    protected $formClass = BaseForm::class;

    protected function getRoutes($model)
    {
        return [
            'destroy' => route($this->resourceName . '.index'),
            'update' => route($this->resourceName . '.index'),
            'store' => route($this->resourceName . '.index'),
            'editBack' => route($this->resourceName . '.index'),
            'createBack' => route($this->resourceName . '.index')
        ];
    }


    protected function list()
    {
//        $this->formBuilder->addColumnText('id', '#')
//            ->setWidth(50);
//        $this->formBuilder->addColumnText('name', 'Имя');
//        $this->formBuilder->addColumnText('email', 'Email');

    }

    protected function addEdit($model)
    {
        //$this->formBuilder->addFieldHidden('id', '')->setValue($id);
//        $this->formBuilder->addFieldText('name', 'Имя');
//        $this->formBuilder->addFieldText('email', 'Email');
//        $this->formBuilder->addFieldPassword('password', 'Пароль');
//        $this->formBuilder->addFieldPassword('password_confirmation', 'Подтвердите пароль');
    }

    protected function actions()
    {
        return (new ActionsColumn())
            ->setEditRoute($this->resourceName . '.edit')
            ->setDeleteRoute($this->resourceName . '.destroy')
            ->setDeleteOn()
            ->setDeleteWithForm()
            ->setEditOn()
            ->setRouteParams([
                $this->resourceName => function ($model) {
                    return $model->id;
                }
            ]);
    }

    protected function beforeSave($request, $model)
    {
//        if ($request->has('password')) {
//            $model->password = Hash::make($request->input('password'));
//        }
    }

    protected function render($renderable)
    {
        return BaseTemplate::renderView($renderable);
    }

    protected function getListQuery()
    {
        $modelClass = $this->modelClass;
        return $modelClass::query();
    }


    public function index()
    {
        $actionColumn = $this->actions();

        $otherColumns = $this->list();

        $list = new $this->listClass($this->resourceName . 'List');

        $list
            ->setTitle($this->indexTitle)
            ->setColumns([$actionColumn, ...$otherColumns])
            ->enableAdd()
            ->setAddPath(route($this->resourceName . '.create'))
            ->setQuery($this->getListQuery())
            ->enablePaginate()
            ->setItemsOnPage($this->itemsOnPage);

        return $this->render($list);
    }


    public function create()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;

        $form = new $this->formClass($this->resourceName . 'Form');

        $form
            ->setTitle($this->editTitle)
            ->setAction(route($this->resourceName . '.store'))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack($this->getRoutes($model)['createBack'])
            ->setModel($model)
            ->setFields($this->addEdit($model));

        return $this->render($form);
    }


    public function store()
    {
        $request = app($this->request);
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        $model->fill($request->validated());
        $this->beforeSave($request, $model);
        if (method_exists($model, 'addFiles')) {
            $model->addFiles($request->validated());
        }
        $model->save();
        if (method_exists($model, 'addRelations')) {
            $model->addRelations($request->validated());
        }
        return response()->redirectTo($this->getRoutes($model)['store']);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);

        $form = new $this->formClass($this->resourceName . 'Form');

        $form
            ->setTitle($this->editTitle)
            ->setAction(route($this->resourceName . '.update',[$this->resourceName => $id]))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack($this->getRoutes($model)['editBack'])
            ->setModel($model)
            ->setFields(
                array_merge($this->addEdit($model), [
                    (new HiddenField('id', ''))->setValue($id),
                    (new HiddenField('_method', ''))->setValue('PUT'),
                ]));

        return $this->render($form);
    }


    public function update($id)
    {
        $request = app($this->request);
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);
        $model->fill($request->validated());
        $this->beforeSave($request, $model);

        if (method_exists($model, 'addFiles')) {
            $model->addFiles($request->validated());
        }
        $model->save();
        if (method_exists($model, 'addRelations')) {
            $model->addRelations($request->validated());
        }
        return response()->redirectTo($this->getRoutes($model)['update']);
    }


    public function destroy($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);
        $model->delete();
        $backRoute = $this->getRoutes($model)['update'] ?? null;
        return ($backRoute ? response()->redirectTo($backRoute) : back());
    }


}
