<?php


namespace zedsh\zadmin\Builder\Elements\Lists\Columns;

interface CustomColumnInterface extends BaseColumnInterface
{
    public function setRender($function): CustomColumnInterface;
}
