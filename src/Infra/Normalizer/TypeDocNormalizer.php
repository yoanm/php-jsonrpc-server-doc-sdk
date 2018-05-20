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

        $paramDocDescription = $this->appendIfNotNull($paramDocDescription, 'description', $doc->getDescription());

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
        $docArray = [];
        if ($doc instanceof StringDoc) {
            $docArray = $this->appendIfNotNull($docArray, 'minLength', $doc->getMinLength());
            $docArray = $this->appendIfNotNull($docArray, 'maxLength', $doc->getMaxLength());
        } elseif ($doc instanceof CollectionDoc) {
            $docArray = $this->appendIfNotNull($docArray, 'minItem', $doc->getMinItem());
            $docArray = $this->appendIfNotNull($docArray, 'maxItem', $doc->getMaxItem());
        } elseif ($doc instanceof NumberDoc) {
            return $this->appendNumberMinMax($doc);
        }

        return $docArray;
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
            $paramDocProperties = $this->appendIfNotNull(
                $paramDocProperties,
                'allow_extra',
                $doc->isAllowExtraSibling()
            );
            $paramDocProperties = $this->appendIfNotNull(
                $paramDocProperties,
                'allow_missing',
                $doc->isAllowMissingSibling()
            );
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
        $paramDocMisc = $this->appendIfNotNull($paramDocMisc, 'default', $doc->getDefault());
        $paramDocMisc = $this->appendIfNotNull($paramDocMisc, 'example', $doc->getExample());

        if ($doc instanceof StringDoc) {
            $paramDocMisc = $this->appendIfNotNull($paramDocMisc, 'format', $doc->getFormat());
        } elseif ($doc instanceof ArrayDoc) {
            $paramDocMisc = $this->appendIfNotNull($paramDocMisc, 'item_validation', $doc->getItemValidation());
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

    /**
     * @param array  $doc
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    private function appendIfNotNull(array $doc, string $key, $value)
    {
        if (null !== $value) {
            $doc[$key] = $value;
        }

        return $doc;
    }
}
