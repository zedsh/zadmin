<?php


namespace zedsh\zadmin\Lists\Columns;


class RelatedTextColumn extends BaseColumn
{
    protected $relation;

    public function setRelation($relation)
    {
        $this->relation = $relation;
        return $this;
    }

    public function render()
    {
        return $this->model->{$this->relation}->{$this->name};
    }

}
