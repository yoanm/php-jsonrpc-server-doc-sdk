<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model;

/**
 * Class HttpServerDoc
 */
class HttpServerDoc extends ServerDoc
{
    /** @var string|null */
    private $endpoint = null;
    /** @var string|null */
    private $host = null;
    /** @var string|null */
    private $basePath = null;
    /** @var string[] */
    private $schemeList = [];

    /**
     * @param string $endpoint
     *
     * @return self
     */
    public function setEndpoint(string $endpoint) : self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $host
     *
     * @return self
     */
    public function setHost(string $host) : self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param string $basePath
     *
     * @return self
     */
    public function setBasePath(string $basePath) : self
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @param string[] $schemeList
     *
     * @return self
     */
    public function setSchemeList(array $schemeList) : self
    {
        $this->schemeList = $schemeList;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndpoint() : ?string
    {
        return $this->endpoint;
    }

    /**
     * @return string|null
     */
    public function getHost() : ?string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getBasePath() : ?string
    {
        return $this->basePath;
    }

    /**
     * @return string[]
     */
    public function getSchemeList() : array
    {
        return $this->schemeList;
    }
}
