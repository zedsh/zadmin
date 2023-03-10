<?php

namespace App\Admin\Templates;

use zedsh\zadmin\Menu\BaseMenu;
use zedsh\zadmin\Menu\BaseMenuItem;
use zedsh\zadmin\Templates\BaseTemplate;

class ProjectTemplate extends BaseTemplate
{
    public function getMenu()
    {
        return new BaseMenu(
            [
                #Пример реализации:
                #(new BaseMenuItem('Артисты', 'artist.list'))->setActiveWith('artist')->setInactiveWith('artist.type'),
            ]
        );
    }

}
