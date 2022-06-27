<?php


namespace zedsh\zadmin\Builder\Structures;


use zedsh\zadmin\Builder\Exceptions\MethodNotAllowedException;
use zedsh\zadmin\Builder\Traits\MagicMethod;

abstract class BaseDescription
{
    use MagicMethod;

    public const ARGUMENT_DEFAULT = 'ARGUMENT_DEFAULT';

    protected $constructorParameters = [];
    protected $otherData = [];

    /**
     * @param array $constructorParameters
     */
    public function __construct(array $constructorParameters)
    {
        $this->constructorParameters = $constructorParameters;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this|DescriptionColumn|mixed|null
     * @throws MethodNotAllowedException
     */
    public function __call(string $name, array $arguments)
    {
        $this->isFindMagicMethod = false;
        $results = [];
        $results[] = $this->callSet($name, $arguments);
        $results[] = $this->callEnable($name, $arguments);
        $results[] = $this->callGet($name);

        $this->checkFindMagicMethod($name);

        return $this->prepareReturnMagicMethod($results);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this|null
     */
    protected function callSet(string $name, array $arguments): ?BaseDescription
    {
        if (strpos($name, 'set') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        if (strpos($name, 'setInactive') === 0 || strpos($name, 'setActive') === 0) {
            if (isset($this->otherData[$name])) { $this->otherData[$name] = []; }
            $this->otherData[$name][] = $arguments[0] ?? $this::ARGUMENT_DEFAULT;
        } else {
            $this->otherData[$name] = $arguments[0] ?? $this::ARGUMENT_DEFAULT;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this|null
     */
    protected function callEnable(string $name, array $arguments): ?BaseDescription
    {
        if (strpos($name, 'enable') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        $this->otherData[$name] = $arguments[0] ?? $this::ARGUMENT_DEFAULT;
        return $this;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    protected function callGet(string $name)
    {
        if (strpos($name, 'get') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        $paramName = preg_replace('/^get/', 'set', $name);
        return $this->otherData[$paramName] ?? null;
    }

    public function getConstructorParameters() : array
    {
        return $this->constructorParameters;
    }

    public function getOtherData() : array
    {
        return $this->otherData;
    }
}
