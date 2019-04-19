<?php
namespace Tests\Technical\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc
 *
 * @group Models
 */
class ErrorDocTest extends TestCase
{
    /**
     * @dataProvider provideErrorDocIdToNormalize
     *
     * @param string $id
     * @param string $expectedId
     */
    public function testShouldNormalizeIdBy($id, $expectedId)
    {
        $docA = new ErrorDoc('my-title', -235, null, null, $id);
        $this->assertSame($expectedId, $docA->getIdentifier());

        $docB = new ErrorDoc('my-title', -235);
        $docB->setIdentifier($id);
        $this->assertSame($expectedId, $docB->getIdentifier());
    }

    public function provideErrorDocIdToNormalize()
    {
        return [
            'removing spaces' => [
                'id' => 'my custom id',
                'expectedId' => 'MyCustomId'
            ],
            'removing slashes' => [
                'id' => 'Custom/header/id',
                'expectedId' => 'Custom-header-id'
            ],
            'removing anti slashes' => [
                'id' => 'custom\\header\\id',
                'expectedId' => 'Custom_Header_Id'
            ],
            'removing underscores' => [
                'id' => 'my_custom_id',
                'expectedId' => 'MyCustomId'
            ],
            'removing dots' => [
                'id' => 'custom.header.id',
                'expectedId' => 'Custom_Header_Id'
            ],
        ];
    }
}
