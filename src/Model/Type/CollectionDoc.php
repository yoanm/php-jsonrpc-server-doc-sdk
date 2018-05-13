<?php
namespace Yoanm\JsonRpcServerDoc\Model\Type;

/**
 * Class CollectionDoc
 */
class CollectionDoc extends TypeDoc
{
    /*** Validation ***/
    /** @var TypeDoc[] */
    private $siblingList = [];
    /** @var null|int */
    private $minItem = null;
    /** @var null|int */
    private $maxItem = null;
    /** @var bool */
    private $allowExtraSibling = true;
    /** @var bool */
    private $allowMissingSibling = true;

    /**
     * @param TypeDoc $doc
     *
     * @return CollectionDoc
     */
    public function addSibling(TypeDoc $doc) : CollectionDoc
    {
        $this->siblingList[] = $doc;

        return $this;
    }

    /**
     * @param null|int $minItem
     *
     * @return CollectionDoc
     */
    public function setMinItem($minItem) : CollectionDoc
    {
        if (null !== $minItem && !is_int($minItem)) {
            throw new \InvalidArgumentException('minItem must be either null or an integer.');
        }

        $this->minItem = $minItem;

        return $this;
    }

    /**
     * @param null|int $maxItem
     *
     * @return CollectionDoc
     */
    public function setMaxItem($maxItem) : CollectionDoc
    {
        if (null !== $maxItem && !is_int($maxItem)) {
            throw new \InvalidArgumentException('maxItem must be either null or an integer.');
        }

        $this->maxItem = $maxItem;

        return $this;
    }

    /**
     * @param TypeDoc[] $siblingList
     *
     * @return CollectionDoc
     */
    public function setSiblingList(array $siblingList) : CollectionDoc
    {
        $this->siblingList = $siblingList;

        return $this;
    }

    /**
     * @param boolean $allowExtraSibling
     *
     * @return CollectionDoc
     */
    public function setAllowExtraSibling(bool $allowExtraSibling) : CollectionDoc
    {
        $this->allowExtraSibling = $allowExtraSibling;

        return $this;
    }

    /**
     * @param boolean $allowMissingSibling
     *
     * @return CollectionDoc
     */
    public function setAllowMissingSibling(bool $allowMissingSibling) : CollectionDoc
    {
        $this->allowMissingSibling = $allowMissingSibling;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getMinItem()
    {
        return $this->minItem;
    }

    /**
     * @return null|int
     */
    public function getMaxItem()
    {
        return $this->maxItem;
    }

    /**
     * @return bool
     */
    public function isAllowExtraSibling() : bool
    {
        return $this->allowExtraSibling;
    }

    /**
     * @return bool
     */
    public function isAllowMissingSibling() : bool
    {
        return $this->allowMissingSibling;
    }

    /**
     * @return TypeDoc[]
     */
    public function getSiblingList() : array
    {
        return $this->siblingList;
    }
}
