<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class BooleanDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideBooleanDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideBooleanDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new BooleanDoc(),
                'expected' => [
                    'type' => 'boolean',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new BooleanDoc())
                    ->setRequired()
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault(true)
                    ->setExample(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'boolean',
                    'nullable' => false,
                    'required' => true,
                    'default' => true,
                    'example' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new BooleanDoc())
                    ->setDescription('my-description')
                    ->setDefault(true)
                    ->setExample(false)
                    ->setRequired()
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'boolean',
                    'nullable' => false,
                    'required' => true,
                    'default' => true,
                    'example' => false,
                ],
            ]
        ];
    }
}
