<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model\Type;

/**
 * Class TypeDoc
 */
class TypeDoc
{
    /*** Documentation ***/
    /** @var null|string|integer */
    private $name = null;
    /** @var null|string */
    private $description = null;
    /** @var null|mixed */
    private $default = null;
    /** @var null|mixed */
    private $example = null;

    /*** Validation ***/
    /** @var bool */
    private $required = false;
    /** @var bool */
    private $nullable = true;
    /** @var array */
    private $allowedValueList = [];

    /**
     * @param string|int $name
     *
     * @return TypeDoc
     */
    public function setName($name) : TypeDoc
    {
        if (null === $name || (!is_string($name) && !is_int($name))) {
            throw new \InvalidArgumentException('name must be either an integer or a string.');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return TypeDoc
     */
    public function setDescription(string $description) : TypeDoc
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param bool $required
     *
     * @return TypeDoc
     */
    public function setRequired(bool $required = true) : TypeDoc
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @param bool $nullable
     *
     * @return TypeDoc
     */
    public function setNullable(bool $nullable = true) : TypeDoc
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @param mixed|null $default
     *
     * @return TypeDoc
     */
    public function setDefault($default) : TypeDoc
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param mixed|null $example
     *
     * @return TypeDoc
     */
    public function setExample($example) : TypeDoc
    {
        $this->example = $example;

        return $this;
    }

    /**
     * @param mixed $allowedValue
     *
     * @return TypeDoc
     */
    public function addAllowedValue($allowedValue) : TypeDoc
    {
        $this->allowedValueList[] = $allowedValue;

        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isRequired() : bool
    {
        return $this->required;
    }

    /**
     * @return bool
     */
    public function isNullable() : bool
    {
        return $this->nullable;
    }

    /**
     * @return mixed|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return mixed|null
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * @return mixed[]
     */
    public function getAllowedValueList() : array
    {
        return $this->allowedValueList;
    }
}
