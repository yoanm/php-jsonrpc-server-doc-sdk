<?php
namespace Yoanm\JsonRpcServerDoc\Normalizer;

use Yoanm\JsonRpcServerDoc\Model\MethodDoc;

/**
 * Class MethodDocNormalizer
 */
class MethodDocNormalizer
{
    /** @var TypeDocNormalizer */
    private $TypeDocNormalizer;

    /**
     * @param TypeDocNormalizer $TypeDocNormalizer
     */
    public function __construct(TypeDocNormalizer $TypeDocNormalizer)
    {
        $this->TypeDocNormalizer = $TypeDocNormalizer;
    }

    /**
     * @param MethodDoc $doc
     *
     * @return array
     */
    public function normalize(MethodDoc $doc) : array
    {
        $docDescription = $docTags = $paramsSchema = $responseSchema = [];

        if (null !== $doc->getDescription()) {
            $docDescription['description'] = $doc->getDescription();
        }
        if (count($doc->getTags())) {
            $docTags['tags'] = $doc->getTags();
        }
        if (null !== $doc->getParamsDoc()) {
            $paramsSchema = [
                'params' => $this->TypeDocNormalizer->normalize($doc->getParamsDoc())
            ];
        }

        // Create custom result schema if provided
        if (null !== $doc->getResultDoc()) {
            $responseSchema['result'] = $this->TypeDocNormalizer->normalize($doc->getResultDoc());
        }

        return $docDescription
            + $docTags
            + [
                'identifier' => $doc->getIdentifier(),
                'name' =>$doc->getMethodName(),
            ]
            + $paramsSchema
            + $responseSchema
        ;
    }
}
