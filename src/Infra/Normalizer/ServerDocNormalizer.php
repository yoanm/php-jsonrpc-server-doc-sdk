<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc;

/**
 * Class ServerDocNormalizer
 */
class ServerDocNormalizer
{
    /** @var MethodDocNormalizer */
    private $methodDocNormalizer;
    /** @var TagDocNormalizer */
    private $tagDocNormalizer;
    /** @var ErrorDocNormalizer */
    private $errorDocNormalizer;

    /**
     * @param MethodDocNormalizer $methodDocNormalizer
     * @param TagDocNormalizer    $tagDocNormalizer
     */
    public function __construct(
        MethodDocNormalizer $methodDocNormalizer,
        TagDocNormalizer $tagDocNormalizer,
        ErrorDocNormalizer $errorDocNormalizer
    ) {
        $this->methodDocNormalizer = $methodDocNormalizer;
        $this->tagDocNormalizer = $tagDocNormalizer;
        $this->errorDocNormalizer = $errorDocNormalizer;
    }

    /**
     * @param ServerDoc $doc
     *
     * @return array
     */
    public function normalize(ServerDoc $doc) : array
    {
        // Info
        $rawInfo = $tagsDoc = $errorsDoc = [];
        if (null !== $doc->getName()) {
            $rawInfo['info']['name'] = $doc->getName();
        }
        if (null !== $doc->getVersion()) {
            $rawInfo['info']['version'] = $doc->getVersion();
        }

        // Tags
        $tagDocList = array_map([$this->tagDocNormalizer, 'normalize'], $doc->getTagList());
        if (count($tagDocList)) {
            $tagsDoc['tags'] = $tagDocList;
        }

        // Errors
        $serverErrorList = array_map([$this->errorDocNormalizer, 'normalize'], $doc->getServerErrorList());
        $globalErrorList = array_map([$this->errorDocNormalizer, 'normalize'], $doc->getGlobalErrorList());
        $errorList = array_merge($serverErrorList, $globalErrorList);
        if (count($errorList)) {
            $errorsDoc['errors'] = $errorList;
        }

        return $rawInfo
            + $tagsDoc
            + ['methods' => array_map([$this->methodDocNormalizer, 'normalize'], $doc->getMethodList())]
            + $errorsDoc;
    }
}
