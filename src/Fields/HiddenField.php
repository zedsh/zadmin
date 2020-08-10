<?php


namespace Zedsh\ZAdmin\Fields;


class HiddenField extends BaseField
{
    protected $value;

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function render()
    {
        $name = $this->getName();
        $value = $this->getValue();
        return "<input type='hidden' name='$name' value='$value'>";
    }


}
