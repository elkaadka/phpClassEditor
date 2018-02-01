<?php

namespace Kanel\ClassEditor\Components\MethodParameters;

use Kanel\ClassEditor\Components\MethodParameter;
use Kanel\ClassEditor\Components\Type;
use Kanel\ClassEditor\Components\Value;

class MixedParameter extends MethodParameter
{
    public function __construct(string $name, string $defaultValue = Value::NO_DEFAULT_VALUE, $isSplat = false)
    {
        parent::__construct($name, $defaultValue, Type::MIXED, $isSplat);
    }
}