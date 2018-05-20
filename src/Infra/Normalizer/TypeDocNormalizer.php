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

        return ('parameter' === $type) ? 'string' : $type;
    }

    /**
     * @param TypeDoc $doc
     *
     * @return array
     */
    protected function appendMinMax(TypeDoc $doc) : array
    {
        $paramDocMinMax = [];
        if ($doc instanceof StringDoc) {
            if (null !== $doc->getMinLength()) {
                $paramDocMinMax['minLength'] = $doc->getMinLength();
            }
            if (null !== $doc->getMaxLength()) {
                $paramDocMinMax['maxLength'] = $doc->getMaxLength();
            }
        } elseif ($doc instanceof CollectionDoc) {
            if (null !== $doc->getMinItem()) {
                $paramDocMinMax['minItem'] = $doc->getMinItem();
            }
            if (null !== $doc->getMaxItem()) {
                $paramDocMinMax['maxItem'] = $doc->getMaxItem();
            }
        } elseif ($doc instanceof NumberDoc) {
            if (null !== $doc->getMin()) {
                $paramDocMinMax['minimum'] = $doc->getMin();
                $paramDocMinMax['inclusiveMinimum'] = $doc->isInclusiveMin();
            }
            if (null !== $doc->getMax()) {
                $paramDocMinMax['maximum'] = $doc->getMax();
                $paramDocMinMax['inclusiveMaximum'] = $doc->isInclusiveMax();
            }
        }

        return $paramDocMinMax;
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
}
