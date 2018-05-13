<?php
namespace Yoanm\JsonRpcServerDoc\Normalizer;

use Yoanm\JsonRpcServerDoc\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Model\Type\NumberDoc;
use Yoanm\JsonRpcServerDoc\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Model\Type\TypeDoc;

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
            + $this->appendObjectDoc($doc)
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
        } elseif ($doc instanceof ArrayDoc || $doc instanceof ObjectDoc) {
            if (null !== $doc->getMinItem()) {
                $paramDocMinMax['minItems'] = $doc->getMinItem();
            }
            if (null !== $doc->getMaxItem()) {
                $paramDocMinMax['maxItems'] = $doc->getMaxItem();
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
    protected function appendObjectDoc(TypeDoc $doc) : array
    {
        $paramDocProperties = [];
        if ($doc instanceof ObjectDoc) {
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
            if (count($siblingDocList)) {
                $paramDocProperties['siblings'] = $siblingDocList;
            }
            $paramDocProperties['allow_extra'] = $doc->isAllowExtraSibling();
            $paramDocProperties['allow_missing'] = $doc->isAllowMissingSibling();

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
}
