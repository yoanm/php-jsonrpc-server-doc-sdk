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
     * @param TypeDoc $doc
     *
     * @return array
     */
    public function normalize(TypeDoc $doc) : array
    {
        $paramDocDescription = [];

        if (null !== $doc->getDescription()) {
            $paramDocDescription['description'] = $doc->getDescription();
        }

        return $paramDocDescription
            + ['type' => $this->normalizeSchemaType($doc)]
            + ['nullable' => $doc->isNullable()]
            + ['required' => $doc->isRequired()]
            + $this->appendMisc($doc)
            + $this->appendDocEnum($doc)
            + $this->appendMinMax($doc)
            + $this->appendCollectionDoc($doc)
        ;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function normalizeSchemaType(TypeDoc $doc)
    {
        $type = str_replace('Doc', '', lcfirst((new \ReflectionClass($doc))->getShortName()));

        return ('type' === $type) ? 'string' : $type;
    }

    /**
     * @param TypeDoc $doc
     *
     * @return array
     */
    protected function appendMinMax(TypeDoc $doc) : array
    {
        if ($doc instanceof StringDoc) {
            return $this->appendStringMinMax($doc);
        } elseif ($doc instanceof CollectionDoc) {
            return $this->appendCollectionMinMax($doc);
        } elseif ($doc instanceof NumberDoc) {
            return $this->appendNumberMinMax($doc);
        }

        return [];
    }

    /**
     * @param TypeDoc $doc
     *
     * @return array
     */
    protected function appendCollectionDoc(TypeDoc $doc) : array
    {
        $paramDocProperties = [];
        if ($doc instanceof CollectionDoc) {
            $siblingDocList = $this->getSiblingDocList($doc);
            if (count($siblingDocList)) {
                $paramDocProperties['siblings'] = $siblingDocList;
            }
            if (true === $doc->isAllowExtraSibling()) {
                $paramDocProperties['allow_extra'] = $doc->isAllowExtraSibling();
            }
            if (true === $doc->isAllowMissingSibling()) {
                $paramDocProperties['allow_missing'] = $doc->isAllowMissingSibling();
            }
        }

        return $paramDocProperties;
    }

    /**
     * @param TypeDoc $doc
     *
     * @return array
     */
    protected function appendMisc(TypeDoc $doc) : array
    {
        $paramDocMisc = [];
        if (null !== $doc->getDefault()) {
            $paramDocMisc['default'] = $doc->getDefault();
        }
        if (null !== $doc->getExample()) {
            $paramDocMisc['example'] = $doc->getExample();
        }

        if ($doc instanceof StringDoc && null !== $doc->getFormat()) {
            $paramDocMisc['format'] = $doc->getFormat();
        } elseif ($doc instanceof ArrayDoc && null !== $doc->getItemValidation()) {
            $paramDocMisc['item_validation'] = $this->normalize($doc->getItemValidation());
        }

        return $paramDocMisc;
    }

    /**
     * @param TypeDoc $doc
     *
     * @return array
     */
    protected function appendDocEnum(TypeDoc $doc) : array
    {
        $paramDocEnum = [];
        foreach ($doc->getAllowedValueList() as $value) {
            $paramDocEnum['allowed_values'][] = $value;
        }

        return $paramDocEnum;
    }

    /**
     * @param CollectionDoc $doc
     *
     * @return TypeDoc[]
     */
    protected function getSiblingDocList(CollectionDoc $doc) : array
    {
        $siblingDocList = [];
        foreach ($doc->getSiblingList() as $sibling) {
            $siblingDoc = $this->normalize($sibling);
            // Use name if :
            // - parent is object
            // - parent is array and name is an integer
            if ($doc instanceof ObjectDoc
                || (
                    $doc instanceof ArrayDoc
                    && is_int($sibling->getName())
                )
            ) {
                $siblingDocList[$sibling->getName()] = $siblingDoc;
            } else {
                $siblingDocList[] = $siblingDoc;
            }
        }

        return $siblingDocList;
    }

    /**
     * @param StringDoc $stringDoc
     *
     * @return array
     */
    private function appendStringMinMax(StringDoc $stringDoc)
    {
        $doc = [];
        if (null !== $stringDoc->getMinLength()) {
            $doc['minLength'] = $stringDoc->getMinLength();
        }
        if (null !== $stringDoc->getMaxLength()) {
            $doc['maxLength'] = $stringDoc->getMaxLength();
        }

        return $doc;
    }

    /**
     * @param CollectionDoc $collectionDoc
     *
     * @return array
     */
    private function appendCollectionMinMax(CollectionDoc $collectionDoc)
    {
        $doc = [];
        if (null !== $collectionDoc->getMinItem()) {
            $doc['minItem'] = $collectionDoc->getMinItem();
        }
        if (null !== $collectionDoc->getMaxItem()) {
            $doc['maxItem'] = $collectionDoc->getMaxItem();
        }

        return $doc;
    }

    /**
     * @param TypeDoc $doc
     * @param $paramDocMinMax
     * @return mixed
     */
    private function appendNumberMinMax(NumberDoc $numberDoc)
    {
        $doc = [];
        if (null !== $numberDoc->getMin()) {
            $doc['minimum'] = $numberDoc->getMin();
            $doc['inclusiveMinimum'] = $numberDoc->isInclusiveMin();
        }
        if (null !== $numberDoc->getMax()) {
            $doc['maximum'] = $numberDoc->getMax();
            $doc['inclusiveMaximum'] = $numberDoc->isInclusiveMax();
        }

        return $doc;
    }
}
