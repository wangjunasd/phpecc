<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Crypto\Signature;

use Wangjunasd\Ecc\Crypto\Signature\Signature;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class SignatureTest extends AbstractTestCase
{
    public function testInstance()
    {
        $r = gmp_init(10);
        $s = gmp_init(20);
        $signature = new Signature($r, $s);
        $this->assertSame($r, $signature->getR());
        $this->assertSame($s, $signature->getS());
    }
}
