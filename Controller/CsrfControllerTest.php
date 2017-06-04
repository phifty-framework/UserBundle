<?php

namespace UserBundle\Controller;

use PHPUnit\Framework\TestCase;

class CsrfControllerTest extends TestCase
{
    public function setUp()
    {

    }

    public function testController()
    {
        $env = [];
        $response = [];
        $controller = new CsrfController([], []);
    }
}
