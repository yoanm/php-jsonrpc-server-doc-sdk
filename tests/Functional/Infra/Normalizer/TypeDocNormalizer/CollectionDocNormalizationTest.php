<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class CollectionDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideCollectionDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideCollectionDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new CollectionDoc(),
                'expected' => [
                    'type' => 'collection',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new CollectionDoc())
                    ->setRequired(true)
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['test'])
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'collection',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['test'],
                ],
            ],
            'doc with minimum item' => [
                'doc' => (new CollectionDoc())
                    ->setMinItem(4)
                ,
                'expected' => [
                    'type' => 'collection',
                    'nullable' => true,
                    'required' => false,
                    'min_item' => 4,
                ],
            ],
            'doc with maximum item' => [
                'doc' => (new CollectionDoc())
                    ->setMaxItem(12)
                ,
                'expected' => [
                    'type' => 'collection',
                    'nullable' => true,
                    'required' => false,
                    'max_item' => 12,
                ],
            ],
            'doc with mandatory siblings' => [
                'doc' => (new CollectionDoc())
                    ->addSibling((new StringDoc()))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                ,
                'expected' => [
                    'type' => 'collection',
                    'nullable' => true,
                    'required' => false,
                    'siblings' => [
                        [
                            'type' => 'string',
                            'nullable' => true,
                            'required' => false,
                        ]
                    ],
                    'allow_extra' => true,
                    'allow_missing' => true,
                ],
            ],
            'full doc' => [
                'doc' => (new CollectionDoc())
                    ->setMinItem(4)
                    ->setMaxItem(12)
                    ->addSibling((new StringDoc()))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['test'])
                    ->setRequired(true)
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'collection',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['test'],
                    'min_item' => 4,
                    'max_item' => 12,
                    'siblings' => [
                        [
                            'type' => 'string',
                            'nullable' => true,
                            'required' => false,
                        ]
                    ],
                    'allow_extra' => true,
                    'allow_missing' => true,
                ],
            ]
        ];
    }
}
