<?php


namespace Zedsh\ZAdmin\Fields;


class TextField extends BaseField
{
    protected $template = 'ZAdmin::fields.text';
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
