<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace This\Is\My\Package;

use My\Package\One;
use My\Package\Two;
use My\Package\Three;

/**
 * Class Application
 * @package This\Is\My\Package
 */
class Application
{
    private $attributeOne = array();
    private $attributeTwo = false;

    /**
     * Application constructor.
     * @param $aq
     * @param $b
     */
    public function __construct($a, $b)
    {
        $this->attributeOne = $a;
        $this->attributeTwo = $b;
    }

    private function init()
    {
        echo 'this is my init';
    }


    protected function sayHello()
    {

    }

}
