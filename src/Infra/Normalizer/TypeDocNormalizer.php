<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;

/**
 * Class TypeDocNormalizer
 */
class TypeDocNormalizer
{
    /**
     * @param TypeDoc $docObject
     *
     * @return array
     */
    public function normalize(TypeDoc $docObject) : array
    {
        $docArray = [];

        $docArray = $this->appendIfNotNull($docArray, 'description', $docObject->getDescription());

        return $docArray
            + ['type' => $this->normalizeSchemaType($docObject)]
            + ['nullable' => $docObject->isNullable()]
            + ['required' => $docObject->isRequired()]
            + $this->appendMisc($docObject)
            + $this->appendDocEnum($docObject)
            + $this->appendMinMax($docObject)
            + $this->appendCollectionDoc($docObject)
        ;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function normalizeSchemaType(TypeDoc $docObject)
    {
        $type = str_replace('Doc', '', lcfirst((new \ReflectionClass($docObject))->getShortName()));

        return ('type' === $type) ? 'string' : $type;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     */
    protected function appendMinMax(TypeDoc $docObject) : array
    {
        $docArray = [];
        if ($docObject instanceof StringDoc) {
            $docArray = $this->appendIfNotNull($docArray, 'min_length', $docObject->getMinLength());
            $docArray = $this->appendIfNotNull($docArray, 'max_length', $docObject->getMaxLength());
        } elseif ($docObject instanceof CollectionDoc) {
            $docArray = $this->appendIfNotNull($docArray, 'min_item', $docObject->getMinItem());
            $docArray = $this->appendIfNotNull($docArray, 'max_item', $docObject->getMaxItem());
        } elseif ($docObject instanceof NumberDoc) {
            return $this->appendNumberMinMax($docObject);
        }

        return $docArray;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     */
    protected function appendCollectionDoc(TypeDoc $docObject) : array
    {
        $docArray = [];
        if ($docObject instanceof CollectionDoc) {
            $siblingDocList = $this->getSiblingDocList($docObject);
            if (count($siblingDocList)) {
                $docArray['siblings'] = $siblingDocList;
            }
            if (true === $docObject->isAllowExtraSibling()) {
                $docArray['allow_extra'] = $docObject->isAllowExtraSibling();
            }
            if (true === $docObject->isAllowMissingSibling()) {
                $docArray['allow_missing'] = $docObject->isAllowMissingSibling();
            }
        }

        return $docArray;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     */
    protected function appendMisc(TypeDoc $docObject) : array
    {
        $docArray = [];
        $docArray = $this->appendIfNotNull($docArray, 'default', $docObject->getDefault());
        $docArray = $this->appendIfNotNull($docArray, 'example', $docObject->getExample());

        if ($docObject instanceof StringDoc) {
            $docArray = $this->appendIfNotNull($docArray, 'format', $docObject->getFormat());
        } elseif ($docObject instanceof ArrayDoc && null !== $docObject->getItemValidation()) {
            $docArray['item_validation'] = $this->normalize($docObject->getItemValidation());
        }

        return $docArray;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     */
    protected function appendDocEnum(TypeDoc $docObject) : array
    {
        $docArray = [];
        foreach ($docObject->getAllowedValueList() as $value) {
            $docArray['allowed_values'][] = $value;
        }

        return $docArray;
    }

    /**
     * @param CollectionDoc $docObject
     *
     * @return array
     */
    protected function getSiblingDocList(CollectionDoc $docObject) : array
    {
        $docArray = [];
        foreach ($docObject->getSiblingList() as $siblingDocObject) {
            $siblingDocArray = $this->normalize($siblingDocObject);
            // Use name if :
            // - parent is object
            // - parent is array and name is an integer
            if ($docObject instanceof ObjectDoc
                || (
                    $docObject instanceof ArrayDoc
                    && is_int($siblingDocObject->getName())
                )
            ) {
                $docArray[$siblingDocObject->getName()] = $siblingDocArray;
            } else {
                $docArray[] = $siblingDocArray;
            }
        }

        return $docArray;
    }

    /**
     * @param NumberDoc $docObject
     *
     * @return array
     */
    private function appendNumberMinMax(NumberDoc $docObject)
    {
        $docArray = [];
        if (null !== $docObject->getMin()) {
            $docArray['minimum'] = $docObject->getMin();
            $docArray['inclusive_minimum'] = $docObject->isInclusiveMin();
        }
        if (null !== $docObject->getMax()) {
            $docArray['maximum'] = $docObject->getMax();
            $docArray['inclusive_maximum'] = $docObject->isInclusiveMax();
        }

        return $docArray;
    }

    /**
     * @param array  $docArray
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    private function appendIfNotNull(array $docArray, string $key, $value) : array
    {
        if (null !== $value) {
            $docArray[$key] = $value;
        }

        return $docArray;
    }
}
