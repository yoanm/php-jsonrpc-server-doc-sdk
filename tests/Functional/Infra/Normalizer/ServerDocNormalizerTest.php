<?php
namespace Tests\Functional\Infra\Normalizer;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ErrorDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ServerDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TagDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\ServerDocNormalizer
 *
 * @group Models
 */
class ServerDocNormalizerTest extends TestCase
{
    /** @var ServerDocNormalizer */
    private $normalizer;
    /** @var MethodDocNormalizer|ObjectProphecy */
    private $methodDocNormalizer;
    /** @var TagDocNormalizer|ObjectProphecy */
    private $tagDocNormalizer;
    /** @var ErrorDocNormalizer|ObjectProphecy */
    private $errorDocNormalizer;

    public function setUp()
    {
        $this->methodDocNormalizer = $this->prophesize(MethodDocNormalizer::class);
        $this->tagDocNormalizer = $this->prophesize(TagDocNormalizer::class);
        $this->errorDocNormalizer = $this->prophesize(ErrorDocNormalizer::class);

        $this->normalizer = new ServerDocNormalizer(
            $this->methodDocNormalizer->reveal(),
            $this->tagDocNormalizer->reveal(),
            $this->errorDocNormalizer->reveal()
        );
    }

    public function testShouldHaveOnlyAMethodsKeyByDefault()
    {
        $doc = new ServerDoc();
        $expected = ['methods' => []];

        $this->assertSame($expected, $this->normalizer->normalize($doc));
    }

    public function testShouldAppendNameOnlyIfProvided()
    {
        $doc = new ServerDoc();
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('info', $normalizedDoc));

        $expectedName = 'expected-name';
        $doc2 = new ServerDoc();
        $doc2->setName($expectedName);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('info', $normalizedDoc);
        $this->assertArrayHasKey('name', $normalizedDoc['info']);
        $this->assertSame($expectedName, $normalizedDoc['info']['name']);
    }

    public function testShouldAppendVersionOnlyIfProvided()
    {
        $doc = new ServerDoc();
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('info', $normalizedDoc));

        $expectedVersion = 'expected-version';
        $doc2 = new ServerDoc();
        $doc2->setVersion($expectedVersion);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('info', $normalizedDoc);
        $this->assertArrayHasKey('version', $normalizedDoc['info']);
        $this->assertSame($expectedVersion, $normalizedDoc['info']['version']);
    }

    public function testShouldAppendServerErrorListOnlyIfProvided()
    {
        $doc = new ServerDoc();
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('errors', $normalizedDoc));

        $expectedServerErrorList = [['expected-errors-doc']];
        $error = new ErrorDoc('an-error', 234);
        $doc2 = new ServerDoc();
        $doc2->addServerError($error);
        $this->errorDocNormalizer->normalize($error)
            ->willReturn($expectedServerErrorList[0])
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('errors', $normalizedDoc);
        $this->assertSame($expectedServerErrorList, $normalizedDoc['errors']);
    }


    public function testShouldAppendGlobalErrorListOnlyIfProvided()
    {
        $doc = new ServerDoc();
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('errors', $normalizedDoc));

        $expectedGlobalErrorList = [['expected-errors-doc']];
        $error = new ErrorDoc('an-error', 234);
        $doc2 = new ServerDoc();
        $doc2->addGlobalError($error);
        $this->errorDocNormalizer->normalize($error)
            ->willReturn($expectedGlobalErrorList[0])
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('errors', $normalizedDoc);
        $this->assertSame($expectedGlobalErrorList, $normalizedDoc['errors']);
    }


    public function testShouldAppendTagListOnlyIfProvided()
    {
        $doc = new ServerDoc();
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('tags', $normalizedDoc));

        $expectedTagList = [['expected-tags-doc']];
        $tag = new TagDoc('a-tag');
        $doc2 = new ServerDoc();
        $doc2->addTag($tag);
        $this->tagDocNormalizer->normalize($tag)
            ->willReturn($expectedTagList[0])
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('tags', $normalizedDoc);
        $this->assertSame($expectedTagList, $normalizedDoc['tags']);
    }
}
