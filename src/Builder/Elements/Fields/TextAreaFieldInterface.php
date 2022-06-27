<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface TextAreaFieldInterface extends BaseFieldInterface
{
    public function setMaxLength($maxLength) : TextAreaFieldInterface;
}
