<?php


namespace zedsh\zadmin\Lists\Columns;


class ActionsColumn extends BaseColumn
{
    protected $template = 'zadmin::lists.columns.actions';
    protected $editRoute;
    protected $deleteRoute;
    protected $routeParams = [];
    protected $editOn = false;
    protected $deleteOn = false;
    protected $width = 100;

    public function __construct($name = 'actionsColumn', $title = 'Действия')
    {
        parent::__construct($name, $title);
    }

    public function setEditRoute($route)
    {
        $this->editRoute = $route;
        return $this;
    }

    public function setDeleteRoute($route)
    {
        $this->deleteRoute = $route;
        return $this;
    }

    public function setEditOn($state = true)
    {
        $this->editOn = $state;
        return $this;
    }

    public function getEditOn()
    {
        return $this->editOn;
    }

    public function getDeleteOn()
    {
        return $this->deleteOn;
    }

    public function setDeleteOn($state = true)
    {
        $this->deleteOn = true;
        return $this;
    }

    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    protected function getRouteParamsValues()
    {
        $params = [];

        foreach($this->routeParams as $key => $param){
            $key = (is_string($key) ? $key : $param);

            if(is_callable($param)) {
                $params[$key] = $param($this->model);
                continue;
            }

            if(!empty($this->model->{$param})) {
                $params[$key] = $this->model->{$param};
            }
        }

        return $params;
    }

    public function getEditUrl()
    {
        return route($this->editRoute,$this->getRouteParamsValues());
    }

    public function getDeleteUrl()
    {
        return route($this->deleteRoute,$this->getRouteParamsValues());
    }

    public function render()
    {
        return view($this->template,['column' => $this])->render();
    }


}
