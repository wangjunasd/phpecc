<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Random;

use Wangjunasd\Ecc\Math\GmpMath;
use Wangjunasd\Ecc\Primitives\CurveFp;
use Wangjunasd\Ecc\Primitives\CurveParameters;
use Wangjunasd\Ecc\Primitives\GeneratorPoint;
use Wangjunasd\Ecc\Random\DebugDecorator;
use Wangjunasd\Ecc\Random\RandomGeneratorFactory;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class RandomGeneratorFactoryTest extends AbstractTestCase
{
    public function testDebug()
    {
        $debugOn = true;

        $rng = RandomGeneratorFactory::getRandomGenerator($debugOn);
        $this->assertInstanceOf(DebugDecorator::class, $rng);
        $this->assertInstanceOf(\GMP::class, $rng->generate(gmp_init(111)));

        $adapter = new GmpMath();
        $parameters = new CurveParameters(32, gmp_init(23, 10), gmp_init(1, 10), gmp_init(1, 10));
        $curve = new CurveFp($parameters, $adapter);
        $point = new GeneratorPoint($adapter, $curve, gmp_init(13, 10), gmp_init(7, 10), gmp_init(7, 10));

        $privateKey = $point->getPrivateKeyFrom(gmp_init(1));
        $rng = RandomGeneratorFactory::getHmacRandomGenerator($privateKey, gmp_init(1), 'sha256', $debugOn);
        $this->assertInstanceOf(DebugDecorator::class, $rng);
        $this->assertInstanceOf(\GMP::class, $rng->generate(gmp_init(111)));

        ob_clean();
    }
}
