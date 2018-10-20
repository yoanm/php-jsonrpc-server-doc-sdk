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
     * @return StringDoc
     */
    public function setFormat(string $format) : StringDoc
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param int $minLength
     *
     * @return StringDoc
     */
    public function setMinLength(int $minLength) : StringDoc
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @param int $maxLength
     *
     * @return StringDoc
     */
    public function setMaxLength(int $maxLength) : StringDoc
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
