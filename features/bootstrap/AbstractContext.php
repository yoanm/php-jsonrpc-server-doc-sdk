<?php
namespace Tests\Functional\BehatContext;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

class AbstractContext implements Context
{
    public function jsonDecode($encodedData)
    {
        $decoded = json_decode($encodedData, true);

        if (JSON_ERROR_NONE != json_last_error()) {
            throw new \Exception(
                json_last_error_msg(),
                json_last_error()
            );
        }

        return $decoded;
    }

    /**
     * @param object $object
     * @param array  $decodedMethodCalls
     *
     * @return mixed
     */
    protected function callMethods($object, array $decodedMethodCalls)
    {
        foreach ($decodedMethodCalls as $decodedMethodCall) {
            call_user_func_array(
                [$object, $decodedMethodCall['method']],
                $decodedMethodCall['arguments'] ?? []
            );
        }
    }
}
