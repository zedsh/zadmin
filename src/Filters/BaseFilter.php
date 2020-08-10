<?php


namespace Zedsh\ZAdmin\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class BaseFilter
{
    const FILTER_VAR = 'filter';
    protected $template = 'ZAdmin::filters.base';
    protected $title;
    protected $field;

    public function __construct($title, $field)
    {
        $this->title = $title;
        $this->field = $field;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getFullFieldNameHTML()
    {
        return static::FILTER_VAR . "[$this->field]";
    }

    public function getFilterValue()
    {
        $fullFieldName = static::FILTER_VAR . ".$this->field";

        if(! Request::has($fullFieldName)) {
            return null;
        }

        return Request::input($fullFieldName);
    }

    public function execute(Builder $query)
    {
        $value = $this->getFilterValue();
        if($value !== null) {
           $this->filter($query, $value);
        }
    }

    public function render()
    {
        return view($this->template, ['filter' => $this])->render();
    }

    protected function filter($query, $value)
    {
        $query->where($this->field, 'like', $value);
    }

}
