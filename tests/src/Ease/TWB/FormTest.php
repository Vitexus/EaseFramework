<?php

namespace Test\Ease\TWB;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:59:46.
 */
class FormTest extends \Test\Ease\Html\FormTest
{
    /**
     * @var Form
     */
    protected $object;
    public $rendered = '<form method="post" name="form" class="form-horizontal" role="form"></form>';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Ease\TWB\Form('form');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Ease\TWB\Form::addInput
     *
     * @todo   Implement testAddInput().
     */
    public function testAddInput()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\TWB\Form::addItem
     *
     * @todo   Implement testAddItem().
     */
    public function testAddItem()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Ease\TWB\Form::getTagName
     */
    public function testGetTagName()
    {
        $this->assertEquals('form', $this->object->getTagName());
    }
}
