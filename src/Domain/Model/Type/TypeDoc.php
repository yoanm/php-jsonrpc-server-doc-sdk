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
     * @return self
     */
    public function setName($name) : self
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
     * @return self
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param bool $required
     *
     * @return self
     */
    public function setRequired(bool $required = true) : self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @param bool $nullable
     *
     * @return self
     */
    public function setNullable(bool $nullable = true) : self
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @param mixed|null $default
     *
     * @return self
     */
    public function setDefault($default) : self
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param mixed|null $example
     *
     * @return self
     */
    public function setExample($example) : self
    {
        $this->example = $example;

        return $this;
    }

    /**
     * @param mixed $allowedValue
     *
     * @return self
     */
    public function addAllowedValue($allowedValue) : self
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
