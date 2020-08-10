<?php


namespace Zedsh\ZAdmin\Menu;


use Illuminate\Support\Str;

class BaseMenuItem
{
    protected $template = 'ZAdmin::menu.menuItem';
    protected $title;
    protected $link;
    protected $route;
    protected $activeWith;
    protected $inactiveWith;
    protected $addRoute;

    public function __construct($title, $route = '')
    {
        $this->title = $title;
        $this->route = $route;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        if(!empty($this->link)) {
            return $this->link;
        }

        if(!empty($this->route)) {
            return route($this->route);
        }

        return '';
    }

    public function getAddLink()
    {
        if(!empty($this->addRoute)) {
            return route($this->addRoute);
        }

        return '';
    }

    public function setActiveWith($name)
    {
        $this->activeWith = $name;
        return $this;
    }

    public function setInactiveWith($name)
    {
        $this->inactiveWith = $name;
        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function setAddRoute($route)
    {
        $this->addRoute = $route;
        return $this;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getIsActive()
    {
        $route = request()->route()->getName();
        $active = Str::startsWith($route, $this->activeWith);
        if(!empty($this->inactiveWith)) {
            if(Str::startsWith($route,$this->inactiveWith)){
                $active = false;
            }
        }

        return $active;
    }

    public function render()
    {
        return view($this->template,['item' => $this])->render();
    }

}
