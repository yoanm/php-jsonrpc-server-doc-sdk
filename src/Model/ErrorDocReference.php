<?php
namespace Yoanm\JsonRpcServerDoc\Model;

use Yoanm\JsonRpcServerDoc\Model\Type\TypeDoc;

/**
 * Class ErrorDocReference
 */
class ErrorDocReference extends ErrorDoc
{
    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        parent::__construct($identifier, 0, null, null, $identifier);
    }
}
