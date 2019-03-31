<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Crypto\Key;

use Wangjunasd\Ecc\Crypto\EcDH\EcDH;
use Wangjunasd\Ecc\Crypto\Key\PublicKey;
use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Primitives\CurveFp;
use Wangjunasd\Ecc\Primitives\GeneratorPoint;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class PrivateKeyTest extends AbstractTestCase
{
    public function testInstance()
    {
        $nist = EccFactory::getNistCurves();

        $generator = $nist->generator521();
        $curve = $generator->getCurve();

        $key = $generator->createPrivateKey();
        $this->assertInstanceOf(PublicKey::class, $key->getPublicKey());
        $this->assertInstanceOf(GeneratorPoint::class, $key->getPoint());
        $this->assertSame($generator, $key->getPoint());
        $this->assertInstanceOf(CurveFp::class, $key->getCurve());
        $this->assertSame($curve, $key->getCurve());
        $this->assertInstanceOf(\GMP::class, $key->getSecret());
        $this->assertInstanceOf(EcDH::class, $key->createExchange());
    }
}
