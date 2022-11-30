<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Partner;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use zedsh\zadmin\Fields\BooleanField;
use zedsh\zadmin\Fields\PasswordField;
use zedsh\zadmin\Fields\SelectField;
use zedsh\zadmin\Fields\TextField;
use zedsh\zadmin\Lists\Columns\TextColumn;

class UserController extends AdminResourceController
{
    protected $modelClass = User::class;
    protected $request = UserRequest::class;
    protected $resourceName = 'user';
    protected $indexTitle = 'Список пользователей';
    protected $editTitle = 'Добавить пользователя';

    protected function beforeSave($request, $model)
    {
        if($request->has('password') && !empty($request->input('password'))) {
            $model->password = Hash::make($request->input('password'));
        }
    }

    protected function list()
    {
        return [
            (new TextColumn('id','#'))->setWidth(50),
            (new TextColumn('name','Имя')),
            (new TextColumn('email','Email')),
        ];
    }

    protected function addEdit($model)
    {
        return [
            (new TextField('login', 'Логин')),
            (new TextField('name','Имя')),
            (new TextField('surname','Фамилия')),
            (new TextField('patronymic','Отчество')),
            (new TextField('email', 'Email')),
            (new TextField('phone', 'Телефон')),
            (new TextField('company', 'Компания')),
            (new TextField('inn', 'Инн')),
            (new SelectField('role_id', 'Роль'))->setCollection(Role::all())->setShowField('name'),
            (new SelectField('partner_id', 'Партнёр'))->setCollection(Partner::all())->setNullable()->setShowField('name'),
            (new BooleanField('mailing','Участвует в рассылке')),
            (new BooleanField('mail_validated','Email подтвержден')),
            (new BooleanField('phone_validated','Телефон подтвержден')),
            (new PasswordField('password', 'Пароль')),
            (new PasswordField('password_confirmation', 'Подтвердите пароль')),
            (new TextField('email_notification', 'Email для уведомлений')),
            (new BooleanField('notification_basic','Уведомления: базовые')),
            (new BooleanField('notification_rules_change','Уведомления: о изменении правил')),
            (new BooleanField('notification_news','Уведомления: новости')),

        ];
    }


}
