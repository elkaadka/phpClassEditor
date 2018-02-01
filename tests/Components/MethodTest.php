<?php

namespace Kanel\ClassEditor\Tests\Components;

use Kanel\ClassEditor\Components\DocComment;
use Kanel\ClassEditor\Components\Method;
use Kanel\ClassEditor\Components\MethodParameter;
use Kanel\ClassEditor\Components\MethodParameters\ArrayParameter;
use Kanel\ClassEditor\Components\MethodParameters\ClassParameter;
use Kanel\ClassEditor\Components\MethodParameters\IntParameter;
use Kanel\ClassEditor\Components\MethodParameters\MixedParameter;
use Kanel\ClassEditor\Components\MethodParameters\StdClassParameter;
use Kanel\ClassEditor\Components\MethodParameters\StringParameter;
use Kanel\ClassEditor\Components\Value;
use Kanel\ClassEditor\Components\Visibility;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Parameter;

class MethodTest extends TestCase
{
    /**
     * @test
     */
    public function it_must_have_at_least_a_name()
    {
        $method = new Method('foo');
        $this->assertEquals($method->getName(), 'foo');
    }

    /**
     * @test
     */
    public function it_should_have_default_visibility_set_to_none()
    {
        $method = new Method('foo');
        $this->assertEquals($method->getVisibility(), Visibility::NONE);
    }

    /**
     * @test
     */
    public function it_should_be_able_to_set_known_visibilities()
    {
        $method = new Method('foo', Visibility::PROTECTED);
        $this->assertEquals($method->getVisibility(), Visibility::PROTECTED);

        $method = new Method('foo', Visibility::PUBLIC);
        $this->assertEquals($method->getVisibility(), Visibility::PUBLIC);

        $method = new Method('foo', Visibility::PRIVATE);
        $this->assertEquals($method->getVisibility(), Visibility::PRIVATE);
    }

    /**
     * @test
     */
    public function it_should_fallback_to_none_for_unknown_visibility()
    {
        $method = new Method('foo', 'bar');
        $this->assertEquals($method->getVisibility(), Visibility::NONE);
    }

    /**
     * @test
     */
    public function it_should_be_able_to_define_method_as_static()
    {
        $method = new Method('foo');

        $this->assertFalse($method->isStatic());

        $method->setIsStatic(true);

        $this->assertTrue($method->isStatic());
    }

    /**
     * @test
     */
    public function it_should_be_able_to_define_method_as_final()
    {
        $method = new Method('foo');

        $this->assertFalse($method->isFinal());

        $method->setIsFinal(true);

        $this->assertTrue($method->isFinal());
    }

    /**
     * @test
     */
    public function it_should_be_able_to_define_method_as_abstract()
    {
        $method = new Method('foo');

        $this->assertFalse($method->isAbstract());

        $method->setIsAbstract(true);

        $this->assertTrue($method->isAbstract());
    }

    /**
     * @test
     */
    public function it_should_be_either_abstract_or_final()
    {
        $method = new Method('foo');
        $method->setIsAbstract(true);
        $method->setIsFinal(true);

        $this->assertFalse($method->isAbstract());
        $this->assertTrue($method->isFinal());

        $method = new Method('foo');
        $method->setIsFinal(true);
        $method->setIsAbstract(true);

        $this->assertFalse($method->isFinal());
        $this->assertTrue($method->isAbstract());
    }

    /**
     * @test
     */
    public function it_should_be_able_to_define_method_return_type()
    {
        $method = new Method('foo');
        $method->setReturnType('string');

        $this->assertEquals($method->getReturnType(), 'string');
    }

    /**
     * @test
     */
    public function it_should_be_able_to_add_method_parameters()
    {
        $method = new Method('foo');
        $method->addParameter(new MixedParameter('hello'));
        $method->addParameter(new MixedParameter('world'));

        $this->assertCount(2, $method->getParameters());

        $this->assertEquals($method->getParameters()[0]->getName(), 'hello');
        $this->assertEquals($method->getParameters()[1]->getName(), 'world');
    }

    /**
     * @test
     */
    public function it_should_be_able_to_add_method_doc_comment()
    {
        $method = new Method('foo');
        $method->setDocComment('This is a doc comment');

        $this->assertEquals($method->getDocComment(), 'This is a doc comment');
    }

    /**
     * @test
     */
    public function it_should_stroke_the_correct_function_string()
    {
        $method = new Method('foo');
        $this->assertEquals('    function foo()
    {

    }
', $method->__toString());

        $method = new Method('foo', Visibility::PUBLIC);
        $method->setIsStatic(true);
        $method->setIsAbstract(true);
        $method->setReturnType('int');
        $method->addParameter(new StringParameter('hello'));
        $method->addParameter(new IntParameter('world', 1));
        $method->addParameter(new StringParameter('lets', 'it\'s me'));
        $method->addParameter(new StringParameter('party', 'mario'));
        $this->assertEquals('    /**
     * @param string $hello
     * @param int $world
     * @param string $lets
     * @param string $party
     * @return int
     */
    abstract public static function foo(string $hello, int $world = 1, string $lets = "it\'s me", string $party = \'mario\'): int
    {

    }
', $method->__toString());

        $method = new Method('bar', Visibility::PUBLIC);
        $method->setIsStatic(true);
        $method->setIsFinal(true);
        $method->setReturnType('int');
        $method->setDocComment('This is my bar function');
        $method->addParameter(new MixedParameter('hello', '1'));
        $method->addParameter(new IntParameter('world', 1));
        $method->addParameter(new StringParameter('lets', 'it\'s me'));
        $method->addParameter(new StringParameter('party', 'mario'));
        $this->assertEquals('    /**
     * This is my bar function
     * @param mixed $hello
     * @param int $world
     * @param string $lets
     * @param string $party
     * @return int
     */
    final public static function bar($hello = 1, int $world = 1, string $lets = "it\'s me", string $party = \'mario\'): int
    {

    }
', $method->__toString());


        $method = new Method('bar', Visibility::PUBLIC);
        $method->setIsStatic(true);
        $method->setIsFinal(true);
        $method->setDocComment('This is my bar function');
        $method->addParameter(new MixedParameter('hello', '1'));
        $method->addParameter(new IntParameter('world', 1));
        $method->addParameter(new StringParameter('lets', 'it\'s me'));
        $method->addParameter(new StringParameter('party', 'mario'));
        $this->assertEquals('    /**
     * This is my bar function
     * @param mixed $hello
     * @param int $world
     * @param string $lets
     * @param string $party
     */
    final public static function bar($hello = 1, int $world = 1, string $lets = "it\'s me", string $party = \'mario\')
    {

    }
', $method->__toString());


        $method = new Method('bar', Visibility::PUBLIC);
        $method->setDocComment('This is my bar function');
        $method->addParameter(new MixedParameter('hello', '1'));
        $method->addParameter(new ArrayParameter('world', 'array()'));
        $method->addParameter(new StdClassParameter('lets', 'null'));
        $this->assertEquals('    /**
     * This is my bar function
     * @param mixed $hello
     * @param array $world
     * @param stdClass $lets
     */
    public function bar($hello = 1, array $world = array(), stdClass $lets = null)
    {

    }
', $method->__toString());


        $method = new Method('bar', Visibility::PUBLIC);
        $method->setDocComment('This is my bar function');
        $method->addParameter(new MixedParameter('hello', '1'));
        $method->addParameter(new ArrayParameter('world', 'array()'));
        $method->addParameter(new ClassParameter('lets', Method::class, 'null'));
        $this->assertEquals('    /**
     * This is my bar function
     * @param mixed $hello
     * @param array $world
     * @param Kanel\ClassEditor\Components\Method $lets
     */
    public function bar($hello = 1, array $world = array(), Kanel\ClassEditor\Components\Method $lets = null)
    {

    }
', $method->__toString());

    }
}
