<?php
namespace Yoanm\JsonRpcServerDoc\Model\Type;

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
     * @return NumberDoc
     */
    public function setMin($min) : NumberDoc
    {
        if (null === $min || (!is_string($min) && !is_int($min))) {
            throw new \InvalidArgumentException('min must be either a float or an integer.');
        }

        $this->min = $min;

        return $this;
    }

    /**
     * @param int|float $max
     *
     * @return NumberDoc
     */
    public function setMax($max) : NumberDoc
    {
        if (null === $max || (!is_string($max) && !is_int($max))) {
            throw new \InvalidArgumentException('max must be either a float or an integer.');
        }

        $this->max = $max;

        return $this;
    }

    /**
     * @param boolean $inclusiveMax
     */
    public function setInclusiveMax($inclusiveMax)
    {
        $this->inclusiveMax = $inclusiveMax;
    }

    /**
     * @param boolean $inclusiveMin
     */
    public function setInclusiveMin($inclusiveMin)
    {
        $this->inclusiveMin = $inclusiveMin;
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
     * @return boolean
     */
    public function isInclusiveMin()
    {
        return $this->inclusiveMin;
    }

    /**
     * @return boolean
     */
    public function isInclusiveMax()
    {
        return $this->inclusiveMax;
    }
}
