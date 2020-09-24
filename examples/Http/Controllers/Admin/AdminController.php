<?php


namespace App\Http\Controllers\Admin;


use App\Admin\Templates\ProjectTemplate;
use zedsh\zadmin\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{
    protected function render($renderable)
    {
        return ProjectTemplate::renderView($renderable);
    }

}
