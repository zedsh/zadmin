<?php

namespace zedsh\zadmin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\User;
use zedsh\zadmin\Builder\Builders\AdminBuilder;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
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
    /** @var AdminBuilder $formBuilder */
    protected $formBuilder;

    public function __construct(BuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
        $this->setMenu();
        $this->formBuilder->setMenu()
            ->setItems($this->formBuilder->getMenuItems());

    }

    protected function setMenu()
    {
//        $this->formBuilder->addMenuItem('title', 'route')
//            ->setActiveWith('route');

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

    protected function beforeSave($request, $model)
    {
//        if ($request->has('password')) {
//            $model->password = Hash::make($request->input('password'));
//        }
    }

    protected function getListQuery()
    {
        $modelClass = $this->modelClass;
        return $modelClass::query();
    }


    public function index()
    {
        $this->formBuilder->addColumnActions()
            ->setEditRoute($this->resourceName . '.edit')
            ->setDeleteRoute($this->resourceName . '.destroy')
            ->setDeleteOn()
            ->setEditOn()
            ->setRouteParams([
                $this->resourceName => function ($model) {
                    return $model->id;
                }
            ]);

        $this->list();

        $this->formBuilder->setList($this->resourceName . 'List')
            ->setTitle($this->indexTitle)
            ->setColumns($this->formBuilder->getColumns())
            ->enableAdd()
            ->setAddPath(route($this->resourceName . '.create'))
            ->setQuery($this->getListQuery())
            ->enablePaginate()
            ->setItemsOnPage($this->itemsOnPage);

        return $this->formBuilder->render();
    }


    public function create()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        $this->addEdit(true);

        $this->formBuilder->setForm('main')
            ->setTitle($this->editTitle)
            ->setAction(route($this->resourceName . '.store'))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack(route($this->resourceName . '.index'))
            ->setModel($model)
            ->setFields($this->formBuilder->getFields());

        return $this->formBuilder->render();
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
        return response()->redirectToRoute($this->resourceName . '.index');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);
        $this->formBuilder->addFieldHidden('id', '')->setValue($id);
        $this->formBuilder->addFieldHidden('_method', '')->setValue('PUT');

        $this->addEdit($model);

        $this->formBuilder->setForm('main')
            ->setTitle($this->editTitle)
            ->setAction(route($this->resourceName . '.update', [$this->resourceName => $id]))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack(route($this->resourceName . '.index'))
            ->setModel($model)
            ->setFields($this->formBuilder->getFields());

        return $this->formBuilder->render();
    }


    public function update($id)
    {
        $request = app($this->request);
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($request->input('id'));
        $model->fill($request->validated());
        $this->beforeSave($request, $model);

        if (method_exists($model, 'addFiles')) {
            $model->addFiles($request->validated());
        }
        $model->save();
        if (method_exists($model, 'addRelations')) {
            $model->addRelations($request->validated());
        }
        return response()->redirectToRoute($this->resourceName . '.index');
    }


    public function destroy($id)
    {
        $modelClass = $this->modelClass;
        $modelClass::query()->findOrFail($id)->delete();
        return back();
    }
}
