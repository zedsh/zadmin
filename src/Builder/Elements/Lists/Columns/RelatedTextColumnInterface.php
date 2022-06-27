<?php


namespace zedsh\zadmin\Builder\Elements\Lists\Columns;

interface RelatedTextColumnInterface extends BaseColumnInterface
{
    public function setRelation($relation): RelatedTextColumnInterface;
}
