<?php
namespace Tests\Functional\Infra\Normalizer;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\JsonRpcServerDoc\Domain\Model\HttpServerDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\HttpServerDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ServerDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\HttpServerDocNormalizer
 *
 * @group Models
 */
class HttpServerDocNormalizerTest extends TestCase
{
    use ProphecyTrait;

    /** @var HttpServerDocNormalizer */
    private $normalizer;
    /** @var ServerDocNormalizer|ObjectProphecy */
    private $serverDocNormalizer;

    protected function setUp(): void
    {
        $this->serverDocNormalizer = $this->prophesize(ServerDocNormalizer::class);

        $this->normalizer = new HttpServerDocNormalizer(
            $this->serverDocNormalizer->reveal()
        );
    }

    public function testShouldAppendNothingIfNoHttpInfoProvided()
    {
        $expected = ['expected'];
        $doc = new HttpServerDoc();
        $this->serverDocNormalizer->normalize($doc)
            ->willReturn($expected)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertSame($expected, $normalizedDoc);
    }

    public function testShouldAppendHostOnlyIfProvided()
    {
        $baseServer = ['base' => ['base-server']];
        $expectedHost = 'expected-host';
        $doc = new HttpServerDoc();
        $doc->setHost($expectedHost);
        $this->serverDocNormalizer->normalize($doc)
            ->willReturn($baseServer)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertArrayHasKey('http', $normalizedDoc);
        $this->assertArrayHasKey('host', $normalizedDoc['http']);
        $this->assertSame($expectedHost, $normalizedDoc['http']['host']);
    }

    public function testShouldAppendBasePathOnlyIfProvided()
    {
        $baseServer = ['base' => ['base-server']];
        $expectedBasePath = 'expected-basePath';
        $doc = new HttpServerDoc();
        $doc->setBasePath($expectedBasePath);
        $this->serverDocNormalizer->normalize($doc)
            ->willReturn($baseServer)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertArrayHasKey('http', $normalizedDoc);
        $this->assertArrayHasKey('base-path', $normalizedDoc['http']);
        $this->assertSame($expectedBasePath, $normalizedDoc['http']['base-path']);
    }

    public function testShouldAppendSchemeListOnlyIfProvided()
    {
        $baseServer = ['base' => ['base-server']];
        $expectedSchemeList = ['expected-scheme'];
        $doc = new HttpServerDoc();
        $doc->setSchemeList($expectedSchemeList);
        $this->serverDocNormalizer->normalize($doc)
            ->willReturn($baseServer)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertArrayHasKey('http', $normalizedDoc);
        $this->assertArrayHasKey('schemes', $normalizedDoc['http']);
        $this->assertSame($expectedSchemeList, $normalizedDoc['http']['schemes']);
    }
}
