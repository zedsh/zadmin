<?php

namespace zedsh\zadmin\Builder\Elements\Form;

interface BaseFormInterface
{
    public function setTitle($value) : BaseFormInterface;
    public function setAction($value) : BaseFormInterface;
    public function setEncType($value) : BaseFormInterface;
    public function setMethod($value) : BaseFormInterface;
    public function setBack($value) : BaseFormInterface;
    public function setModel($value) : BaseFormInterface;
    public function setFields($value) : BaseFormInterface;
}
