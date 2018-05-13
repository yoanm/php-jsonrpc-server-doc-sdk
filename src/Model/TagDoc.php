<?php
namespace Yoanm\JsonRpcServerDoc\Model;

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
     * @return TagDoc
     */
    public function setDescription(string $description) : TagDoc
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
    public function getDescription()
    {
        return $this->description;
    }
}
