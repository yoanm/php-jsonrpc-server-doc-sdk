<?php
namespace Yoanm\JsonRpcServerDoc\Model;

use Yoanm\JsonRpcServerDoc\Model\Type\TypeDoc;

/**
 * Class MethodDoc
 */
class MethodDoc
{
    /** @var string */
    private $methodName;
    /** @var string */
    private $identifier;
    /** @var null|TypeDoc */
    private $paramsDoc = null;
    /** @var null|TypeDoc */
    private $resultDoc = null;
    /** @var null|string */
    private $description = null;
    /** @var string[] */
    private $tags = [];
    /** @var ErrorDoc[] */
    private $customErrorList = [];

    /**
     * @param string      $methodName
     * @param string|null $identifier
     */
    public function __construct(string $methodName, string $identifier = null)
    {
        $this->methodName = $methodName;
        $this->setIdentifier($identifier ?? $methodName)
        ;
    }

    /**
     * @param string $identifier
     *
     * @return MethodDoc
     */
    public function setIdentifier(string $identifier) : MethodDoc
    {
        // Sanitize Identifier => remove space and slashes
        $this->identifier = strtr(
            ucwords(strtr(
                $identifier,
                ['_' => ' ', '/' => ' ', '.' => '_ ', '\\' => '_ ']
            )),
            [' ' => '']
        );

        return $this;
    }

    /**
     * @param TypeDoc $paramsDoc
     *
     * @return MethodDoc
     */
    public function setParamsDoc(TypeDoc $paramsDoc) : MethodDoc
    {
        $this->paramsDoc = $paramsDoc;

        return $this;
    }

    /**
     * @param TypeDoc $resultDoc
     *
     * @return MethodDoc
     */
    public function setResultDoc(TypeDoc $resultDoc) : MethodDoc
    {
        $this->resultDoc = $resultDoc;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return MethodDoc
     */
    public function setDescription(string $description) : MethodDoc
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return MethodDoc
     */
    public function addTag(string $tag) : MethodDoc
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @param ErrorDoc $customError
     *
     * @return MethodDoc
     */
    public function addCustomError(ErrorDoc $customError) : MethodDoc
    {
        $this->customErrorList[] = $customError;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName() : string
    {
        return $this->methodName;
    }

    /**
     * @return TypeDoc|null
     */
    public function getParamsDoc()
    {
        return $this->paramsDoc;
    }

    /**
     * @return TypeDoc|null
     */
    public function getResultDoc()
    {
        return $this->resultDoc;
    }

    /**
     * @return string
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getTags() : array
    {
        return $this->tags;
    }

    /**
     * @return ErrorDoc[]
     */
    public function getCustomErrorList() : array
    {
        return $this->customErrorList;
    }
}
