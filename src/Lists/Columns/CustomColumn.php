<?php


namespace zedsh\zadmin\Lists\Columns;

class CustomColumn extends BaseColumn
{
    protected $renderFunction;


    public function setRender($function)
    {
        $this->renderFunction = $function;
    }

    public function render()
    {
        $function = $this->renderFunction;

        return $function($this->model);
    }
}
