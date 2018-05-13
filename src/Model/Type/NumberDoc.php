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
     * @param null|int|float $min
     *
     * @return NumberDoc
     */
    public function setMin($min) : NumberDoc
    {
        if (null !== $min && !is_int($min) && !is_float($min)) {
            throw new \InvalidArgumentException('min must be either null, a float or an integer.');
        }

        $this->min = $min;

        return $this;
    }

    /**
     * @param null|int|float $max
     *
     * @return NumberDoc
     */
    public function setMax($max) : NumberDoc
    {
        if (null !== $max && !is_int($max) && !is_float($max)) {
            throw new \InvalidArgumentException('max must be either null, a float or an integer.');
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
