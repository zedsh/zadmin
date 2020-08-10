<?php


namespace zedsh\zadmin\Lists;


class BaseList
{
    protected $name;
    protected $title;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function render()
    {
        return '';
    }

}
