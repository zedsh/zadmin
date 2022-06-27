<?php

namespace zedsh\zadmin\Builder\Traits;

use zedsh\zadmin\Builder\Exceptions\MethodNotAllowedException;

trait MagicMethod
{
    /** @var bool $isFindMagicMethod */
    protected $isFindMagicMethod = false;

    /**
     * @param string $name
     * @return void
     * @throws MethodNotAllowedException
     */
    protected function checkFindMagicMethod(string $name)
    {
        if ($this->isFindMagicMethod) { return; }

        throw new MethodNotAllowedException("Метод $name не доступен");
    }

    protected function prepareReturnMagicMethod(array $results)
    {
        $results = array_filter($results);
        return count($results) ? $results[key($results)] : null;
    }
}
