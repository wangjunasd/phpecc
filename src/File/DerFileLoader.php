<?php

namespace Wangjunasd\Ecc\File;

class DerFileLoader implements FileLoader
{
    /**
     * {@inheritDoc}
     * @see \Wangjunasd\Ecc\File\FileLoader::loadPublicKeyData()
     */
    public function loadPublicKeyData($file)
    {
        return file_get_contents($file);
    }

    /**
     * {@inheritDoc}
     * @see \Wangjunasd\Ecc\File\FileLoader::loadPrivateKeyData()
     */
    public function loadPrivateKeyData($file)
    {
        return file_get_contents($file);
    }
}
