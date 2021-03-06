<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;

/**
 * Class MethodDocNormalizer
 */
class MethodDocNormalizer
{
    /** @var TypeDocNormalizer */
    private $typeDocNormalizer;
    /** @var ErrorDocNormalizer */
    private $errorDocNormalizer;

    /**
     * @param TypeDocNormalizer  $typeDocNormalizer
     * @param ErrorDocNormalizer $errorDocNormalizer
     */
    public function __construct(
        TypeDocNormalizer $typeDocNormalizer,
        ErrorDocNormalizer $errorDocNormalizer
    ) {
        $this->typeDocNormalizer = $typeDocNormalizer;
        $this->errorDocNormalizer = $errorDocNormalizer;
    }

    /**
     * @param MethodDoc $doc
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function normalize(MethodDoc $doc) : array
    {
        $docDescription = $docTags = $paramsSchema = $responseSchema = [];

        if (null !== $doc->getDescription()) {
            $docDescription['description'] = $doc->getDescription();
        }
        if (count($doc->getTagList())) {
            $docTags['tags'] = $doc->getTagList();
        }
        if (null !== $doc->getParamsDoc()) {
            $paramsSchema = [
                'params' => $this->typeDocNormalizer->normalize($doc->getParamsDoc())
            ];
        }
        // Create custom result schema only if provided
        if (null !== $doc->getResultDoc()) {
            $responseSchema['result'] = $this->typeDocNormalizer->normalize($doc->getResultDoc());
        }


        return [
            'identifier' => $doc->getIdentifier(),
            'name' =>$doc->getMethodName(),
        ]
            + $docDescription
            + $docTags
            + $paramsSchema
            + $responseSchema
            + $this->appendErrorsSchema($doc)
        ;
    }

    /**
     * @param MethodDoc $docObject
     *
     * @return array
     */
    private function appendErrorsSchema(MethodDoc $docObject) : array
    {
        $docArray = [];
        // Create custom result schema only if provided
        if (count($docObject->getCustomErrorList()) || count($docObject->getGlobalErrorRefList())) {
            $docArray['errors'] = array_merge(
                array_map(
                    [$this->errorDocNormalizer, 'normalize'],
                    $docObject->getCustomErrorList()
                ),
                array_map(
                    function ($errorIdentifier) {
                        return ['$ref' => sprintf('#/errors/%s', $errorIdentifier)];
                    },
                    $docObject->getGlobalErrorRefList()
                )
            );
        }

        return $docArray;
    }
}
