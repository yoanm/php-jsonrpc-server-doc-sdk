<?php
namespace Tests\Functional\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\HttpServerDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\HttpServerDoc
 *
 * @group Models
 */
class HttpServerDocTest extends TestCase
{
    public function testShouldManageAnOptionalEndpointNullByDefault()
    {
        $endpoint = 'my-endpoint';
        $doc = new HttpServerDoc();
        $this->assertNull($doc->getEndpoint());
        $doc->setEndpoint($endpoint);
        $this->assertSame($endpoint, $doc->getEndpoint());
    }

    public function testShouldManageAnOptionalHostNullByDefault()
    {
        $host = 'my-host';
        $doc = new HttpServerDoc();
        $this->assertNull($doc->getHost());
        $doc->setHost($host);
        $this->assertSame($host, $doc->getHost());
    }

    public function testShouldManageAnOptionalBasePathNullByDefault()
    {
        $basePath = 'my-base-path';
        $doc = new HttpServerDoc();
        $this->assertNull($doc->getBasePath());
        $doc->setBasePath($basePath);
        $this->assertSame($basePath, $doc->getBasePath());
    }

    public function testShouldManageASchemeList()
    {
        $list = ['GET'];
        $doc = new HttpServerDoc();
        $doc->setSchemeList($list);
        $this->assertSame($list, $doc->getSchemeList());
    }
}
