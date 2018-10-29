<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class ArrayDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideArrayDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideArrayDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new ArrayDoc(),
                'expected' => [
                    'type' => 'array',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new ArrayDoc())
                    ->setRequired()
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['test'])
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'array',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['test'],
                ],
            ],
            'doc with minimum item' => [
                'doc' => (new ArrayDoc())
                    ->setMinItem(4)
                ,
                'expected' => [
                    'type' => 'array',
                    'nullable' => true,
                    'required' => false,
                    'minItem' => 4,
                ],
            ],
            'doc with maximum item' => [
                'doc' => (new ArrayDoc())
                    ->setMaxItem(12)
                ,
                'expected' => [
                    'type' => 'array',
                    'nullable' => true,
                    'required' => false,
                    'maxItem' => 12,
                ],
            ],
            'doc with mandatory siblings' => [
                'doc' => (new ArrayDoc())
                    ->addSibling((new StringDoc()))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                ,
                'expected' => [
                    'type' => 'array',
                    'nullable' => true,
                    'required' => false,
                    'siblings' => [
                        [
                            'type' => 'string',
                            'nullable' => true,
                            'required' => false,
                        ]
                    ],
                    'allowExtra' => true,
                    'allowMissing' => true,
                ],
            ],
            'doc with item validation' => [
                'doc' => (new ArrayDoc())
                    ->setItemValidation(new StringDoc())
                ,
                'expected' => [
                    'type' => 'array',
                    'nullable' => true,
                    'required' => false,
                    'item_validation' => [
                        'type' => 'string',
                        'nullable' => true,
                        'required' => false,
                    ]
                ],
            ],
            'full doc' => [
                'doc' => (new ArrayDoc())
                    ->setMinItem(4)
                    ->setMaxItem(12)
                    ->addSibling((new StringDoc()))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['test'])
                    ->setRequired()
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'array',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['test'],
                    'minItem' => 4,
                    'maxItem' => 12,
                    'siblings' => [
                        [
                            'type' => 'string',
                            'nullable' => true,
                            'required' => false,
                        ]
                    ],
                    'allowExtra' => true,
                    'allowMissing' => true,
                ],
            ]
        ];
    }
}
