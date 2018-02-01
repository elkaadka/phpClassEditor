<?php

namespace Kanel\ClassEditor\Tests;

use Kanel\ClassEditor\ClassEditor;
use Kanel\ClassEditor\Components\Method;
use Kanel\ClassEditor\Components\Property;
use Kanel\ClassEditor\Components\Visibility;
use Kanel\ClassEditor\Exceptions\ClassEditorException;
use PHPUnit\Framework\TestCase;

class ClassEditorTest extends TestCase
{
    protected $phpFileName;
    protected $notPhpFile;

    public function setUp()
    {
        parent::setUp();
        $this->phpFileName = __DIR__ . '/fixtures/class_to_edit.php';
        $this->notPhpFile = __DIR__ . '/fixtures/test.txt';
    }

    public function tearDown()
    {
        file_put_contents($this->phpFileName, file_get_contents(__DIR__ . '/fixtures/original_class.php'));
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_should_fail_if_not_php_file()
    {
        $this->expectException(ClassEditorException::class);
        new ClassEditor($this->notPhpFile);
    }

    /**
     * @test
     */
    public function it_should_succeed_with_php_file()
    {
        $class = new ClassEditor($this->phpFileName);
        $this->assertInstanceOf(ClassEditor::class, $class);
    }

    /**
     * @test
     */
    public function it_should_be_able_to_add_a_method_to_php_file()
    {
        $class = new ClassEditor($this->phpFileName);
        $content = $class->addMethod(new Method('sayHello', Visibility::PROTECTED));
        $this->assertEquals($content, file_get_contents(__DIR__ . '/fixtures/class_with_say_hello_method.php'));
    }

    /**
     * @test
     */
    public function it_should_be_able_to_add_a_property_to_php_file()
    {
        $class = new ClassEditor($this->phpFileName);
        $class->addProperty(new Property('property1', Visibility::PROTECTED));
        $class->addProperty(new Property('property2', Visibility::PROTECTED));

        $property3 = new Property('property3', Visibility::PROTECTED);
        $property3->setIsStatic(true);
        $content = $class->addProperty($property3);

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/class_with_new_properties.php'), $content);
    }
}