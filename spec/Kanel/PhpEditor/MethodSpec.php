<?php

namespace spec\Kanel\PhpEditor;

use Kanel\PhpEditor\Method;
use Kanel\PhpEditor\Visibility;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
    	$this->beConstructedWith('test', Visibility::PUBLIC);
        $this->shouldHaveType(Method::class);
    }
}
