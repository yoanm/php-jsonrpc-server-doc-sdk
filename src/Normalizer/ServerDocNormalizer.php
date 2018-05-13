<?php
namespace Yoanm\JsonRpcServerDoc\Normalizer;

use Yoanm\JsonRpcServerDoc\Model\ServerDoc;

/**
 * Class ServerDocNormalizer
 */
class ServerDocNormalizer
{
    /** @var MethodDocNormalizer */
    private $methodDocNormalizer;
    /** @var TagDocNormalizer */
    private $tagDocNormalizer;

    /**
     * @param MethodDocNormalizer $methodDocNormalizer
     * @param TagDocNormalizer    $tagDocNormalizer
     */
    public function __construct(MethodDocNormalizer $methodDocNormalizer, TagDocNormalizer $tagDocNormalizer)
    {
        $this->methodDocNormalizer = $methodDocNormalizer;
        $this->tagDocNormalizer = $tagDocNormalizer;
    }

    /**
     * @param ServerDoc $doc
     *
     * @return array
     */
    public function normalize(ServerDoc $doc) : array
    {
        $rawInfo = $methodsDoc = $tagsDoc = [];
        if (null !== $doc->getName()) {
            $rawInfo['info']['title'] = $doc->getName();
        }
        if (null !== $doc->getVersion()) {
            $rawInfo['info']['version'] = $doc->getVersion();
        }

        $methodDocList = array_map([$this->methodDocNormalizer, 'normalize'], $doc->getMethodList());
        if (count($methodDocList)) {
            $methodsDoc['methods'] = $methodDocList;
        }
        $tagDocList = array_map([$this->tagDocNormalizer, 'normalize'], $doc->getTagList());
        if (count($tagDocList)) {
            $tagsDoc['tags'] = $tagDocList;
        }

        return $rawInfo
            + $tagsDoc
            + $methodsDoc;
    }
}
