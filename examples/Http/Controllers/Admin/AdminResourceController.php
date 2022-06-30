<?php

namespace App\Http\Controllers\Admin;

use zedsh\zadmin\Http\Controllers\BaseAdminResourceController;

class AdminResourceController extends BaseAdminResourceController
{
    protected function setMenu()
    {
        $this->formBuilder->addMenuItem('Пользователи', 'user.index')
            ->setActiveWith('user');
    }
}
