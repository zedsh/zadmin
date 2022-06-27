<?php


namespace zedsh\zadmin\Builder\Elements\Lists;

interface TableListInterface
{
    public function setTitle($title): TableListInterface;

    public function setColumns($columns): TableListInterface;

    public function setFilters($filters): TableListInterface;

    public function setItemsOnPage($itemsOnPage): TableListInterface;

    public function enablePaginate($state = true): TableListInterface;

    public function enableAdd($state = true): TableListInterface;

    public function setAddPath($link): TableListInterface;

    public function setQuery($query): TableListInterface;

    public function render(): string;
}
