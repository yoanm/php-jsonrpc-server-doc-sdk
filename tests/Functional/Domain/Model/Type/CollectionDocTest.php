<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc
 *
 * @group Models
 */
class CollectionDocTest extends TestCase
{
    public function testShouldManageAMinItemNullByDefault()
    {
        $min = 12;
        $doc = new CollectionDoc();
        $this->assertNull($doc->getMinItem());
        $doc->setMinItem($min);
        $this->assertSame($min, $doc->getMinItem());
    }

    public function testShouldManageAMaxItemNullByDefault()
    {
        $max = 12;
        $doc = new CollectionDoc();
        $this->assertNull($doc->getMaxItem());
        $doc->setMaxItem($max);
        $this->assertSame($max, $doc->getMaxItem());
    }

    public function testShouldManageAnAllowExtraSiblingFalseByDefault()
    {
        $doc = new CollectionDoc();
        $this->assertFalse($doc->isAllowExtraSibling());
        $doc->setAllowExtraSibling(true);
        $this->assertTrue($doc->isAllowExtraSibling());
    }

    public function testShouldManageAnAllowMissingSiblingFalseByDefault()
    {
        $doc = new CollectionDoc();
        $this->assertFalse($doc->isAllowMissingSibling());
        $doc->setAllowMissingSibling(true);
        $this->assertTrue($doc->isAllowMissingSibling());
    }

    public function testShouldManageASiblingList()
    {
        $sibling = new ScalarDoc();
        $doc = new CollectionDoc();
        $doc->addSibling($sibling);
        $this->assertSame([$sibling], $doc->getSiblingList());
    }
}
