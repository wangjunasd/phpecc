<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Curves;

use Wangjunasd\Ecc\Curves\CurveFactory;
use Wangjunasd\Ecc\Curves\NistCurve;
use Wangjunasd\Ecc\Curves\SecgCurve;
use Wangjunasd\Ecc\Exception\UnsupportedCurveException;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class CurveFactoryTest extends AbstractTestCase
{
    public function getCurveNames()
    {
        return [
            [NistCurve::NAME_P192],
            [NistCurve::NAME_P224],
            [NistCurve::NAME_P256],
            [NistCurve::NAME_P384],
            [NistCurve::NAME_P521],
            [SecgCurve::NAME_SECP_112R1],
            [SecgCurve::NAME_SECP_192K1],
            [SecgCurve::NAME_SECP_256R1],
            [SecgCurve::NAME_SECP_256K1],
            [SecgCurve::NAME_SECP_384R1],
        ];
    }

    /**
     * @param string $name
     * @dataProvider getCurveNames
     */
    public function testLoadsCurveByName($name)
    {
        $curve = CurveFactory::getCurveByName($name);
        $generator = CurveFactory::getGeneratorByName($name);
        $this->assertEquals($name, $curve->getName());
        $this->assertEquals($name, $generator->getCurve()->getName());
    }

    /**
     * @expectedException \Wangjunasd\Ecc\Exception\UnsupportedCurveException
     * @expectedExceptionMessage Unknown curve.
     */
    public function testFailsOnUnknownCurve()
    {
        $curveName = 'unknown';
        try {
            CurveFactory::getCurveByName($curveName);
        } catch (UnsupportedCurveException $e) {
            $this->assertTrue($e->hasCurveName());
            $this->assertEquals($curveName, $e->getCurveName());
            throw $e;
        }
    }

    /**
     * @expectedException \Wangjunasd\Ecc\Exception\UnsupportedCurveException
     * @expectedExceptionMessage Unknown generator.
     */
    public function testFailsOnUnknownGenerator()
    {
        $curveName = 'unknown';
        try {
            CurveFactory::getGeneratorByName($curveName);
        } catch (UnsupportedCurveException $e) {
            $this->assertTrue($e->hasCurveName());
            $this->assertEquals($curveName, $e->getCurveName());
            throw $e;
        }
    }
}
