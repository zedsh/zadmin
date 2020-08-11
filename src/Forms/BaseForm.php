<?php


namespace zedsh\zadmin\Forms;

use zedsh\zadmin\Fields\BaseField;

/**
 * Class BaseForm
 * @package zedsh\zadmin\Forms
 * @property BaseField[] $fields
 */
class BaseForm
{
    protected $name;
    protected $model;
    protected $title;
    protected $action = '';
    protected $back = '';
    protected $template = 'zadmin::forms.base';
    protected $fields = [];
    protected $encType = 'multipart/form-data';
    protected $method = 'POST';

    public function __construct($name, $fields = [])
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }


    public function setAction($link)
    {
        $this->action = $link;

        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setEncType($encType)
    {
        $this->encType = $encType;
    }

    public function getEncType()
    {
        return $this->encType;
    }

    public function setBack($back)
    {
        $this->back = $back;
    }

    public function getBack()
    {
        if (empty($this->back)) {
            return url()->previous();
        }

        return $this->back;
    }

    public function getAction()
    {
        return $this->action;
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

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }


    public function render()
    {
        $content = '';

        foreach ($this->fields as $field) {
            $content .= $field->setModel($this->model)->render();
        }

        return view($this->template, ['content' => $content, 'form' => $this]);
    }
}
