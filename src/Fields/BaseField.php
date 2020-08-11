<?php


namespace zedsh\zadmin\Fields;

use Illuminate\Support\Facades\Request;

class BaseField
{
    protected $template = '';
    protected $name = '';
    protected $title = '';
    protected $model;
    protected $value;

    public function __construct($name, $title = '')
    {
        $this->name = $name;
        $this->title = $title;
    }


    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        $oldValue = Request::old($this->name);

        return ($oldValue !== null ? $oldValue : ($this->value ?? $this->model->{$this->name}));
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function render()
    {
        return view($this->template, ['field' => $this])->render();
    }
}
