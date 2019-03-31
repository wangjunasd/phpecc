<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Serializer\PrivateKey;

use Wangjunasd\Ecc\Crypto\Key\PrivateKey;
use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Wangjunasd\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class PemPrivateKeySerializerTest extends AbstractTestCase
{
    public function testReadsDer()
    {
        $der = file_get_contents(__DIR__ . "/../../../data/openssl-secp256r1.pem");
        $adapter = EccFactory::getAdapter();
        $derSerializer = new DerPrivateKeySerializer($adapter);
        $pemSerializer = new PemPrivateKeySerializer($derSerializer);
        $key = $pemSerializer->parse($der);
        $this->assertInstanceOf(PrivateKey::class, $key);
    }

    public function testConsistent()
    {
        $adapter = EccFactory::getAdapter();
        $G = EccFactory::getNistCurves($adapter)->generator192();
        $key = $G->createPrivateKey();

        $derPrivSerializer = new DerPrivateKeySerializer($adapter);
        $pemSerializer = new PemPrivateKeySerializer($derPrivSerializer);

        $serialized = $pemSerializer ->serialize($key);
        $parsed = $pemSerializer ->parse($serialized);
        $this->assertTrue($adapter->equals($parsed->getSecret(), $key->getSecret()));
    }
}
