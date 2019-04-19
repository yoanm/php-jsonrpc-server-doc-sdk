<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model\Type;

/**
 * Class NumberDoc
 */
class NumberDoc extends ScalarDoc
{
    /*** Validation ***/
    /** @var null|int|float */
    private $min = null;
    /** @var null|int|float */
    private $max = null;
    /** @var bool */
    private $inclusiveMin = true;
    /** @var bool */
    private $inclusiveMax = true;

    /**
     * @param int|float $min
     *
     * @return self
     */
    public function setMin($min) : self
    {
        if (null === $min || (!is_float($min) && !is_int($min))) {
            throw new \InvalidArgumentException('min must be either a float or an integer.');
        }

        $this->min = $min;

        return $this;
    }

    /**
     * @param int|float $max
     *
     * @return self
     */
    public function setMax($max) : self
    {
        if (null === $max || (!is_float($max) && !is_int($max))) {
            throw new \InvalidArgumentException('max must be either a float or an integer.');
        }

        $this->max = $max;

        return $this;
    }

    /**
     * @param bool $inclusiveMax
     *
     * @return self
     */
    public function setInclusiveMax(bool $inclusiveMax) : self
    {
        $this->inclusiveMax = $inclusiveMax;

        return $this;
    }

    /**
     * @param bool $inclusiveMin
     *
     * @return self
     */
    public function setInclusiveMin(bool $inclusiveMin) : self
    {
        $this->inclusiveMin = $inclusiveMin;

        return $this;
    }

    /**
     * @return null|int|float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return null|int|float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return bool
     */
    public function isInclusiveMin() : bool
    {
        return $this->inclusiveMin;
    }

    /**
     * @return bool
     */
    public function isInclusiveMax() : bool
    {
        return $this->inclusiveMax;
    }
}
