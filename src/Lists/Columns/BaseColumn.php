<?php


namespace Zedsh\ZAdmin\Lists\Columns;


abstract class BaseColumn
{
    protected $name;
    protected $title;
    protected $model;
    protected $width = 0;

    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
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


}
