<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc
 *
 * @group Models
 */
class ServerDocTest extends TestCase
{
    public function testShouldManageAnOptionalNameNullByDefault()
    {
        $name = 'my-name';
        $doc = new ServerDoc();
        $this->assertNull($doc->getName());
        $doc->setName($name);
        $this->assertSame($name, $doc->getName());
    }

    public function testShouldManageAnOptionalVersionNullByDefault()
    {
        $version = 'my-version';
        $doc = new ServerDoc();
        $this->assertNull($doc->getVersion());
        $doc->setVersion($version);
        $this->assertSame($version, $doc->getVersion());
    }

    public function testShouldManageAMethodList()
    {
        $list = [new MethodDoc('method-name')];
        $doc = new ServerDoc();
        $doc->addMethod($list[0]);
        $this->assertSame($list, $doc->getMethodList());
    }

    public function testShouldManageATagList()
    {
        $list = [new TagDoc('tag-name')];
        $doc = new ServerDoc();
        $doc->addTag($list[0]);
        $this->assertSame($list, $doc->getTagList());
    }

    public function testShouldManageAServerErrorList()
    {
        $list = [new ErrorDoc('error-title', 1)];
        $doc = new ServerDoc();
        $doc->addServerError($list[0]);
        $this->assertSame($list, $doc->getServerErrorList());
    }

    public function testShouldManageAGlobalErrorList()
    {
        $list = [new ErrorDoc('error-title', 1)];
        $doc = new ServerDoc();
        $doc->addGlobalError($list[0]);
        $this->assertSame($list, $doc->getGlobalErrorList());
    }
}
