<?php

namespace Kanel\ClassEditor\Components\MethodParameters;

use Kanel\ClassEditor\Components\MethodParameter;
use Kanel\ClassEditor\Components\Type;
use Kanel\ClassEditor\Components\UseNameSpace;
use Kanel\ClassEditor\Components\Value;

class ClassParameter extends MethodParameter
{
    public function __construct(string $name, string $className, string $defaultValue = Value::NO_DEFAULT_VALUE, $isSplat = false)
    {
        if ($defaultValue !== Value::NULL && $defaultValue !== Value::NO_DEFAULT_VALUE) {
            $defaultValue = Value::NULL;
        }

        /*$lastbackSlash = strrchr($className, "\\");
        if ($lastbackSlash !== false) {
            UseNameSpace::addNameSpace(substr($className, 0, $lastbackSlash));
            $className = substr($className, $lastbackSlash);
        }*/

        parent::__construct($name, $defaultValue, $className, $isSplat);
    }
}