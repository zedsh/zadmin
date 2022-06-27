<?php


namespace zedsh\zadmin\Builder\Elements\Menu;


interface BaseMenuItemInterface
{
    public function setActiveWith($name): BaseMenuItemInterface;

    public function setInactiveWith($name): BaseMenuItemInterface;

    public function setRoute($route): BaseMenuItemInterface;

    public function setAddRoute($route): BaseMenuItemInterface;

    public function setLink($link): BaseMenuItemInterface;

    public function setBadge($badge): BaseMenuItemInterface;

}
