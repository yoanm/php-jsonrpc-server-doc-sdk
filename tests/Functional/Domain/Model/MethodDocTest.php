<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc
 *
 * @group Models
 */
class MethodDocTest extends TestCase
{
    public function testShouldManageAStringMethodName()
    {
        $name = 'my-name';
        $doc = new MethodDoc($name);
        $this->assertSame($name, $doc->getMethodName());
    }

    public function testShouldAutomaticallyManageAnIdentifier()
    {
        $doc = new MethodDoc('my-name');

        $this->assertNotNull($doc->getIdentifier());
    }

    public function testShouldAllowIdentifierUpdate()
    {
        $newId = 'NewId';
        $doc = new MethodDoc('my-name');
        $doc->setIdentifier($newId);
        $this->assertSame($newId, $doc->getIdentifier());
    }

    public function testShouldManageAnOptionalIdentifier()
    {
        $id = 'MyId';
        $doc = new MethodDoc('my-name', $id);

        $this->assertSame($id, $doc->getIdentifier());
    }

    public function testShouldManageAnOptionalDescriptionNullByDefault()
    {
        $description = 'my-description';
        $doc = new MethodDoc('my-name');
        $this->assertNull($doc->getDescription());
        $doc->setDescription($description);
        $this->assertSame($description, $doc->getDescription());
    }

    public function testShouldManageAnOptionalParamsDocNullByDefault()
    {
        $paramsDoc = new BooleanDoc();
        $doc = new MethodDoc('my-name');
        $this->assertNull($doc->getParamsDoc());
        $doc->setParamsDoc($paramsDoc);
        $this->assertSame($paramsDoc, $doc->getParamsDoc());
    }

    public function testShouldManageAnOptionalResultDocNullByDefault()
    {
        $resultDoc = new BooleanDoc();
        $doc = new MethodDoc('my-name');
        $this->assertNull($doc->getResultDoc());
        $doc->setResultDoc($resultDoc);
        $this->assertSame($resultDoc, $doc->getResultDoc());
    }

    public function testShouldManageATagList()
    {
        $list = ['tag-name'];
        $doc = new MethodDoc('my-name');
        $doc->addTag($list[0]);
        $this->assertSame($list, $doc->getTagList());
    }

    public function testShouldManageAGlobalErrorRefList()
    {
        $list = ['ref-a'];
        $doc = new MethodDoc('my-name');
        $doc->addGlobalErrorRef($list[0]);
        $this->assertSame($list, $doc->getGlobalErrorRefList());
    }

    public function testShouldManageACustomErrorList()
    {
        $list = [new ErrorDoc('error-title', 2)];
        $doc = new MethodDoc('my-name');
        $doc->addCustomError($list[0]);
        $this->assertSame($list, $doc->getCustomErrorList());
    }
}
