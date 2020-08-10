<?php


namespace zedsh\zadmin\Fields;


class TextField extends BaseField
{
    protected $template = 'zadmin::fields.text';
    protected $slugFrom;

    public function setSlugFrom($name)
    {
        $this->slugFrom = $name;
        return $this;
    }

    public function getSlugFrom()
    {
        return $this->slugFrom;
    }



}
