<?php

namespace Larangular\UFScraper\Tests;

use Larangular\UFScraper\UnidadFomento;

class SourceTest extends TestCase {

    public function testGetUnidadFomento() {
        $uf = new UnidadFomento();
        $value = $uf->getUnidadFomento();

        $isFloat = is_float($value);
        $decimalsLenght = strlen(substr(strrchr($value, "."), 1));

        $this->assertTrue(($isFloat && $decimalsLenght === 2));
    }
}
