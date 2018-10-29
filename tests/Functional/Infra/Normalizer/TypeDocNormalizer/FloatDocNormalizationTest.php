<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\FloatDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class FloatDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideFloatDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideFloatDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new FloatDoc(),
                'expected' => [
                    'type' => 'float',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new FloatDoc())
                    ->setRequired()
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault(14.24)
                    ->setExample(255.25)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'float',
                    'nullable' => false,
                    'required' => true,
                    'default' => 14.24,
                    'example' => 255.25,
                ],
            ],
            'doc with min' => [
                'doc' => (new FloatDoc())
                    ->setMin(3.6)
                ,
                'expected' => [
                    'type' => 'float',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3.6,
                    'inclusiveMinimum' => true,
                ],
            ],
            'doc with max' => [
                'doc' => (new FloatDoc())
                    ->setMax(5.2)
                ,
                'expected' => [
                    'type' => 'float',
                    'nullable' => true,
                    'required' => false,
                    'maximum' => 5.2,
                    'inclusiveMaximum' => true,
                ],
            ],
            'doc with exclusive min/max' => [
                'doc' => (new FloatDoc())
                    ->setMin(3.6)
                    ->setInclusiveMin(false)
                    ->setMax(5.2)
                    ->setInclusiveMax(false)
                ,
                'expected' => [
                    'type' => 'float',
                    'nullable' => true,
                    'required' => false,
                    'minimum' => 3.6,
                    'inclusiveMinimum' => false,
                    'maximum' => 5.2,
                    'inclusiveMaximum' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new FloatDoc())
                    ->setDescription('my-description')
                    ->setDefault(14.24)
                    ->setExample(255.25)
                    ->setRequired()
                    ->setNullable(false)
                    ->setMin(3.6)
                    ->setInclusiveMin(false)
                    ->setMax(5.2)
                    ->setInclusiveMax(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'float',
                    'nullable' => false,
                    'required' => true,
                    'default' => 14.24,
                    'example' => 255.25,
                    'minimum' => 3.6,
                    'inclusiveMinimum' => false,
                    'maximum' => 5.2,
                    'inclusiveMaximum' => false,
                ],
            ]
        ];
    }
}
