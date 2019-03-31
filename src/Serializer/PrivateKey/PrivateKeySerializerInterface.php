<?php

namespace Wangjunasd\Ecc\Serializer\PrivateKey;

use Wangjunasd\Ecc\Crypto\Key\PrivateKeyInterface;

interface PrivateKeySerializerInterface
{
    /**
     *
     * @param  PrivateKeyInterface $key
     * @return string
     */
    public function serialize(PrivateKeyInterface $key);

    /**
     *
     * @param  string $formattedKey
     * @return PrivateKeyInterface
     */
    public function parse($formattedKey);
}
