<?php

namespace Identicon\Tests\Cell;

use Identicon\Cell\Cell;

class CellTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPositionX()
    {
        $cellA = new Cell(0, 0);
        $this->assertEquals(0, $cellA->getPositionX());

        $cellB = new Cell(1, 0);
        $this->assertEquals(1, $cellB->getPositionX());
    }

    public function testGetPositionY()
    {
        $cellA = new Cell(0, 0);
        $this->assertEquals(0, $cellA->getPositionY());

        $cellB = new Cell(0, 2);
        $this->assertEquals(2, $cellB->getPositionY());
    }

    public function testGetWidth()
    {
        $cellA = new Cell(0, 0);
        $this->assertEquals(10, $cellA->getWidth());

        $cellB = new Cell(1, 1, array("width" => 15));
        $this->assertEquals(15, $cellB->getWidth());
    }

    public function testGetHeight()
    {
        $cellA = new Cell(0, 0);
        $this->assertEquals(10, $cellA->getHeight());

        $cellB = new Cell(0, 0, array("height" => 20));
        $this->assertEquals(20, $cellB->getHeight());

        $cellC = new Cell(0, 0, array("width" => 20));
        $this->assertEquals(20, $cellC->getHeight());
    }

    /**
     * @dataProvider cellInfoNorthProvider
     */
    public function testGetNorth($positionX, $positionY, $options, $expectedX, $expectedY)
    {
        $cellA = new Cell($positionX, $positionY, $options);
        $pointA = $cellA->getNorth();
        $this->assertEquals($expectedX, $pointA->getX());
        $this->assertEquals($expectedY, $pointA->getY());
    }

    public function cellInfoNorthProvider()
    {
        return array(
            array(0, 0, array(), 5, 0),
            array(0, 0, array("width" => 20), 10, 0),
            array(2, 2, array("width" => 30, "height" => 50), (2 * 30) + 15, (2 * 50)),
        );
    }

    /**
     * @dataProvider cellInfoSouthProvider
     */
    public function testGetSouth($positionX, $positionY, $options, $expectedX, $expectedY)
    {
        $cellA = new Cell($positionX, $positionY, $options);
        $pointA = $cellA->getSouth();
        $this->assertEquals($expectedX, $pointA->getX());
        $this->assertEquals($expectedY, $pointA->getY());
    }

    public function cellInfoSouthProvider()
    {
        return array(
            array(0, 0, array(), 5, 10),
            array(0, 0, array("width" => 20), 10, 20),
            array(2, 2, array("width" => 30, "height" => 50), (2 * 30) + 15, (2 * 50) + 50),
        );
    }

    /**
     * @dataProvider cellInfoEastProvider
     */
    public function testGetEast($positionX, $positionY, $options, $expectedX, $expectedY)
    {
        $cellA = new Cell($positionX, $positionY, $options);
        $pointA = $cellA->getEast();
        $this->assertEquals($expectedX, $pointA->getX());
        $this->assertEquals($expectedY, $pointA->getY());
    }

    public function cellInfoEastProvider()
    {
        return array(
            array(0, 0, array(), 10, 5),
            array(0, 0, array("width" => 20), 20, 10),
            array(2, 2, array("width" => 30, "height" => 50), (2 * 30) + 30, (2 * 50) + 25),
        );
    }

    /**
     * @dataProvider cellInfoWestProvider
     */
    public function testGetWest($positionX, $positionY, $options, $expectedX, $expectedY)
    {
        $cell = new Cell($positionX, $positionY, $options);
        $point = $cell->getWest();
        $this->assertEquals($expectedX, $point->getX());
        $this->assertEquals($expectedY, $point->getY());
    }

    public function cellInfoWestProvider()
    {
        return array(
            array(0, 0, array(), 0, 5),
            array(0, 0, array("width" => 20), 0, 10),
            array(2, 2, array("width" => 30, "height" => 50), (2 * 30), (2 * 50) + 25),
        );
    }


    /**
     * @dataProvider getCenterProvider
     */
    public function testGetCenter($positionX, $positionY, $options, $expectedX, $expectedY)
    {
        $cell = new Cell($positionX, $positionY, $options);
        $point = $cell->getCenter();
        $this->assertEquals($expectedX, $point->getX());
        $this->assertEquals($expectedY, $point->getY());
    }

    public function getCenterProvider()
    {
        return array(
            array(0, 0, array(), 5, 5),
            array(0, 0, array("width" => 20), 10, 10),
            array(2, 2, array("width" => 30, "height" => 50), (2 * 30) + 15, (2 * 50) + 25),
        );
    }
}
