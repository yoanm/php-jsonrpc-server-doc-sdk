<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class StringDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideStringDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideStringDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new StringDoc(),
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new StringDoc())
                    ->setRequired()
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault('my-default')
                    ->setExample('my-example')
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'string',
                    'nullable' => false,
                    'required' => true,
                    'default' => 'my-default',
                    'example' => 'my-example',
                ],
            ],
            'doc with a format' => [
                'doc' => (new StringDoc())
                    ->setFormat('my-format')
                ,
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                    'format' => 'my-format',
                ],
            ],
            'doc with a min length' => [
                'doc' => (new StringDoc())
                    ->setMinLength(6)
                ,
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                    'minLength' => 6,
                ],
            ],
            'doc with a max length' => [
                'doc' => (new StringDoc())
                    ->setMaxLength(6)
                ,
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                    'maxLength' => 6,
                ],
            ],
            'enum doc' => [
                'doc' => (new StringDoc())
                    ->addAllowedValue(124)
                    ->addAllowedValue(324)
                    ->addAllowedValue(541)
                ,
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                    'allowedValues' => [124, 324, 541],
                ],
            ],
            'full doc' => [
                'doc' => (new StringDoc())
                    ->setFormat('my-format')
                    ->setMinLength(6)
                    ->setMaxLength(12)
                    ->setDescription('my-description')
                    ->setDefault('my-default')
                    ->setExample('my-example')
                    ->setRequired()
                    ->addAllowedValue(124)
                    ->addAllowedValue(324)
                    ->addAllowedValue(541)
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'string',
                    'nullable' => false,
                    'required' => true,
                    'default' => 'my-default',
                    'example' => 'my-example',
                    'format' => 'my-format',
                    'allowedValues' => [124, 324, 541],
                    'minLength' => 6,
                    'maxLength' => 12,
                ],
            ]
        ];
    }
}
