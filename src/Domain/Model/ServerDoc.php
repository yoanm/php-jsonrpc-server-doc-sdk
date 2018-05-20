<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model;

/**
 * Class ServerDoc
 */
class ServerDoc
{
    /** @var string|null */
    private $name;
    /** @var string|null */
    private $version;
    /** @var MethodDoc[] */
    private $methodList = [];
    /** @var TagDoc[] */
    private $tagList = [];
    /** @var ErrorDoc[] */
    private $serverErrorList = [];
    /** @var ErrorDoc[] */
    private $globalErrorList = [];

    /**
     * @param string $name
     *
     * @return ServerDoc
     */
    public function setName(string $name) : ServerDoc
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $version
     *
     * @return ServerDoc
     */
    public function setVersion(string $version) : ServerDoc
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param MethodDoc $method
     *
     * @return ServerDoc
     */
    public function addMethod(MethodDoc $method) : ServerDoc
    {
        $this->methodList[] = $method;

        return $this;
    }

    /**
     * @param TagDoc $tag
     *
     * @return ServerDoc
     */
    public function addTag(TagDoc $tag) : ServerDoc
    {
        $this->tagList[] = $tag;

        return $this;
    }

    /**
     * @param ErrorDoc $error
     *
     * @return ServerDoc
     */
    public function addServerError(ErrorDoc $error) : ServerDoc
    {
        $this->serverErrorList[] = $error;

        return $this;
    }

    /**
     * @param ErrorDoc $error
     *
     * @return ServerDoc
     */
    public function addGlobalError(ErrorDoc $error) : ServerDoc
    {
        $this->globalErrorList[] = $error;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return MethodDoc[]
     */
    public function getMethodList() : array
    {
        return $this->methodList;
    }

    /**
     * @return TagDoc[]
     */
    public function getTagList() : array
    {
        return $this->tagList;
    }

    /**
     * @return ErrorDoc[]
     */
    public function getServerErrorList() : array
    {
        return $this->serverErrorList;
    }

    /**
     * @return ErrorDoc[]
     */
    public function getGlobalErrorList() : array
    {
        return $this->globalErrorList;
    }
}
