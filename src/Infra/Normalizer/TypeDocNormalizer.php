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
     *
     * @throws \ReflectionException
     */
    public function normalize(TypeDoc $docObject) : array
    {
        return $this->appendIfNotNull('description', $docObject->getDescription())
            + $this->appendIfNotNull('type', $this->normalizeSchemaType($docObject))
            + [
                'nullable' => $docObject->isNullable(),
                'required' => $docObject->isRequired(),
            ]
            + $this->appendMisc($docObject)
            + $this->appendDocEnum($docObject)
            + $this->appendMinMax($docObject)
            + $this->appendCollectionDoc($docObject)
        ;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    protected function normalizeSchemaType(TypeDoc $docObject) : ?string
    {
        $type = str_replace('Doc', '', lcfirst((new \ReflectionClass($docObject))->getShortName()));

        return ('type' === $type) ? null : $type;
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
            $docArray += $this->appendIfNotNull('minLength', $docObject->getMinLength());
            $docArray += $this->appendIfNotNull('maxLength', $docObject->getMaxLength());
        } elseif ($docObject instanceof CollectionDoc) {
            $docArray += $this->appendIfNotNull('minItem', $docObject->getMinItem());
            $docArray += $this->appendIfNotNull('maxItem', $docObject->getMaxItem());
        } elseif ($docObject instanceof NumberDoc) {
            $docArray = $this->appendNumberMinMax($docObject);
        }

        return $docArray;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     *
     * @throws \ReflectionException
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
                $docArray['allowExtra'] = $docObject->isAllowExtraSibling();
            }
            if (true === $docObject->isAllowMissingSibling()) {
                $docArray['allowMissing'] = $docObject->isAllowMissingSibling();
            }
        }

        return $docArray;
    }

    /**
     * @param TypeDoc $docObject
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    protected function appendMisc(TypeDoc $docObject) : array
    {
        $docArray = $this->appendIfNotNull('default', $docObject->getDefault());
        $docArray += $this->appendIfNotNull('example', $docObject->getExample());

        if ($docObject instanceof StringDoc) {
            $docArray += $this->appendIfNotNull('format', $docObject->getFormat());
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
            $docArray['allowedValues'][] = $value;
        }

        return $docArray;
    }

    /**
     * @param CollectionDoc $docObject
     *
     * @return array
     *
     * @throws \ReflectionException
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
    private function appendNumberMinMax(NumberDoc $docObject) : array
    {
        $docArray = [];
        if (null !== $docObject->getMin()) {
            $docArray['minimum'] = $docObject->getMin();
            $docArray['inclusiveMinimum'] = $docObject->isInclusiveMin();
        }
        if (null !== $docObject->getMax()) {
            $docArray['maximum'] = $docObject->getMax();
            $docArray['inclusiveMaximum'] = $docObject->isInclusiveMax();
        }

        return $docArray;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param array  $docArray
     *
     * @return array
     */
    private function appendIfNotNull(string $key, $value, array $docArray = []) : array
    {
        if (null !== $value) {
            $docArray[$key] = $value;
        }

        return $docArray;
    }
}
