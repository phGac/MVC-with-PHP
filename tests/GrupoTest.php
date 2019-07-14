<?php

namespace Tests;

require(__DIR__.'/../modules/Model.php');
//require(__DIR__.'/../app/models/Grupo.php');

use Models\Grupo;
use PHPUnit\Framework\TestCase;

final class GrupoTest extends TestCase{

    public function testHelloWorld()
    {
        $this->assertEquals("hello world", "hello world");
    }

}

?>