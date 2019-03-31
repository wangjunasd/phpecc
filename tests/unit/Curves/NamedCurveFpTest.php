<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Curves;

use Wangjunasd\Ecc\Curves\NamedCurveFp;
use Wangjunasd\Ecc\Curves\NistCurve;
use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class NamedCurveFpTest extends AbstractTestCase
{
    public function testInstance()
    {
        $curve = EccFactory::getNistCurves()->curve384();
        $this->assertInstanceOf(NamedCurveFp::class, $curve);
        ;
        $this->assertEquals(NistCurve::NAME_P384, $curve->getName());
    }
}
