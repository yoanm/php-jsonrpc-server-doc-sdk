<?php
namespace Yoanm\JsonRpcServerDoc\Infra\Normalizer;

use Yoanm\JsonRpcServerDoc\Domain\Model\HttpServerDoc;

/**
 * Class HttpServerDocNormalizer
 */
class HttpServerDocNormalizer
{
    /** @var ServerDocNormalizer */
    private $serverDocNormalizer;

    /**
     * @param ServerDocNormalizer $serverDocNormalizer
     */
    public function __construct(ServerDocNormalizer $serverDocNormalizer)
    {
        $this->serverDocNormalizer = $serverDocNormalizer;
    }

    /**
     * @param HttpServerDoc $doc
     *
     * @return array
     */
    public function normalize(HttpServerDoc $doc)
    {
        $normalizedDoc = $this->serverDocNormalizer->normalize($doc);

        // Append http infos
        $httpDoc = [];
        if (null !== $doc->getHost()) {
            $httpDoc['host'] = $doc->getHost();
        }
        if (null !== $doc->getBasePath()) {
            $httpDoc['base-path'] = $doc->getBasePath();
        }
        if (count($doc->getSchemeList())) {
            $httpDoc['schemes'] = $doc->getSchemeList();
        }
        if (count($httpDoc)) {
            $normalizedDoc['http'] = $httpDoc;
        }

        return $normalizedDoc;
    }
}
