<?php

namespace Wangjunasd\Ecc\Primitives;

use Wangjunasd\Ecc\Math\MathAdapterInterface;
use Wangjunasd\Ecc\Crypto\Key\PrivateKey;
use Wangjunasd\Ecc\Crypto\Key\PublicKey;
use Wangjunasd\Ecc\Random\RandomGeneratorFactory;
use Wangjunasd\Ecc\Random\RandomNumberGeneratorInterface;

/**
 * Curve point from which public and private keys can be derived.
 */
class GeneratorPoint extends Point
{
    /**
     * @var \Wangjunasd\Ecc\Random\DebugDecorator|RandomNumberGeneratorInterface|null
     */
    private $generator;

    /**
     * @param MathAdapterInterface           $adapter
     * @param CurveFpInterface               $curve
     * @param int|string                     $x
     * @param int|string                     $y
     * @param null                           $order
     * @param RandomNumberGeneratorInterface $generator
     */
    public function __construct(
        MathAdapterInterface $adapter,
        CurveFpInterface $curve,
        $x,
        $y,
        $order = null,
        RandomNumberGeneratorInterface $generator = null
    ) {
        $this->generator = $generator ?: RandomGeneratorFactory::getRandomGenerator();

        parent::__construct($adapter, $curve, $x, $y, $order);
    }

    /**
     * Verifies validity of given coordinates against the current point and its point.
     *
     * @todo   Check if really necessary here (only used for testing in lib)
     * @param  int|string $x
     * @param  int|string $y
     * @return boolean
     */
    public function isValid($x, $y)
    {
        $math = $this->getAdapter();

        $n = $this->getOrder();
        $curve = $this->getCurve();

        if ($math->cmp($x, 0) < 0 || $math->cmp($n, $x) <= 0 || $math->cmp($y, 0) < 0 || $math->cmp($n, $y) <= 0) {
            return false;
        }

        if (! $curve->contains($x, $y)) {
            return false;
        }

        $point = $curve->getPoint($x, $y)->mul($n);

        if (! $point->isInfinity()) {
            return false;
        }

        return true;
    }

    /**
     * @return PrivateKey
     */
    public function createPrivateKey()
    {
        $secret = $this->generator->generate($this->getOrder());

        return new PrivateKey($this->getAdapter(), $this, $secret);
    }

    /**
     * @param $x
     * @param $y
     * @param null $order
     * @return PublicKey
     */
    public function getPublicKeyFrom($x, $y, $order = null)
    {
        $pubPoint = $this->getCurve()->getPoint($x, $y, $order);

        return new PublicKey($this->getAdapter(), $this, $pubPoint);
    }

    /**
     * @param $secretMultiplier
     * @return PrivateKey
     */
    public function getPrivateKeyFrom($secretMultiplier)
    {
        return new PrivateKey($this->getAdapter(), $this, $secretMultiplier);
    }
}
