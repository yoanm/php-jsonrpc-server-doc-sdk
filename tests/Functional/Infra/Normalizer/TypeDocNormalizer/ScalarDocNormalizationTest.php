<?php
namespace Tests\Functional\Infra\Normalizer\TypeDocNormalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer
 *
 * @group Models
 */
class ScalarDocNormalizationTest extends TestCase
{
    /** @var TypeDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TypeDocNormalizer();
    }

    /**
     * @dataProvider provideScalarDocToNormalize
     *
     * @param TypeDoc $doc
     * @param array   $expectedResult
     */
    public function testShouldHandle(TypeDoc $doc, array $expectedResult)
    {
        $this->assertSame($expectedResult, $this->normalizer->normalize($doc));
    }

    public function provideScalarDocToNormalize()
    {
        return [
            'basic doc' => [
                'doc' => new ScalarDoc(),
                'expected' => [
                    'type' => 'scalar',
                    'nullable' => true,
                    'required' => false,
                ],
            ],
            'doc with a description, a default, an example, required flag and not nullable' => [
                'doc' => (new ScalarDoc())
                    ->setRequired(true)
                    ->setNullable(false)
                    ->setDescription('my-description')
                    ->setDefault(true)
                    ->setExample(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'scalar',
                    'nullable' => false,
                    'required' => true,
                    'default' => true,
                    'example' => false,
                ],
            ],
            'full doc' => [
                'doc' => (new ScalarDoc())
                    ->setDescription('my-description')
                    ->setDefault(true)
                    ->setExample(false)
                    ->setRequired(true)
                    ->setNullable(false)
                ,
                'expected' => [
                    'description' => 'my-description',
                    'type' => 'scalar',
                    'nullable' => false,
                    'required' => true,
                    'default' => true,
                    'example' => false,
                ],
            ]
        ];
    }
}
