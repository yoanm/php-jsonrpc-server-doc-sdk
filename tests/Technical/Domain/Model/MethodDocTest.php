<?php
namespace Tests\Technical\Domain\Model;

use PHPUnit\Framework\TestCase;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;

/**
 * @covers \Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc
 *
 * @group Models
 */
class MethodDocTest extends TestCase
{
    /**
     * @dataProvider provideMethodDocIdToNormalize
     *
     * @param string $id
     * @param string $expectedId
     */
    public function testShouldNormalizeIdBy($id, $expectedId)
    {
        $docA = new MethodDoc('my-title', $id);
        $this->assertSame($expectedId, $docA->getIdentifier());

        $docB = new MethodDoc('my-title');
        $docB->setIdentifier($id);
        $this->assertSame($expectedId, $docB->getIdentifier());
    }

    public function provideMethodDocIdToNormalize()
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
