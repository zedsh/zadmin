<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface SelectFieldInterface extends BaseFieldInterface
{
    public function setRelatedKey($key) : SelectFieldInterface;

    public function setMultiple($value = true) : SelectFieldInterface;

    public function setNullable($value = true) : SelectFieldInterface;

    public function setCollection($collection) : SelectFieldInterface;

    public function setId($id) : SelectFieldInterface;

    public function setShowField($fieldName) : SelectFieldInterface;
}
