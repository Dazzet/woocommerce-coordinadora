<?php

use WcCoordinadora\Webservice\RequestParameter;

class RequestParameterTest extends PHPUnit\Framework\TestCase
{
    public function setup()
    {
        $this->req = new RequestParameter;
    }

    public function testThatPhpUnitWorks()
    {
        $this->assertEquals(4, 4, 'No son iguales');
    }
}
