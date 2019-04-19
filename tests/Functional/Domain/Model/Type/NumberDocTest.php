<?php
namespace Tests\Functional\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc
 *
 * @group Models
 */
class NumberDocTest extends TestCase
{
    public function testShouldManageAMinNullByDefault()
    {
        $min = 12;
        $doc = new NumberDoc();
        $this->assertNull($doc->getMin());
        $doc->setMin($min);
        $this->assertSame($min, $doc->getMin());
    }

    public function testShouldManageAMaxNullByDefault()
    {
        $max = 12;
        $doc = new NumberDoc();
        $this->assertNull($doc->getMax());
        $doc->setMax($max);
        $this->assertSame($max, $doc->getMax());
    }

    public function testShouldManageAnInclusiveMinTrueByDefault()
    {
        $doc = new NumberDoc();
        $this->assertTrue($doc->isInclusiveMin());
        $doc->setInclusiveMin(false);
        $this->assertFalse($doc->isInclusiveMin());
    }

    public function testShouldManageAnInclusiveMaxTrueByDefault()
    {
        $doc = new NumberDoc();
        $this->assertTrue($doc->isInclusiveMax());
        $doc->setInclusiveMax(false);
        $this->assertFalse($doc->isInclusiveMax());
    }
}
