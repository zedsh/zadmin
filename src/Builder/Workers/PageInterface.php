<?php

namespace zedsh\zadmin\Builder\Workers;

use zedsh\zadmin\Builder\Builders\BuilderInterface;

interface PageInterface
{
    public function render() : string;

    public function setBuilder(BuilderInterface $builder) : PageInterface;
}
