<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class TypeDocNormalizerTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideTypeDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideTypeDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new TypeDoc(),
                'expected' => [
                    'type' => 'string',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new TypeDoc())
                    ->setDescription('my-description')
                    ->setDefault(true)
                    ->setExample(false)
                    ->setRequired()
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'string',
                    'nullable' => false,
                    'required' => true,
                    'default' => true,
                    'example' => false,
                ],
            ]
        ];
    }
}
