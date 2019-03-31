<?php
declare(strict_types=1);

namespace Wangjunasd\Ecc\Tests\Serializer\Point;

use Wangjunasd\Ecc\EccFactory;
use Wangjunasd\Ecc\Serializer\Point\CompressedPointSerializer;
use Wangjunasd\Ecc\Tests\AbstractTestCase;

class CompressedPointSerializerTest extends AbstractTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid data: only compressed keys are supported.
     */
    public function testChecksPrefix()
    {
        $data = '01aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $serializer = new CompressedPointSerializer(EccFactory::getAdapter());
        $serializer->unserialize(EccFactory::getNistCurves()->curve192(), $data);
    }
}
