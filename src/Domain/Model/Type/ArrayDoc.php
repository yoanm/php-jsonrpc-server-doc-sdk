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
     * @return ArrayDoc
     */
    public function setItemValidation(TypeDoc $itemValidation) : ArrayDoc
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
