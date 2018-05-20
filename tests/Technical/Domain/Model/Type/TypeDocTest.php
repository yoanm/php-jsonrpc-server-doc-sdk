<?php
namespace Tests\Technical\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc
 *
 * @group Models
 */
class TypeDocTest extends TestCase
{
    /**
     * @dataProvider provideInvalidDocNameValue
     */
    public function testShouldThrowAnExceptionIfNameIs($name)
    {
        $doc = new TypeDoc();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('name must be either an integer or a string.');
        $doc->setName($name);
    }

    public function provideInvalidDocNameValue()
    {
        return [
            'a boolean' => ['name' => true],
            'null' => ['name' => null],
            'a float' => ['name' => 1.2],
            'an object' => ['name' => new \stdClass()],
        ];
    }

    public function testShouldManageStringAndIntegerName()
    {
        $stringName = 'string-name';
        $integerName = 12;
        $doc = new TypeDoc();
        $doc->setName($stringName);
        $this->assertSame($stringName, $doc->getName());
        $doc->setName($integerName);
        $this->assertSame($integerName, $doc->getName());
    }
}
