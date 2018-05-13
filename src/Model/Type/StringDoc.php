<?php
namespace Yoanm\JsonRpcServerDoc\Model\Type;

/**
 * Class StringDoc
 */
class StringDoc extends ScalarDoc
{
    /*** Validation ***/
    /** @var null|bool */
    private $blankAllowed = null;
    /** @var null|string */
    private $format = null;
    /** @var null|int|float */
    private $minLength = null;
    /** @var null|int|float */
    private $maxLength = null;

    /**
     * @param bool|null $blankAllowed
     */
    public function setBlankAllowed($blankAllowed)
    {
        $this->blankAllowed = $blankAllowed;
    }

    /**
     * @param null|string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param null $minLength
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * @param null|bool $maxLength
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @return bool|null
     */
    public function isBlankAllowed()
    {
        return $this->blankAllowed;
    }

    /**
     * @return null|string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return null|bool
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @return null|bool
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }
}
