<?php


namespace zedsh\zadmin\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SelectField extends BaseField
{
    protected $template = 'zadmin::fields.select';
    protected $collection;
    protected $id = 'id';
    protected $showField = 'name';
    protected $multiple = false;
    protected $nullable = false;
    protected $relatedKey = 'id';

    public function setRelatedKey($key)
    {
        $this->relatedKey = $key;

        return $this;
    }

    public function setMultiple($value = true)
    {
        $this->multiple = $value;

        return $this;
    }

    public function setNullable($value = true)
    {
        $this->nullable = $value;

        return $this;
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setShowField($fieldName)
    {
        $this->showField = $fieldName;

        return $this;
    }

    public function getRelatedKey()
    {
        return $this->relatedKey;
    }

    public function getShowField()
    {
        return $this->showField;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function getNullable()
    {
        return $this->nullable;
    }

    public function getFormName()
    {
        $name = $this->getName();
        if ($this->multiple) {
            $name = $name . '[]';
        }

        return $name;
    }

    public function isSelected($id)
    {
        if ($this->multiple) {
            $value = $this->getValue();
            if ($value instanceof Collection) {
                return ($value->pluck($this->getRelatedKey())->contains($id));
            }

            if (is_array($value)) {
                return (in_array($id, $value));
            }

            return false;
        } else {
            $value = $this->getValue();
            if ($value instanceof Model) {
                return ($value->{$this->getRelatedKey()} === $id);
            } else {
                return ($value === $id);
            }
        }
    }
}
