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
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $version
     *
     * @return self
     */
    public function setVersion(string $version) : self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param MethodDoc $method
     *
     * @return self
     */
    public function addMethod(MethodDoc $method) : self
    {
        $this->methodList[] = $method;

        return $this;
    }

    /**
     * @param TagDoc $tag
     *
     * @return self
     */
    public function addTag(TagDoc $tag) : self
    {
        $this->tagList[] = $tag;

        return $this;
    }

    /**
     * @param ErrorDoc $error
     *
     * @return self
     */
    public function addServerError(ErrorDoc $error) : self
    {
        $this->serverErrorList[] = $error;

        return $this;
    }

    /**
     * @param ErrorDoc $error
     *
     * @return self
     */
    public function addGlobalError(ErrorDoc $error) : self
    {
        $this->globalErrorList[] = $error;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getVersion() : ?string
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
