<?php
namespace Tests\Functional\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc
 *
 * @group Models
 */
class StringDocTest extends TestCase
{
    public function testShouldManageAFormatNullByDefault()
    {
        $format = 'my-format';
        $doc = new StringDoc();
        $this->assertNull($doc->getFormat());
        $doc->setFormat($format);
        $this->assertSame($format, $doc->getFormat());
    }

    public function testShouldManageAMinLengthNullByDefault()
    {
        $minLength = 12;
        $doc = new StringDoc();
        $this->assertNull($doc->getMinLength());
        $doc->setMinLength($minLength);
        $this->assertSame($minLength, $doc->getMinLength());
    }

    public function testShouldManageAMaxLengthNullByDefault()
    {
        $maxLength = 12;
        $doc = new StringDoc();
        $this->assertNull($doc->getMaxLength());
        $doc->setMaxLength($maxLength);
        $this->assertSame($maxLength, $doc->getMaxLength());
    }
}
