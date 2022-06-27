<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    public function delete($id)
    {
        User::query()->findOrFail($id)->delete();
        return response()->redirectToRoute('user.list');
    }

    public function save(UserRequest $request)
    {
        if (!empty($request->input('id'))) {
            $model = User::query()->findOrFail($request->input('id'));
        } else {
            $model = new User();
        }

        $model->fill($request->validated());
        if($request->has('password')) {
            $model->password = Hash::make($request->input('password'));
        }
        $model->save();
        return response()->redirectToRoute('user.list');
    }

    public function edit($id)
    {
        $model = User::query()->findOrFail($id);

        $this->formBuilder->addFieldHidden('id', '')->setValue($id);
        $this->formBuilder->addFieldText('name', 'Имя');
        $this->formBuilder->addFieldText('email', 'Email');
        $this->formBuilder->addFieldPassword('password', 'Пароль');
        $this->formBuilder->addFieldPassword('password_confirmation', 'Подтвердите пароль');

        $this->formBuilder->setForm('main')
            ->setTitle('Пользователь')
            ->setAction(route('user.save', ['id' => $id]))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack(route('user.list'))
            ->setModel($model)
            ->setFields($this->formBuilder->getFields());

        return $this->formBuilder->render();
    }

    public function add()
    {
        $model = new User();
        $this->formBuilder->addFieldText('name', 'Имя');
        $this->formBuilder->addFieldText('email', 'Email');
        $this->formBuilder->addFieldPassword('password', 'Пароль');
        $this->formBuilder->addFieldPassword('password_confirmation', 'Подтвердите пароль');

        $this->formBuilder->setForm('main')
            ->setModel($model)
            ->setTitle('Пользователь')
            ->setBack(route('user.list'))
            ->setAction(route('user.save'))
            ->setFields($this->formBuilder->getFields());


        return $this->formBuilder->render();
    }

    public function list()
    {
        $this->formBuilder->addColumnActions()
            ->setEditRoute('user.edit')
            ->setDeleteRoute('user.delete')
            ->setDeleteOn()
            ->setEditOn()
            ->setRouteParams(['id']);
        $this->formBuilder->addColumnText('id', '#')
            ->setWidth(50);
        $this->formBuilder->addColumnText('name', 'Имя');
        $this->formBuilder->addColumnText('email', 'Email');

        $this->formBuilder->setList('UserList')
            ->setTitle('Список пользователей')
            ->setColumns($this->formBuilder->getColumns())
            ->enableAdd()
            ->setAddPath(route('user.add'))
            ->setQuery(User::query())
            ->enablePaginate()
            ->setItemsOnPage(10);

        return $this->formBuilder->render();
    }
}
