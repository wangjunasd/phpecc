<?php

namespace Wangjunasd\Ecc\Serializer\PublicKey\Der;

use FG\ASN1\Universal\Sequence;
use FG\ASN1\Universal\ObjectIdentifier;
use FG\ASN1\Universal\BitString;
use Wangjunasd\Ecc\Primitives\PointInterface;
use Wangjunasd\Ecc\Crypto\Key\PublicKeyInterface;
use Wangjunasd\Ecc\Math\MathAdapterInterface;
use Wangjunasd\Ecc\Curves\NamedCurveFp;
use Wangjunasd\Ecc\Serializer\Util\CurveOidMapper;
use Wangjunasd\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Wangjunasd\Ecc\Serializer\Point\PointSerializerInterface;
use Wangjunasd\Ecc\Serializer\Point\UncompressedPointSerializer;

class Formatter
{

    private $adapter;

    private $pointSerializer;

    public function __construct(MathAdapterInterface $adapter, PointSerializerInterface $pointSerializer = null)
    {
        $this->adapter = $adapter;
        $this->pointSerializer = $pointSerializer ?: new UncompressedPointSerializer($adapter);
    }

    public function format(PublicKeyInterface $key)
    {
        if (! ($key->getCurve() instanceof NamedCurveFp)) {
            throw new \RuntimeException('Not implemented for unnamed curves');
        }

        $sequence = new Sequence(
            new Sequence(
                new ObjectIdentifier(DerPublicKeySerializer::X509_ECDSA_OID),
                CurveOidMapper::getCurveOid($key->getCurve())
            ),
            new BitString($this->encodePoint($key->getPoint()))
        );

        return $sequence->getBinary();
    }

    public function encodePoint(PointInterface $point)
    {
        return $this->pointSerializer->serialize($point);
    }
}
