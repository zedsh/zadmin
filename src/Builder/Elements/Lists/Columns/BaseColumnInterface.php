<?php


namespace zedsh\zadmin\Builder\Elements\Lists\Columns;

interface BaseColumnInterface
{
    public function setWidth($value): BaseColumnInterface;

    public function setModel($model): BaseColumnInterface;

    public function render(): string;
}
