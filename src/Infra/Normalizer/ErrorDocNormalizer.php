<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;

/**
 * Class ErrorDocNormalizer
 */
class ErrorDocNormalizer
{
    /** @var TypeDocNormalizer */
    private $typeDocNormalizer;

    /**
     * @param TypeDocNormalizer $typeDocNormalizer
     */
    public function __construct(TypeDocNormalizer $typeDocNormalizer)
    {
        $this->typeDocNormalizer = $typeDocNormalizer;
    }

    /**
     * @param ErrorDoc $errorDoc
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function normalize(ErrorDoc $errorDoc) : array
    {
        $properties = ['code' => $errorDoc->getCode()];
        if (null !== $errorDoc->getDataDoc()) {
            $properties['data'] = $this->typeDocNormalizer->normalize($errorDoc->getDataDoc());
        }
        if (null !== $errorDoc->getMessage()) {
            $properties['message'] = $errorDoc->getMessage();
        }

        return [
            'id' => $errorDoc->getIdentifier(),
            'title' => $errorDoc->getTitle(),
            'type' => 'object',
            'properties' => $properties,
        ];
    }
}
