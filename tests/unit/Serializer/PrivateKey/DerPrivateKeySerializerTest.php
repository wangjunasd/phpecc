<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Serializer\PrivateKey;

use FG\ASN1\ExplicitlyTaggedObject;
use FG\ASN1\Universal\BitString;
use FG\ASN1\Universal\Integer;
use FG\ASN1\Universal\OctetString;
use FG\ASN1\Universal\Sequence;
use Wangjunasd\Ecc\Crypto\Key\PrivateKey;
use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Wangjunasd\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Wangjunasd\Ecc\Serializer\Util\CurveOidMapper;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class DerPrivateKeySerializerTest extends AbstractTestCase
{
    public function testReadsDer()
    {
        $der = file_get_contents(__DIR__ . "/../../../data/openssl-secp256r1.1.der");
        $adapter = EccFactory::getAdapter();
        $derPrivSerializer = new DerPrivateKeySerializer($adapter);
        $key = $derPrivSerializer->parse($der);
        $this->assertInstanceOf(PrivateKey::class, $key);
    }

    public function testConsistent()
    {
        $adapter = EccFactory::getAdapter();
        $G = EccFactory::getNistCurves($adapter)->generator192();
        $key = $G->createPrivateKey();

        $derPrivSerializer = new DerPrivateKeySerializer($adapter, new DerPublicKeySerializer());
        $serialized = $derPrivSerializer->serialize($key);
        $parsed = $derPrivSerializer->parse($serialized);
        $this->assertTrue($adapter->equals($parsed->getSecret(), $key->getSecret()));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid data: only version 1 (RFC5915) keys are supported.
     */
    public function testHandlingOfNonV1Key()
    {
        $adapter = EccFactory::getAdapter();
        $G = EccFactory::getNistCurves($adapter)->generator192();
        $key = $G->createPrivateKey();

        $derPubSerializer = new DerPublicKeySerializer();
        $derPrivSerializer = new DerPrivateKeySerializer($adapter, $derPubSerializer);

        // I don't actually have a case of a non-v1 key - just substitute self::VERSION with 2
        $privateKeyInfo = new Sequence(
            new Integer(2),
            new OctetString(str_repeat('A', 32)),
            new ExplicitlyTaggedObject(0, CurveOidMapper::getCurveOid($key->getPoint()->getCurve())),
            new ExplicitlyTaggedObject(1, new BitString($derPubSerializer->getUncompressedKey($key->getPublicKey())))
        );

        $binary = $privateKeyInfo->getBinary();
        $derPrivSerializer->parse($binary);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid data.
     */
    public function testParseInvalidASN()
    {
        $asn = new Integer(1);
        $binary = $asn->getBinary();

        $serializer = new DerPrivateKeySerializer();
        $serializer->parse($binary);
    }
}
