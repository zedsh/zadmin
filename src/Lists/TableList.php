<?php


namespace Zedsh\ZAdmin\Lists;


use Zedsh\ZAdmin\Filters\BaseFilter;

class TableList extends BaseList
{
    protected $template = 'ZAdmin::lists.table';
    protected $itemsOnPage = 20;
    protected $paginate = false;
    protected $add = false;
    protected $addPath = '';
    protected $columns = [];
    protected $filters = [];
    protected $query;

    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFiltersRenderedContent()
    {
        $ret = '';
        foreach ($this->filters as $filter) {
            $ret .= $filter->render();
        }

        return $ret;
    }

    public function setItemsOnPage($itemsOnPage)
    {
        $this->itemsOnPage = $itemsOnPage;
        return $this;
    }

    public function enablePaginate($state = true)
    {
        $this->paginate = $state;
        return $this;
    }

    public function getPaginate()
    {
        return $this->paginate;
    }

    public function enableAdd($state = true)
    {
        $this->add = $state;
        return $this;
    }

    public function getAdd()
    {
        return $this->add;
    }

    public function setAddPath($link)
    {
        $this->addPath = $link;
        return $this;
    }

    public function getAddPath()
    {
        return $this->addPath;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function items()
    {
        foreach ($this->filters as $filter) {
            /**
             * @var BaseFilter $filter
             */
            $filter->execute($this->query);
        }

        if ($this->paginate) {
            return $this->query->paginate($this->itemsOnPage);
        } else {
            return $this->query->get();
        }
    }

    public function render()
    {
        return view($this->template, ['table' => $this])->render();
    }


}
