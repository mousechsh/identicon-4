<?php

namespace Identicon\Tests\Identity;

use Identicon\Identity\Identity;

class IdentityTest extends \PHPUnit_Framework_TestCase
{
    public function testIdentityLength()
    {
        $identity = new Identity("name");

        $this->assertEquals(5, $identity->getLength());
    }

    public function testIdentityGetPosition()
    {
        $identity = new Identity("name");

        $block00 = $identity->getBlock(0, 0);
        $this->assertInstanceOf("Identicon\Identity\Block", $block00);

        $block22 = $identity->getBlock(2, 2);
        $this->assertInstanceOf("Identicon\Identity\Block", $block22);

        $block44 = $identity->getBlock(4, 4);
        $this->assertInstanceOf("Identicon\Identity\Block", $block44);
    }

    public function outOfBoundsPositionProvider()
    {
        return array(
            array(-1, 0),
            array(0, -1),
            array(5, 0),
            array(0, 5),
        );
    }

    /**
     * @dataProvider outOfBoundsPositionProvider
     * @expectedException \Identicon\Exception\OutOfBoundsException
     */
    public function testIdentityGetOutOfBoundsPosition($posX, $posY)
    {
        $identity = new Identity("name");
        $identity->getBlock($posX, $posY);
    }

    public function testIdentitiesFromDifferentInputs()
    {
        $identity1 = new Identity("myidentity");
        $identity2 = new Identity("youridentity");
        $equalIdentities = $identity1->__toString() ===  $identity2->__toString();

        $this->assertFalse($equalIdentities);
    }

    public function symmetricOutputProvider()
    {
        return array(
            array(0, 0, 4, 0),
            array(1, 0, 3, 0),
            array(0, 1, 4, 1),
            array(1, 1, 3, 1),
            array(0, 2, 4, 2),
            array(1, 2, 3, 2),
            array(0, 3, 4, 3),
            array(1, 3, 3, 3),
            array(0, 4, 4, 4),
            array(1, 4, 3, 4),
        );
    }

    /**
     * @dataProvider symmetricOutputProvider
     */
    public function testSymmetricOutput($leftX, $leftY, $rightX, $rightY)
    {
        $identity = new Identity("myidentity");

        $blockLeft = $identity->getBlock($leftX, $leftY);
        $blockRight = $identity->getBlock($rightX, $rightY);
        $this->assertEquals($blockLeft->isColored(), $blockRight->isColored());
    }

    public function testGetCode()
    {
        $identity = new Identity("myidentity");
        $this->assertInternalType("string", $identity->getCode());
        $this->assertEquals(3, strlen($identity->getCode()));
    }

    public function testIsCaseInsensitive()
    {
        $identityLower = new Identity("myidentity");
        $identityUpperCase = new Identity("MYIDENTITY");
        $this->assertEquals($identityLower->__toString(), $identityUpperCase->__toString());

        $identityCamelCase = new Identity("MyIdentity");
        $this->assertEquals($identityLower->__toString(), $identityCamelCase->__toString());
    }

    public function testIsMultiByteInsensitive()
    {
        $identityLower = new Identity("idëntificaçióñ");
        $identityUpperCase = new Identity("IDËNTIFICAÇIÓÑ");
        $this->assertEquals($identityLower->__toString(), $identityUpperCase->__toString());

        $identityCamelCase = new Identity("IdëntificaÇióñ");
        $this->assertEquals($identityLower->__toString(), $identityCamelCase->__toString());
    }

    public function testGetName()
    {
        $identity = new Identity("myidentity");
        $this->assertEquals("myidentity", $identity->getName());
        $identityCamelCase = new Identity("MyIdentity");
        $this->assertEquals("myidentity", $identityCamelCase->getName());
        $identityComplex = new Identity("IdëntificaÇióñ");
        $this->assertEquals("idëntificaçióñ", $identityComplex->getName());
    }

}
