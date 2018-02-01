<?php

namespace Kanel\PhpEditor;

use Kanel\PhpEditor\Exceptions\PhpFileEditorException;

class PhpEditor
{
	private $phpFilePath;

	public function __construct(string $phpFilePath)
	{
		if (!file_exists($phpFilePath) || pathinfo($phpFilePath, PATHINFO_EXTENSION) !== 'php') {
			throw new PhpFileEditorException($phpFilePath . ' is not a valid php file');
		}

		$this->phpFilePath = $phpFilePath;
	}

}
