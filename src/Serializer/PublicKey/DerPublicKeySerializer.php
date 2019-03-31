<?php

namespace Wangjunasd\Ecc\Serializer\PublicKey;

use Wangjunasd\Ecc\Crypto\Key\PublicKeyInterface;
use Wangjunasd\Ecc\Math\MathAdapterInterface;
use Wangjunasd\Ecc\Math\MathAdapterFactory;
use Wangjunasd\Ecc\Serializer\PublicKey\Der\Formatter;
use Wangjunasd\Ecc\Serializer\PublicKey\Der\Parser;

/**
 *
 * @link https://tools.ietf.org/html/rfc5480#page-3
 */
class DerPublicKeySerializer implements PublicKeySerializerInterface
{

    const X509_ECDSA_OID = '1.2.840.10045.2.1';

    /**
     *
     * @var MathAdapterInterface
     */
    private $adapter;

    /**
     *
     * @var Formatter
     */
    private $formatter;

    /**
     *
     * @var Parser
     */
    private $parser;

    /**
     *
     * @param MathAdapterInterface $adapter
     */
    public function __construct(MathAdapterInterface $adapter = null)
    {
        $this->adapter = $adapter ?: MathAdapterFactory::getAdapter();

        $this->formatter = new Formatter($this->adapter);
        $this->parser = new Parser($this->adapter);
    }

    /**
     *
     * @param  PublicKeyInterface $key
     * @return string
     */
    public function serialize(PublicKeyInterface $key)
    {
        return $this->formatter->format($key);
    }

    public function getUncompressedKey(PublicKeyInterface $key)
    {
        return $this->formatter->encodePoint($key->getPoint());
    }

    /**
     * {@inheritDoc}
     * @see \Wangjunasd\Ecc\Serializer\PublicKey\PublicKeySerializerInterface::parse()
     */
    public function parse($string)
    {
        return $this->parser->parse($string);
    }
}
