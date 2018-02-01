<?php

namespace Kanel\PhpEditor\Components;

use Kanel\PhpEditor\Exceptions\PhpFileEditorException;

class Method extends Component
{
	protected $name;
	protected $visibility;
	protected $isStatic = false;
	protected $isFinal = false;
	protected $isAbstract = false;
	protected $returnType;
	protected $body;
	protected $parameters = [];

	public function stroke(): string
	{
		$methodString = $this->isAbstract()? 'abstract ' : ( '' . $this->isFinal? 'final ' : '' ) .
			$this->visibility . ' ' .
			$this->isStatic? ' static ' : '' .
			'function ' .
			$this->methodName . '(' ;

		$parametersString = '';
		foreach ($this->parameters as $parameter) {
			$parametersString .= $parameter->stroke().', ';
		}

		$methodString .= rtrim($parametersString, ', '). ')' .
			$this->returnType ? ':' . $this->returnType : ' { ' .
			$this->body . "\n" . '}'
		;
	}

	/**
	 * @return mixed
	 */
	public function getVisibility()
	{
		return $this->visibility;
	}

	/**
	 * @param string $visibility
	 */
	public function setVisibility(string $visibility)
	{
		if (in_array($visibility, [Visibility::PUBLIC, Visibility::PRIVATE, Visibility::PROTECTED])) {
			$this->visibility = $visibility;
		}

	}



	/**
	 * @return bool
	 */
	public function isStatic(): bool
	{
		return $this->isStatic;
	}

	/**
	 * @param bool $isStatic
	 */
	public function setIsStatic(bool $isStatic)
	{
		$this->isStatic = $isStatic;
	}

	/**
	 * @return bool
	 */
	public function isFinal(): bool
	{
		return $this->isFinal;
	}

	/**
	 * @param bool $isFinal
	 */
	public function setIsFinal(bool $isFinal)
	{
		$this->isFinal = $isFinal;
	}

	/**
	 * @return bool
	 */
	public function isAbstract(): bool
	{
		return $this->isAbstract;
	}

	/**
	 * @param bool $isAbstract
	 */
	public function setIsAbstract(bool $isAbstract)
	{
		$this->isAbstract = $isAbstract;
	}

	/**
	 * @return string|null
	 */
	public function getReturnType()
	{
		return $this->returnType;
	}

	/**
	 * @param string $returnType
	 */
	public function setReturnType(string $returnType)
	{
		$this->returnType = $returnType;
	}

	/**
	 * @return string|null
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 */
	public function setBody(string $body)
	{
		$this->body = $body;
	}

	/**
	 * @return array
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	/**
	 * @param array $parameters
	 */
	public function addParameter(MethodParameter $parameter)
	{
		$this->parameters[] = $parameter;
	}

}