<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface BaseFieldInterface
{
    public function setModel($value) : BaseFieldInterface;

    public function setValue($value) : BaseFieldInterface;
}
