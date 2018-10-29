<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class ObjectDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideObjectDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideObjectDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new ObjectDoc(),
                'expected' => [
                    'type' => 'object',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new ObjectDoc())
                    ->setRequired(true)
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['sibling-key' => 'test'])
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'object',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['sibling-key' => 'test'],
                ],
            ],
            'doc with minimum item' => [
                'doc' => (new ObjectDoc())
                    ->setMinItem(4)
                ,
                'expected' => [
                    'type' => 'object',
                    'nullable' => true,
                    'required' => false,
                    'min_item' => 4,
                ],
            ],
            'doc with maximum item' => [
                'doc' => (new ObjectDoc())
                    ->setMaxItem(12)
                ,
                'expected' => [
                    'type' => 'object',
                    'nullable' => true,
                    'required' => false,
                    'max_item' => 12,
                ],
            ],
            'doc with mandatory siblings' => [
                'doc' => (new ObjectDoc())
                    ->addSibling((new StringDoc())->setName('sibling-key'))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                ,
                'expected' => [
                    'type' => 'object',
                    'nullable' => true,
                    'required' => false,
                    'siblings' => [
                        'sibling-key' => [
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
                'doc' => (new ObjectDoc())
                    ->setMinItem(4)
                    ->setMaxItem(12)
                    ->addSibling((new StringDoc())->setName('sibling-key'))
                    ->setAllowExtraSibling(true)
                    ->setAllowMissingSibling(true)
                    ->setDescription('my-description')
                    ->setDefault([])
                    ->setExample(['sibling-key' => 'test'])
                    ->setRequired(true)
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'object',
                    'nullable' => false,
                    'required' => true,
                    'default' => [],
                    'example' => ['sibling-key' => 'test'],
                    'min_item' => 4,
                    'max_item' => 12,
                    'siblings' => [
                        'sibling-key' => [
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
