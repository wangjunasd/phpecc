<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Serializer\PublicKey;

use Wangjunasd\Ecc\Crypto\Key\PublicKey;
use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Wangjunasd\Ecc\Serializer\PublicKey\PemPublicKeySerializer;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class PemPublicKeySerializerTest extends AbstractTestCase
{
    public function testReadsPem()
    {
        $der = file_get_contents(__DIR__ . "/../../../data/openssl-secp256r1.1.pub.pem");
        $adapter = EccFactory::getAdapter();
        $derSerializer = new DerPublicKeySerializer($adapter);
        $pemSerializer = new PemPublicKeySerializer($derSerializer);
        $key = $pemSerializer->parse($der);
        $this->assertInstanceOf(PublicKey::class, $key);
    }

    public function testConsistent()
    {
        $adapter = EccFactory::getAdapter();
        $G = EccFactory::getNistCurves($adapter)->generator192();
        $pubkey = $G->createPrivateKey()->getPublicKey();

        $serializer = new PemPublicKeySerializer(new DerPublicKeySerializer($adapter));
        $serialized = $serializer->serialize($pubkey);
        $parsed = $serializer->parse($serialized);
        $this->assertTrue($pubkey->getPoint()->equals($parsed->getPoint()));
        $this->assertEquals($pubkey->getCurve(), $parsed->getCurve());
        $this->assertEquals($pubkey->getGenerator(), $parsed->getGenerator());
    }
}
