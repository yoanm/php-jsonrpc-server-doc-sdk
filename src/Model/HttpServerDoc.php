<?php
namespace Yoanm\JsonRpcServerDoc\Model;

/**
 * Class HttpServerDoc
 */
class HttpServerDoc extends ServerDoc
{
    /** @var string */
    private $endpoint;
    /** @var string */
    private $host;
    /** @var string|null */
    private $basePath;
    /** @var string[] */
    private $schemeList = [];

    /**
     * @param string $endpoint
     *
     * @return HttpServerDoc
     */
    public function setEndpoint(string $endpoint) : HttpServerDoc
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $host
     *
     * @return HttpServerDoc
     */
    public function setHost(string $host) : HttpServerDoc
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param null|string $basePath
     *
     * @return HttpServerDoc
     */
    public function setBasePath(string $basePath) : HttpServerDoc
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @param \string[] $schemeList
     *
     * @return HttpServerDoc
     */
    public function setSchemeList(array $schemeList) : HttpServerDoc
    {
        $this->schemeList = $schemeList;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return null|string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string[]
     */
    public function getSchemeList()
    {
        return $this->schemeList;
    }
}
