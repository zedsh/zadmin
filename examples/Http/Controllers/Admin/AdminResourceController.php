<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Templates\ProjectTemplate;
use zedsh\zadmin\Http\Controllers\BaseAdminResourceController;

class AdminResourceController extends BaseAdminResourceController
{
    protected function render($renderable)
    {
        return ProjectTemplate::renderView($renderable);
    }
}
