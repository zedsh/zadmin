<?php

namespace zedsh\zadmin\Builder\Elements\Fields;

interface TextFieldInterface extends BaseFieldInterface
{
    public function setSlugFrom($name) : TextFieldInterface;
}
