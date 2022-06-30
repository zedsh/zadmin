<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserResourceController extends AdminResourceController
{
    protected $modelClass = User::class;
    protected $request = UserRequest::class;
    protected $resourceName = 'user';
    protected $indexTitle = 'Список пользователей';
    protected $editTitle = 'Добавить пользователя';

    protected function beforeSave($request, $model)
    {
        if($request->has('password')) {
            $model->password = Hash::make($request->input('password'));
        }
    }

    protected function list()
    {
        $this->formBuilder->addColumnText('id', '#')
            ->setWidth(50);
        $this->formBuilder->addColumnText('name', 'Имя');
        $this->formBuilder->addColumnText('email', 'Email');

    }

    protected function addEdit($model)
    {
        $this->formBuilder->addFieldText('name', 'Имя');
        $this->formBuilder->addFieldText('email', 'Email');
        $this->formBuilder->addFieldPassword('password', 'Пароль');
        $this->formBuilder->addFieldPassword('password_confirmation', 'Подтвердите пароль');
    }


}
