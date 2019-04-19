<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model;

/**
 * Class TagDoc
 */
class TagDoc
{
    /** @var string */
    private $name;
    /** @var string|null */
    private $description = null;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getName() : string
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
}
