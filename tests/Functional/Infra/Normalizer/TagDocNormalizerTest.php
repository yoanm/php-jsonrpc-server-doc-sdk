<?php
namespace Tests\Functional\Infra\Normalizer;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TagDocNormalizer;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Infra\Normalizer\TagDocNormalizer
 *
 * @group Models
 */
class TagDocNormalizerTest extends TestCase
{
    /** @var TagDocNormalizer */
    private $normalizer;

    public function setUp()
    {
        $this->normalizer = new TagDocNormalizer();
    }

    public function testShouldAtLeastAppendTagName()
    {
        $doc = new TagDoc('tag-name');
        $expected = ['name' => $doc->getName()];

        $this->assertSame($expected, $this->normalizer->normalize($doc));
    }

    public function testShouldAppendDescriptionOnlyIfProvided()
    {
        $doc = new TagDoc('tag-name');
        $expected = ['name' => $doc->getName()];

        $this->assertSame($expected, $this->normalizer->normalize($doc));

        $doc2 = new TagDoc('tag-name');
        $doc2->setDescription('my-description');
        $expected2 = ['name' => $doc2->getName(), 'description' => $doc2->getDescription()];

        $this->assertSame($expected2, $this->normalizer->normalize($doc2));
    }
}
