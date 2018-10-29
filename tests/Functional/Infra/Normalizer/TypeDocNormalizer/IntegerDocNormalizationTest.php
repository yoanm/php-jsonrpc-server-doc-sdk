<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\IntegerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class IntegerDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideIntegerDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideIntegerDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new IntegerDoc(),
                'expected' => [
                    'type' => 'integer',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new IntegerDoc())
                    ->setRequired()
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault(24)
                    ->setExample(12)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'integer',
                    'nullable' => false,
                    'required' => true,
                    'default' => 24,
                    'example' => 12,
                ],
            ],
            'doc with min' => [
                'doc' => (new IntegerDoc())
                    ->setMin(3)
                ,
                'expected' => [
                    'type' => 'integer',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3,
                    'inclusiveMinimum' => true,
                ],
            ],
            'doc with max' => [
                'doc' => (new IntegerDoc())
                    ->setMax(5)
                ,
                'expected' => [
                    'type' => 'integer',
                    'nullable' => true,
                    'required' => false,
                    'maximum' => 5,
                    'inclusiveMaximum' => true,
                ],
            ],
            'doc with exclusive min/max' => [
                'doc' => (new IntegerDoc())
                    ->setMin(3)
                    ->setInclusiveMin(false)
                    ->setMax(5)
                    ->setInclusiveMax(false)
                ,
                'expected' => [
                    'type' => 'integer',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3,
                    'inclusiveMinimum' => false,
                    'maximum' => 5,
                    'inclusiveMaximum' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new IntegerDoc())
                    ->setMin(3)
                    ->setInclusiveMin(false)
                    ->setMax(5)
                    ->setInclusiveMax(false)
                    ->setDescription('my-description')
                    ->setDefault(24)
                    ->setExample(12)
                    ->setRequired()
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'integer',
                    'nullable' => false,
                    'required' => true,
                    'default' => 24,
                    'example' => 12,
                    'minimum' => 3,
                    'inclusiveMinimum' => false,
                    'maximum' => 5,
                    'inclusiveMaximum' => false,
                ],
            ]
        ];
    }
}
