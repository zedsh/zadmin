<?php


namespace zedsh\zadmin\Fields;

use zedsh\zadmin\Base\File;

class FileField extends BaseField
{
    protected $multiple = false;
    protected $template = 'zadmin::fields.file';
    protected $removeRoute;


    public function setRemoveRoute($route)
    {
        $this->removeRoute = $route;

        return $this;
    }

    public function setMultiple($value = true)
    {
        $this->multiple = $value;

        return $this;
    }

    public function getFormName()
    {
        $name = $this->getName();
        if ($this->multiple) {
            $name = $name . '[]';
        }

        return $name;
    }

    public function getAttributeFormName($id, $attribute)
    {
        $name = $this->getName();
        return $name . '_attributes[' . $id . '][' . $attribute . ']';
    }

    public function getRemoveRoute()
    {
        return $this->removeRoute;
    }

    public function getRemovePath(File $file)
    {
        return route($this->removeRoute, ['modelId' => $this->model->id, 'field' => $this->name, 'id' => $file->getId()]);
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function getDetailValue()
    {
        $value = $this->model->{$this->name};
        if (empty($value)) {
            return [];
        }


        $ret = [];
        foreach ($value as $item) {
            $ret[] = new File($item['id'], $item['path'], $item['name'], $item['title'] ?? '', $item['alt'] ?? '');
        }

        return $ret;
    }
}
