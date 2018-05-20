<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc
 *
 * @group Models
 */
class TagDocTest extends TestCase
{
    public function testShouldManageAStringName()
    {
        $name = 'my-name';
        $doc = new TagDoc($name);
        $this->assertSame($name, $doc->getName());
    }

    public function testShouldManageAnOptionalDescriptionNullByDefault()
    {
        $description = 'my-description';
        $doc = new TagDoc('my-name');
        $this->assertNull($doc->getDescription());
        $doc->setDescription($description);
        $this->assertSame($description, $doc->getDescription());
    }
}
