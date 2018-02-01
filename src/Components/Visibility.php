<?php

namespace Kanel\ClassEditor\Components;

class Visibility extends Component
{
	const PROTECTED = 'protected';
	const PRIVATE = 'private';
    const PUBLIC = 'public';
    const NONE = '';

    protected $name;

    public function __construct(string $name)
    {

        if (!in_array($name, [self::PUBLIC, self::PRIVATE, self::PROTECTED, self::NONE])) {
            $name = Visibility::NONE;
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return ($this->name !== Visibility::NONE ? $this->name . ' ' : '');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}