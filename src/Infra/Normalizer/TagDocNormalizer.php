<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;

/**
 * Class TagDocNormalizer
 */
class TagDocNormalizer
{
    /**
     * @param TagDoc $doc
     *
     * @return array
     */
    public function normalize(TagDoc $doc) : array
    {
        $tagDoc = ['name' => $doc->getName()];

        if (null !== $doc->getDescription()) {
            $tagDoc['description'] = $doc->getDescription();
        }

        return $tagDoc;
    }
}
