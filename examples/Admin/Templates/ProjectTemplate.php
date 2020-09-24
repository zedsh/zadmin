<?php


namespace App\Admin\Templates;


use App\Admin\Menu\BaseMenu;
use App\Admin\Menu\BaseMenuItem;

class ProjectTemplate extends BaseTemplate
{
    public function getMenu()
    {
        return new BaseMenu(
            [
                (new BaseMenuItem('Артисты', 'artist.list'))->setActiveWith('artist')->setInactiveWith('artist.type'),
            ]
        );
    }

}
