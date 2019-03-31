<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Crypto\Signature;

use Wangjunasd\Ecc\Crypto\Signature\SignHasher;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class SignerTest extends AbstractTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported hashing algorithm
     */
    public function testInvalidHashAlgorithm()
    {
        new SignHasher("blahblah");
    }
}
