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
    private $allowExtraSibling = false;
    /** @var bool */
    private $allowMissingSibling = false;

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
     * @param int $minItem
     *
     * @return CollectionDoc
     */
    public function setMinItem(int $minItem) : CollectionDoc
    {
        $this->minItem = $minItem;

        return $this;
    }

    /**
     * @param int $maxItem
     *
     * @return CollectionDoc
     */
    public function setMaxItem(int $maxItem) : CollectionDoc
    {
        $this->maxItem = $maxItem;

        return $this;
    }

    /**
     * @param bool $allowExtraSibling
     *
     * @return CollectionDoc
     */
    public function setAllowExtraSibling(bool $allowExtraSibling) : CollectionDoc
    {
        $this->allowExtraSibling = $allowExtraSibling;

        return $this;
    }

    /**
     * @param bool $allowMissingSibling
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
