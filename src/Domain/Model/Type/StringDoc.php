<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model\Type;

/**
 * Class StringDoc
 */
class StringDoc extends ScalarDoc
{
    /*** Validation ***/
    /** @var string|null */
    private $format = null;
    /** @var int|null */
    private $minLength = null;
    /** @var int|null */
    private $maxLength = null;

    /**
     * @param string $format
     *
     * @return self
     */
    public function setFormat(string $format) : self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param int $minLength
     *
     * @return self
     */
    public function setMinLength(int $minLength) : self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @param int $maxLength
     *
     * @return self
     */
    public function setMaxLength(int $maxLength) : self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat() : ?string
    {
        return $this->format;
    }

    /**
     * @return int|null
     */
    public function getMinLength() : ?int
    {
        return $this->minLength;
    }

    /**
     * @return int|null
     */
    public function getMaxLength() : ?int
    {
        return $this->maxLength;
    }
}
