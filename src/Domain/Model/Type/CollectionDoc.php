<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model\Type;

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
    /** @var TypeDoc|null */
    private $itemValidation = null;

    /**
     * @param TypeDoc $doc
     *
     * @return self
     */
    public function addSibling(TypeDoc $doc) : self
    {
        $this->siblingList[] = $doc;

        return $this;
    }

    /**
     * @param int $minItem
     *
     * @return self
     */
    public function setMinItem(int $minItem) : self
    {
        $this->minItem = $minItem;

        return $this;
    }

    /**
     * @param int $maxItem
     *
     * @return self
     */
    public function setMaxItem(int $maxItem) : self
    {
        $this->maxItem = $maxItem;

        return $this;
    }

    /**
     * @param bool $allowExtraSibling
     *
     * @return self
     */
    public function setAllowExtraSibling(bool $allowExtraSibling) : self
    {
        $this->allowExtraSibling = $allowExtraSibling;

        return $this;
    }

    /**
     * @param bool $allowMissingSibling
     *
     * @return self
     */
    public function setAllowMissingSibling(bool $allowMissingSibling) : self
    {
        $this->allowMissingSibling = $allowMissingSibling;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getMinItem() : ?int
    {
        return $this->minItem;
    }

    /**
     * @return null|int
     */
    public function getMaxItem() : ?int
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
    /**
     * @param TypeDoc $itemValidation
     *
     * @return self
     */
    public function setItemValidation(TypeDoc $itemValidation) : self
    {
        $this->itemValidation = $itemValidation;

        return $this;
    }

    /**
     * @return TypeDoc|null
     */
    public function getItemValidation() : ?TypeDoc
    {
        return $this->itemValidation;
    }
}
