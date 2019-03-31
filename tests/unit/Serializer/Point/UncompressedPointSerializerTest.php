<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Serializer\Point;

use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Serializer\Point\UncompressedPointSerializer;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class UncompressedPointSerializerTest extends AbstractTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid data: only uncompressed keys are supported.
     */
    public function testChecksPrefix()
    {
        $data = '01aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $serializer = new UncompressedPointSerializer();
        $serializer->unserialize(EccFactory::getNistCurves()->curve192(), $data);
    }
}
