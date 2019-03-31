<?php

namespace Wangjunasd\Ecc\File;

use Wangjunasd\Ecc\Crypto\Key\PublicKeyInterface;
use Wangjunasd\Ecc\Crypto\Key\PrivateKeyInterface;

interface FileLoader
{
    /**
     * @param $file
     * @return PublicKeyInterface
     */
    public function loadPublicKeyData($file);

    /**
     * @param $file
     * @return PrivateKeyInterface
     */
    public function loadPrivateKeyData($file);
}
