<?php
namespace Yoanm\JsonRpcServerDoc\Normalizer;

use Yoanm\JsonRpcServerDoc\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Model\Type\CollectionDoc;
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
    public function normalize(TypeDoc $doc)
    {
        $paramDocEnum = $paramDocType = [];
        $paramDocFormat = $paramDocX = [];
        $paramDocProperties = $paramDocRequired = $paramDocAdditionalProperties = [];
        $paramDocMin = $paramDocMax = $paramDocItems = [];
        $paramDocDescription = $paramDocDefault = $paramDocExample = [];
        $paramDocType['type'] = $this->normalizeSchemaType($doc);
        if (count($doc->getAllowedValueList())) {
            foreach ($doc->getAllowedValueList() as $value) {
                $paramDocEnum['allowed_values'][] = $value;
            }
        }
        if ($doc instanceof StringDoc) {
            if (null !== $doc->getFormat()) {
                $paramDocFormat['format'] = $doc->getFormat();
            }
            if ($doc->getMinLength()) {
                $paramDocMax['minLength'] = $doc->getMinLength();
            }
            if ($doc->getMaxLength()) {
                $paramDocMax['maxLength'] = $doc->getMaxLength();
            }
        } elseif ($doc instanceof CollectionDoc) {
            if ($doc instanceof ArrayDoc) {
                if (null !== $doc->getItemValidation()) {
                    $paramDocItems['item_validation'] = $this->normalize($doc->getItemValidation());
                }
            } elseif ($doc instanceof ObjectDoc) {
                $paramDocAdditionalProperties['allow_extra'] = $doc->isAllowExtraSibling();
                $paramDocAdditionalProperties['allow_missing'] = $doc->isAllowMissingSibling();
                if (count($doc->getSiblingList())) {
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
                    $paramDocProperties['siblings'] = $siblingDocList;
                }
            }


            if ($doc instanceof ArrayDoc || $doc instanceof ObjectDoc) {
                if ($doc->getMinItem()) {
                    $paramDocMin['minItems'] = $doc->getMinItem();
                }
                if ($doc->getMaxItem()) {
                    $paramDocMax['maxItems'] = $doc->getMaxItem();
                }
            }
        } elseif ($doc instanceof NumberDoc) {
            if ($doc->getMin()) {
                $paramDocMin['minimum'] = $doc->getMin();
                $paramDocMin['inclusiveMinimum'] = $doc->isInclusiveMin();
            }
            if ($doc->getMax()) {
                $paramDocMax['maximum'] = $doc->getMax();
                $paramDocMax['exclusiveMaximum'] = $doc->isInclusiveMax();
            }
        }

        if (null !== $doc->getDescription()) {
            $paramDocDescription['description'] = $doc->getDescription();
        }
        if (null !== $doc->getDefault()) {
            $paramDocDefault['default'] = $doc->getDefault();
        }
        if (null !== $doc->getExample()) {
            $paramDocExample['example'] = $doc->getExample();
        }

        return $paramDocDescription
            + $paramDocType
            + $paramDocFormat
            + ['nullable' => ($doc->isNullable() === true)]
            + $paramDocRequired
            + $paramDocDefault
            + $paramDocExample
            + $paramDocEnum
            + $paramDocMin
            + $paramDocMax
            + $paramDocX
            + $paramDocAdditionalProperties
            + $paramDocItems
            + $paramDocProperties
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
}
