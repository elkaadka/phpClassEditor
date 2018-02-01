<?php

namespace Kanel\PhpEditor\Components;

class Component
{
	protected $name;

	final public function __construct(string $name)
	{
		$this->name = $name;
	}
}