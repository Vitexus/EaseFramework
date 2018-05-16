<?php

namespace Test\Ease\Html;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:58:47.
 */
class InputTagTest extends TagTest
{
    /**
     * @var InputTag
     */
    protected $object;
    public $rendered = '<input name="test" />';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Ease\Html\InputTag('test');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Ease\Html\InputTag::setValue
     */
    public function testSetValue()
    {
        $this->object->setValue('test');
        $this->assertEquals('test', $this->object->getTagProperty('value'));
    }

    /**
     * @covers Ease\Html\InputTag::getValue
     */
    public function testGetValue()
    {
        $this->object->setValue('test');
        $this->assertEquals($this->object->getValue(),'test' );
    }

    /**
     * @covers Ease\Html\InputTag::getTagName
     */
    public function testGetTagName()
    {
        $this->assertEquals('test', $this->object->getTagName());
        $this->object->setName = true;
        $this->object->setTagName('Test');
        $this->assertEquals('Test', $this->object->getTagName());
    }

    /**
     * 
     * @covers Ease\Html\InputTag::draw
     */
    public function testDraw($whatWant = null)
    {
        parent::testDraw($this->rendered);
    }
}
