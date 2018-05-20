<?php
namespace Tests\Functional\Domain\Model\Type;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc
 *
 * @group Models
 */
class TypeDocTest extends TestCase
{
    public function testShouldManageANameNullByDefault()
    {
        $name = 'my-name';
        $doc = new TypeDoc();
        $this->assertNull($doc->getName());
        $doc->setName($name);
        $this->assertSame($name, $doc->getName());
    }

    public function testShouldManageADescriptionNullByDefault()
    {
        $description = 'my-description';
        $doc = new TypeDoc();
        $this->assertNull($doc->getDescription());
        $doc->setDescription($description);
        $this->assertSame($description, $doc->getDescription());
    }

    public function testShouldManageARequiredFlagFalseByDefault()
    {
        $doc = new TypeDoc();
        // False by default
        $this->assertFalse($doc->isRequired());
        $doc->setRequired(true);
        $this->assertTrue($doc->isRequired());
    }

    public function testShouldManageANullableFlagTrueByDefault()
    {
        $doc = new TypeDoc();
        // False by default
        $this->assertTrue($doc->isNullable());
        $doc->setNullable(false);
        $this->assertFalse($doc->isNullable());
    }

    public function testShouldManageADefaultValueNullByDefault()
    {
        $value = 'my-value';
        $doc = new TypeDoc();
        $this->assertNull($doc->getDefault());
        $doc->setDefault($value);
        $this->assertSame($value, $doc->getDefault());
    }

    public function testShouldManageAnExampleNullByDefault()
    {
        $value = 'my-value';
        $doc = new TypeDoc();
        $this->assertNull($doc->getExample());
        $doc->setExample($value);
        $this->assertSame($value, $doc->getExample());
    }

    public function testShouldManageAListOfAllowedValues()
    {
        $values = ['my-value', 'my-value-2'];
        $doc = new TypeDoc();
        $doc->addAllowedValue($values[0]);
        $doc->addAllowedValue($values[1]);
        $this->assertSame($values, $doc->getAllowedValueList());
    }
}
