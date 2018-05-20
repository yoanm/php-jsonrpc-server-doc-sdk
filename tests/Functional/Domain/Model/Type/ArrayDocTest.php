<?php
namespace Tests\Functional\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc
 *
 * @group Models
 */
class ArrayDocTest extends TestCase
{
    public function testShouldManageAnItemValidationNullByDefault()
    {
        $itemValidation = new BooleanDoc();
        $doc = new ArrayDoc();
        $this->assertNull($doc->getItemValidation());
        $doc->setItemValidation($itemValidation);
        $this->assertSame($itemValidation, $doc->getItemValidation());
    }
}
