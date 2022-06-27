<?php


namespace zedsh\zadmin\Builder\Elements\Lists\Columns;

interface RawColumnInterface extends BaseColumnInterface
{
    public function setContent($content): RawColumnInterface;

    public function setClosure($closure): RawColumnInterface;
}
