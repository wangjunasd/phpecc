<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Random;

use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Crypto\Key\PrivateKey;
use Wangjunasd\Ecc\Random\HmacRandomNumberGenerator;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class HmacRandomNumberGeneratorTest extends AbstractTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported hashing algorithm
     */
    public function testRequireValidAlgorithm()
    {
        $math = EccFactory::getAdapter();
        $g = EccFactory::getNistCurves()->generator192();
        $privateKey  = new PrivateKey($math, $g, gmp_init(1, 10));
        $hash = gmp_init(hash('sha256', 'message', false), 16);

        new HmacRandomNumberGenerator($math, $privateKey, $hash, 'sha256aaaa');
    }
}
