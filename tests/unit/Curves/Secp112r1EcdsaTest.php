<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Curves;

use Wangjunasd\Ecc\Crypto\Signature\SignHasher;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class Secp112r1EcdsaTest extends AbstractTestCase
{
    # https://github.com/johndoe31415/joeecc/blob/28e112174b924dd264f43b82577a4e5ca07e66df/ecc/tests/CryptoOpsTests.py#L34
    public function testEcdsaOnSecp112r1()
    {
        $expectedR = '1696427335541514286367855701829018';
        $expectedS = '1960761230049936699759766101723490';

        $adapter = \Wangjunasd\Ecc\EccFactory::getAdapter();
        $g = \Wangjunasd\Ecc\EccFactory::getSecgCurves()->generator112r1();

        $key = gmp_init('deadbeef', 16);
        $priv = $g->getPrivateKeyFrom($key);

        $data = "foobar";
        $signer = new \Wangjunasd\Ecc\Crypto\Signature\Signer($adapter);
        $hasher = new SignHasher("sha1");
        $hash = $hasher->makeHash($data, $g);
        $randomK = gmp_init('12345', 10);

        $signature = $signer->sign($priv, $hash, $randomK);
        $this->assertEquals($expectedR, $adapter->toString($signature->getR()));
        $this->assertEquals($expectedS, $adapter->toString($signature->getS()));

        $this->assertTrue($signer->verify($priv->getPublicKey(), $signature, $hash));
    }
}
