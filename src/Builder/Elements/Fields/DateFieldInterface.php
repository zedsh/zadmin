<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface DateFieldInterface extends BaseFieldInterface
{
    public function setDateFormat($format) : DateFieldInterface;
}
