<?php


namespace zedsh\zadmin\Fields;

class TextAreaField extends BaseField
{
    protected $maxLength = null;
    protected $template = 'zadmin::fields.textArea';

    public function getMaxLength()
    {
        return $this->maxLength;
    }

    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }
}
