<?php


namespace Zedsh\ZAdmin\Controllers;

use Zedsh\ZAdmin\Templates\BaseTemplate;
use Illuminate\Routing\Controller as BaseController;


class BaseAdminController extends BaseController
{
    protected $template;

    protected function getTemplate()
    {
        return (new BaseTemplate());
    }

}
