<?php
namespace Yoanm\JsonRpcServerDoc\Model\Type;

/**
 * Class ArrayDoc
 */
class ArrayDoc extends CollectionDoc
{
    /** @var TypeDoc|null */
    private $itemValidation;

    /**
     * @param TypeDoc $itemValidation
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
    public function getItemValidation()
    {
        return $this->itemValidation;
    }
}
