<?php


namespace App\Http\Controllers\Admin;


use App\Admin\Templates\ProjectTemplate;
use App\Models\ReviewAnswer;
use zedsh\zadmin\Builder\Builders\AdminBuilder;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
use zedsh\zadmin\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{
    /** @var AdminBuilder $formBuilder */
    protected  $formBuilder;

    public function __construct(BuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
        $this->formBuilder->addMenuItem('Пользователи', 'user.list')
            ->setActiveWith('user');

        $this->formBuilder->setMenu()
            ->setItems($this->formBuilder->getMenuItems());
    }

    protected function render($renderable)
    {
        return ProjectTemplate::renderView($renderable);
    }

    protected function defaultRedirect()
    {
        return redirect(route('user.list'));
    }

}
