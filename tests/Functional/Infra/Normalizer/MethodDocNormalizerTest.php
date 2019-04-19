<?php
namespace Tests\Functional\Infra\Normalizer;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ErrorDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer
 *
 * @group Models
 */
class MethodDocNormalizerTest extends TestCase
{
    /** @var MethodDocNormalizer */
    private $normalizer;
    /** @var TypeDocNormalizer|ObjectProphecy */
    private $typeDocNormalizer;
    /** @var ErrorDocNormalizer|ObjectProphecy */
    private $errorDocNormalizer;

    public function setUp()
    {
        $this->typeDocNormalizer = $this->prophesize(TypeDocNormalizer::class);
        $this->errorDocNormalizer = $this->prophesize(ErrorDocNormalizer::class);

        $this->normalizer = new MethodDocNormalizer(
            $this->typeDocNormalizer->reveal(),
            $this->errorDocNormalizer->reveal()
        );
    }

    public function testShouldAtLeastAppendIdAndName()
    {
        $doc = new MethodDoc('method-name');
        $expected = [
            'identifier' => $doc->getIdentifier(),
            'name' => $doc->getMethodName(),
        ];

        $this->assertSame($expected, $this->normalizer->normalize($doc));
    }

    public function testShouldAppendDescriptionOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('description', $normalizedDoc));

        $expectedDescription = 'expected-description';
        $doc2 = new MethodDoc('method-name');
        $doc2->setDescription($expectedDescription);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('description', $normalizedDoc);
        $this->assertSame($expectedDescription, $normalizedDoc['description']);
    }

    public function testShouldAppendTagListOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('tags', $normalizedDoc));

        $expectedTagList = ['tag'];
        $doc2 = new MethodDoc('method-name');
        $doc2->addTag($expectedTagList[0]);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('tags', $normalizedDoc);
        $this->assertSame($expectedTagList, $normalizedDoc['tags']);
    }

    public function testShouldAppendParamsDocOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('params', $normalizedDoc));

        $expectedParamsDoc = ['expected-params-doc'];
        $doc2 = new MethodDoc('method-name');
        $doc2->setParamsDoc(new ObjectDoc());
        $this->typeDocNormalizer->normalize($doc2->getParamsDoc())
            ->willReturn($expectedParamsDoc)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('params', $normalizedDoc);
        $this->assertSame($expectedParamsDoc, $normalizedDoc['params']);
    }

    public function testShouldAppendResultDocOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('result', $normalizedDoc));

        $expectedResultDoc = ['expected-result-doc'];
        $doc2 = new MethodDoc('method-name');
        $doc2->setResultDoc(new ObjectDoc());
        $this->typeDocNormalizer->normalize($doc2->getResultDoc())
            ->willReturn($expectedResultDoc)
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('result', $normalizedDoc);
        $this->assertSame($expectedResultDoc, $normalizedDoc['result']);
    }

    public function testShouldAppendCustomErrorListOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('errors', $normalizedDoc));

        $expectedCustomErrorList = [['expected-errors-doc']];
        $error = new ErrorDoc('an-error', 234);
        $doc2 = new MethodDoc('method-name');
        $doc2->addCustomError($error);
        $this->errorDocNormalizer->normalize($error)
            ->willReturn($expectedCustomErrorList[0])
            ->shouldBeCalled()
        ;
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('errors', $normalizedDoc);
        $this->assertSame($expectedCustomErrorList, $normalizedDoc['errors']);
    }

    public function testShouldAppendGlobalErroRefOnlyIfProvided()
    {
        $doc = new MethodDoc('method-name');
        $normalizedDoc = $this->normalizer->normalize($doc);
        $this->assertFalse(array_key_exists('errors', $normalizedDoc));

        $expectedGlobalErrorRefList = ['error-ref'];
        $doc2 = new MethodDoc('method-name');
        $doc2->addGlobalErrorRef($expectedGlobalErrorRefList[0]);
        $normalizedDoc = $this->normalizer->normalize($doc2);
        $this->assertArrayHasKey('errors', $normalizedDoc);
        $this->assertSame(
            array_map(
                function ($val) {
                    return ['$ref' => '#/errors/'.$val];
                },
                $expectedGlobalErrorRefList
            ),
            $normalizedDoc['errors']
        );
    }
}
