<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class NumberDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideNumberDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideNumberDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new NumberDoc(),
                'expected' => [
                    'type' => 'number',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new NumberDoc())
                    ->setRequired(true)
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault(24)
                    ->setExample(12)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'number',
                    'nullable' => false,
                    'required' => true,
                    'default' => 24,
                    'example' => 12,
                ],
            ],
            'doc with min' => [
                'doc' => (new NumberDoc())
                    ->setMin(3)
                ,
                'expected' => [
                    'type' => 'number',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3,
                    'inclusiveMinimum' => true,
                ],
            ],
            'doc with max' => [
                'doc' => (new NumberDoc())
                    ->setMax(5)
                ,
                'expected' => [
                    'type' => 'number',
                    'nullable' => true,
                    'required' => false,
                    'maximum' => 5,
                    'inclusiveMaximum' => true,
                ],
            ],
            'doc with exclusive min/max' => [
                'doc' => (new NumberDoc())
                    ->setMin(3)
                    ->setInclusiveMin(false)
                    ->setMax(5)
                    ->setInclusiveMax(false)
                ,
                'expected' => [
                    'type' => 'number',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3,
                    'inclusiveMinimum' => false,
                    'maximum' => 5,
                    'inclusiveMaximum' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new NumberDoc())
                    ->setMin(3)
                    ->setInclusiveMin(false)
                    ->setMax(5)
                    ->setInclusiveMax(false)
                    ->setDescription('my-description')
                    ->setDefault(24)
                    ->setExample(12)
                    ->setRequired(true)
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'number',
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
