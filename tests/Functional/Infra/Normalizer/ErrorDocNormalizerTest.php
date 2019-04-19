<?php
namespace Tests\Functional\Infra\Normalizer;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ErrorDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\ErrorDocNormalizer
 *
 * @group Models
 */
class ErrorDocNormalizerTest extends TestCase
{
    /** @var ErrorDocNormalizer */
    private $normalizer;
    /** @var TypeDocNormalizer|ObjectProphecy */
    private $typeDocNormalizer;

    public function setUp()
    {
        $this->typeDocNormalizer = $this->prophesize(TypeDocNormalizer::class);

        $this->normalizer = new ErrorDocNormalizer(
            $this->typeDocNormalizer->reveal()
        );
    }

    public function testShouldAtLeastAppendIdTitleTypeAndProperties()
    {
        $doc = new ErrorDoc('error-title', 234);
        $expected = [
            'id' => $doc->getIdentifier(),
            'title' => $doc->getTitle(),
            'type' => 'object',
            'properties' => [
                'code' => $doc->getCode()
            ],
        ];

        $this->assertSame($expected, $this->normalizer->normalize($doc));
    }

    public function testShouldAppendDataDocOnlyIfProvided()
    {
        $doc = new ErrorDoc('error-title', 234);
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertArrayHasKey('properties', $normalizedDoc);
        $this->assertFalse(array_key_exists('data', $normalizedDoc['properties']));

        $doc2 = new ErrorDoc('error-title', 234);
        $dataDoc = new StringDoc();
        $doc2->setDataDoc($dataDoc);
        $expectedDataDoc = ['expectedDataDoc'];
        $this->typeDocNormalizer->normalize($doc2->getDataDoc())
            ->willReturn($expectedDataDoc)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('properties', $normalizedDoc);
        $this->assertArrayHasKey('data', $normalizedDoc['properties']);
        $this->assertSame($expectedDataDoc, $normalizedDoc['properties']['data']);
    }

    public function testShouldAppendMessageOnlyIfProvided()
    {
        $doc = new ErrorDoc('error-title', 234);
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertArrayHasKey('properties', $normalizedDoc);
        $this->assertFalse(array_key_exists('message', $normalizedDoc['properties']));

        $expectedMessage = 'expected-message';
        $doc2 = new ErrorDoc('error-title', 234, $expectedMessage);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('properties', $normalizedDoc);
        $this->assertArrayHasKey('message', $normalizedDoc['properties']);
        $this->assertSame($expectedMessage, $normalizedDoc['properties']['message']);
    }
}
