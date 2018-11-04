<?php
namespace Tests\Technical\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc
 *
 * @group Models
 */
class NumberDocTest extends TestCase
{
    /**
     * @dataProvider provideInvalidDocMinMaxValue
     *
     * @param mixed $value
     */
    public function testShouldThrowAnExceptionIfMinIs($value)
    {
        $doc = new NumberDoc();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('min must be either a float or an integer.');
        $doc->setMin($value);
    }

    /**
     * @dataProvider provideValidDocMinMaxValue
     *
     * @param mixed $value
     */
    public function testShouldManageFloatAndIntegerMin($value)
    {
        $doc = new NumberDoc();
        $doc->setMin($value);
        $this->assertSame($value, $doc->getMin());
    }

    /**
     * @dataProvider provideInvalidDocMinMaxValue
     *
     * @param mixed $value
     */
    public function testShouldThrowAnExceptionIfMaxIs($value)
    {
        $doc = new NumberDoc();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('max must be either a float or an integer.');
        $doc->setMax($value);
    }

    /**
     * @dataProvider provideValidDocMinMaxValue
     *
     * @param mixed $value
     */
    public function testShouldManageFloatAndIntegerMax($value)
    {
        $doc = new NumberDoc();
        $doc->setMax($value);
        $this->assertSame($value, $doc->getMax());
    }

    public function provideInvalidDocMinMaxValue()
    {
        return [
            'a boolean' => ['value' => true],
            'null' => ['value' => null],
            'a string' => ['value' => 'string'],
            'an object' => ['value' => new \stdClass()],
        ];
    }

    public function provideValidDocMinMaxValue()
    {
        return [
            'an integer' => ['value' => 12],
            'a float' => ['value' => 1.63],
        ];
    }
}
