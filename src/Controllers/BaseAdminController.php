<?php


namespace zedsh\zadmin\Controllers;

use zedsh\zadmin\Templates\BaseTemplate;
use Illuminate\Routing\Controller as BaseController;


class BaseAdminController extends BaseController
{
    protected $template;

    protected function getTemplate()
    {
        return (new BaseTemplate());
    }

}
