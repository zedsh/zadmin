<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface FileFieldInterface extends BaseFieldInterface
{

    public function setRemoveRoute($route) : FileFieldInterface;

    public function setMultiple($value = true) : FileFieldInterface;
}
