<?php
namespace Yoanm\JsonRpcServerDoc\Normalizer;

use Yoanm\JsonRpcServerDoc\Model\TagDoc;

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
