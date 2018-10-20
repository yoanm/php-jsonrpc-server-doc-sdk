<?php
namespace Yoanm\JsonRpcServerDoc\Domain\Model;

use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;

/**
 * Class MethodDoc
 */
class MethodDoc
{
    /** @var string */
    private $methodName;
    /** @var string */
    private $identifier;
    /** @var TypeDoc|null */
    private $paramsDoc = null;
    /** @var TypeDoc|null */
    private $resultDoc = null;
    /** @var string|null */
    private $description = null;
    /** @var string[] */
    private $tagList = [];
    /** @var ErrorDoc[] */
    private $customErrorList = [];
    /** @var string[] */
    private $globalErrorRefList = [];

    /**
     * @param string      $methodName
     * @param string|null $identifier
     */
    public function __construct(string $methodName, string $identifier = null)
    {
        $this->methodName = $methodName;
        $this->setIdentifier($identifier ?? $methodName);
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
                ['_' => ' ', '/' => '-', '.' => '_ ', '\\' => '_ ']
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
        $this->tagList[] = $tag;

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
     * @param string $errorIdentifier
     *
     * @return MethodDoc
     */
    public function addGlobalErrorRef(string $errorIdentifier) : MethodDoc
    {
        $this->globalErrorRefList[] = $errorIdentifier;

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
    public function getParamsDoc() : ?TypeDoc
    {
        return $this->paramsDoc;
    }

    /**
     * @return TypeDoc|null
     */
    public function getResultDoc() : ?TypeDoc
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
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getTagList() : array
    {
        return $this->tagList;
    }

    /**
     * @return ErrorDoc[]
     */
    public function getCustomErrorList() : array
    {
        return $this->customErrorList;
    }

    /**
     * @return string[]
     */
    public function getGlobalErrorRefList() : array
    {
        return $this->globalErrorRefList;
    }
}
