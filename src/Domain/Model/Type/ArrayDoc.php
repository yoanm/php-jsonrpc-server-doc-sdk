<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model\Type;

/**
 * Class ArrayDoc
 */
class ArrayDoc extends CollectionDoc
{
    /** @var TypeDoc|null */
    private $itemValidation = null;

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
