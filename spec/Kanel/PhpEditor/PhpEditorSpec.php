<?php

namespace spec\Kanel\PhpEditor;

use Kanel\PhpEditor\PhpEditor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhpEditorSpec extends ObjectBehavior
{
	protected $phpFile;
	protected $txtFile;

	public function let() {
		$this->phpFile = __DIR__ . '/../../fixtures/Application.php';
		$this->txtFile = __DIR__ . '/../../fixtures/test.txt';
	}

    function it_is_initializable()
    {
		$this->beConstructedWith($this->phpFile);
		$this->shouldHaveType(PhpEditor::class);
    }

    function it_should_fail_if_file_is_not_php() {
		$this->shouldThrow(\Exception::class)->duringInstantiation();
	}

	function it_should_be_able_to_change_function_name() {
		$this->beConstructedWith($this->phpFile);
		$this->renameMethod('setDispatcher', 'setDispatcherNew');
	}

	function it_should_be_able_to_add_new_function() {
		$this->beConstructedWith($this->phpFile);

		$method = new Method('newMethodName', Visibility::PROTECTED);
		$method->setReturnType('bool');
		$method->addParam('param1', 'defaultValue', 'string');
		$method->addParam('param1', 'defaultValue', 'string');
		$method->setBody('');

		$this->createMethod($method);
	}

	function it_should_be_able_to_add_new_function_from_template() {
		$this->beConstructedWith($this->phpFile);

		$this->createMethodFromTemplate("public function test(int \$a): bool\n{\n return \$a > 5\n}\n");
	}
}
