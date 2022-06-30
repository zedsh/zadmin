<?php


namespace zedsh\zadmin\Builder\Elements\Lists\Columns;

interface ActionsColumnInterface extends BaseColumnInterface
{
    public function setEditRoute($route): ActionsColumnInterface;

    public function setDeleteRoute($route): ActionsColumnInterface;

    public function setEditOn($state = true): ActionsColumnInterface;

    public function setDeleteOn($state = true): ActionsColumnInterface;

    public function setRouteParams($params): ActionsColumnInterface;

    public function setDeleteWithForm($state = true): ActionsColumnInterface;
}
