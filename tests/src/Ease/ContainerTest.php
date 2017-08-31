<?php

namespace Test\Ease;

use Ease\Container;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:58:14.
 */
class ContainerTest extends SandTest
{
    /**
     * @var Container
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Container();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testConstructor()
    {
        parent::testConstructor();
        $tester = new \Ease\Container('test');
        $this->assertEquals('test', $tester->__toString());
    }

    /**
     * @covers Ease\Container::raise
     */
    public function testRaise()
    {
        $div                   = new \Ease\Html\Div('TestDiv');
        $this->object->webPage = new \Ease\WebPage('toRaise');
        $this->object->raise($div);
        $this->object->raise($div, ['webPage']);
        $this->assertEquals($div->webPage, $this->object->webPage);
    }

    /**
     * @covers Ease\Container::addItemCustom
     */
    public function testAddItemCustom()
    {
        $context = new \Ease\Html\Div();
        Container::addItemCustom('*', $context);
        $this->assertEquals("\n<div>*</div>", $context->getRendered());

        $context = new \Ease\Html\Div();
        Container::addItemCustom(new \Ease\Html\ImgTag(null), $context);
        $this->assertEquals("\n<div>\n<img src=\"\" /></div>",
            $context->getRendered());
    }

    /**
     * @covers Ease\Container::addItem
     */
    public function testAddItem()
    {
        $prober   = new \Ease\Html\H1Tag();
        $inserted = $this->object->addItem($prober);
        $this->assertEquals($inserted, $prober);
        $this->assertEquals($prober, end($this->object->pageParts));
    }

    /**
     * @covers Ease\Container::addAsFirst
     *
     * @todo   Implement testAddAsFirst().
     */
    public function testAddAsFirst()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::suicide
     */
    public function testSuicide()
    {
        $element = new \Ease\Html\DivTag();
        $embeded = $element->addItem($this->object);
        $embeded->suicide();
        $this->assertEmpty($element->pageParts);
    }

    /**
     * @covers Ease\Container::getItemsCount
     */
    public function testGetItemsCount()
    {
        $this->object->emptyContents();
        $this->assertEquals(0, $this->object->getItemsCount());
        $this->object->addItem('@');
        $this->assertEquals(1, $this->object->getItemsCount());
        $this->assertEquals(2,
            $this->object->getItemsCount(new \Ease\Html\Div(['a', 'b'])));
    }

    /**
     * @covers Ease\Container::addNextTo
     *
     * @todo   Implement testAddNextTo().
     */
    public function testAddNextTo()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::lastItem
     *
     * @todo   Implement testLastItem().
     */
    public function testLastItem()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::addToLastItem
     *
     * @todo   Implement testAddToLastItem().
     */
    public function testAddToLastItem()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::getFirstPart
     *
     * @todo   Implement testGetFirstPart().
     */
    public function testGetFirstPart()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::addItems
     *
     * @todo   Implement testAddItems().
     */
    public function testAddItems()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::emptyContents
     */
    public function testEmptyContents()
    {
        $this->object->addItem(new \Ease\Html\DivTag());
        $this->object->emptyContents();
        $this->assertEmpty($this->object->pageParts);
    }

    /**
     * @covers Ease\Container::takeJavascripts
     *
     * @todo   Implement testTakeJavascripts().
     */
    public function testTakeJavascripts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::takeCascadeStyles
     *
     * @todo   Implement testTakeCascadeStyles().
     */
    public function testTakeCascadeStyles()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::drawAllContents
     *
     * @todo   Implement testDrawAllContents().
     */
    public function testDrawAllContents()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::getRendered
     */
    public function testGetRendered()
    {
        $this->object->addItem('*');
        $this->assertNotEmpty($this->object->getRendered());
    }

    /**
     * @covers Ease\Container::showContents
     *
     * @todo   Implement testShowContents().
     */
    public function testShowContents()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::drawIfNotDrawn
     */
    public function testDrawIfNotDrawn($canBeEmpty = false)
    {
        ob_start();
        $this->object->drawIfNotDrawn();
        if ($canBeEmpty || (get_class($this->object) == 'Ease\Container')) {
            $this->markTestSkipped(get_class($this->object).'is Empty');
        } else {
            $out = ob_get_contents();
            $this->assertNotEmpty($out);
        }
        ob_end_clean();
    }

    /**
     * @covers Ease\Container::isFinalized
     */
    public function testIsFinalized()
    {
        $this->assertFalse($this->object->isFinalized());
        $this->object->setFinalized();
        $this->assertTrue($this->object->isFinalized());
    }

    /**
     * @covers Ease\Container::setFinalized
     *
     * @todo   Implement testSetFinalized().
     */
    public function testSetFinalized()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::fillUp
     *
     * @todo   Implement testFillUp().
     */
    public function testFillUp()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::fillMeUp
     *
     * @todo   Implement testFillMeUp().
     */
    public function testFillMeUp()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\Container::isEmpty
     */
    public function testIsEmpty()
    {
        $this->object->emptyContents();
        $this->assertTrue($this->object->isEmpty());
        $this->object->addItem('@');
        $this->assertFalse($this->object->isEmpty($this->object));
    }

    /**
     * @covers Ease\Container::draw
     */
    public function testDraw($whatWant = null)
    {
        ob_start();
        $this->object->draw();
        if (get_class($this->object) == 'Ease\Container') {
            $this->markTestSkipped(get_class($this->object).' is Empty');
        } else {
            $out = ob_get_contents();
            $this->assertNotEmpty($out);
            if (!is_null($whatWant)) {
                $this->assertEquals($whatWant, $out);
            }
        }
        ob_end_clean();
    }

    /**
     * @covers Ease\Container::__toString
     *
     * @todo   Implement test__toString().
     */
    public function test__toString()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
