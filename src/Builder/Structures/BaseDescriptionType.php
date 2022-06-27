<?php


namespace zedsh\zadmin\Builder\Structures;


abstract class BaseDescriptionType extends BaseDescription
{
    /** @var string $type */
    protected $type;

    /**
     * DescriptionWithType constructor.
     * @param string $type
     * @param array $constructorParameters
     */
    public function __construct(string $type, array $constructorParameters)
    {
        parent::__construct($constructorParameters);
        $this->type = $type;
    }

    public function getType() : string
    {
        return $this->type;
    }
}
