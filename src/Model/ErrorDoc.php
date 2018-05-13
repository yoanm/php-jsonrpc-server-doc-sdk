<?php
namespace Yoanm\JsonRpcServerDoc\Model;

use Yoanm\JsonRpcServerDoc\Model\Type\TypeDoc;

/**
 * Class ErrorDoc
 */
class ErrorDoc
{
    /** @var string */
    private $title;
    /** @var string */
    private $identifier;
    /** @var int */
    private $code;
    /** @var string|null */
    private $message;
    /** @var null|TypeDoc */
    private $dataDoc = null;

    /**
     * @param string       $title
     * @param int          $code
     * @param string|null  $message
     * @param TypeDoc|null $dataDoc
     * @param string|null  $identifier
     */
    public function __construct(
        string $title,
        int $code,
        string $message = null,
        TypeDoc $dataDoc = null,
        string $identifier = null
    ) {
        $this->title = $title;
        $this->code = $code;
        $this->message = $message;
        $this->dataDoc = $dataDoc;
        $this->setIdentifier($identifier ?? $title.((string)$code));
    }

    /**
     * @param string $identifier
     *
     * @return ErrorDoc
     */
    public function setIdentifier(string $identifier) : ErrorDoc
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
     * @param TypeDoc $dataDoc
     *
     * @return ErrorDoc
     */
    public function setDataDoc(TypeDoc $dataDoc) : ErrorDoc
    {
        $this->dataDoc = $dataDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return TypeDoc|null
     */
    public function getDataDoc()
    {
        return $this->dataDoc;
    }

    /**
     * @return string
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
