<?php


namespace zedsh\zadmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use zedsh\zadmin\Templates\BaseTemplate;

class BaseAdminController extends BaseController
{
    protected $template;

    protected function getTemplate()
    {
        return (new BaseTemplate());
    }
}
