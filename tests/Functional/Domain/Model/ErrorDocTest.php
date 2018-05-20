<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc
 *
 * @group Models
 */
class ErrorDocTest extends TestCase
{
    public function testShouldManageAStringTitleAndAnIntegerCode()
    {
        $title = 'my-title';
        $code = -235;
        $doc = new ErrorDoc($title, $code);
        $this->assertSame($title, $doc->getTitle());
        $this->assertSame($code, $doc->getCode());
        $this->assertNull($doc->getMessage());
        $this->assertNull($doc->getDataDoc());
    }

    public function testShouldAutomaticallyManageAnIdentifier()
    {
        $doc = new ErrorDoc('my-title', -235);

        $this->assertNotNull($doc->getIdentifier());
    }

    public function testShouldAllowIdentifierUpdate()
    {
        $newId = 'NewId';
        $doc = new ErrorDoc('my-title', -235);
        $doc->setIdentifier($newId);
        $this->assertSame($newId, $doc->getIdentifier());
    }

    public function testShouldManageAnOptionalMessage()
    {
        $message = 'my-message';
        $doc = new ErrorDoc('my-title', -235, $message);

        $this->assertSame($message, $doc->getMessage());
    }

    public function testShouldManageAnOptionalDataDoc()
    {
        $dataDoc = new BooleanDoc();
        $doc = new ErrorDoc('my-title', -235, null, $dataDoc);

        $this->assertSame($dataDoc, $doc->getDataDoc());
    }

    public function testShouldAllowDataDocUpdate()
    {
        $dataDocA = new BooleanDoc();
        $dataDocB = new ArrayDoc();
        $doc = new ErrorDoc('my-title', -235, null, $dataDocA);
        $this->assertSame($dataDocA, $doc->getDataDoc());
        $doc->setDataDoc($dataDocB);
        $this->assertSame($dataDocB, $doc->getDataDoc());
    }
}
