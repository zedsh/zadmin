<?php


namespace zedsh\zadmin\Lists\Columns;

abstract class BaseColumn
{
    protected $name;
    protected $title;
    protected $model;
    protected $width = 0;
    protected $sortCall = null;

    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getName()
    {
        return $this->name;
    }


    public function setWidth($value)
    {
        $this->width = $value;

        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }


    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function render()
    {
        return $this->model->{$this->name};
    }

    public function setSort($sortCall)
    {
        $this->sortCall = $sortCall;
    }

    public function getSortCall()
    {
       return $this->sortCall; 
    }
}
