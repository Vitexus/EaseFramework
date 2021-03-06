<?php

namespace Test\Ease\Html;

use Ease\Html\ATag;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:59:15.
 */
class ATagTest extends PairTagTest
{
    /**
     * @var ATag
     */
    protected $object;

    /**
     * What we want to get ?
     * @var string
     */
    public $rendered = '<a href="http://v.s.cz/">Vitex Software</a>';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new \Ease\Html\ATag('http://v.s.cz/', 'Vitex Software');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        
    }

    /**
     * @covers Ease\Html\ATag::tagPropertiesToString
     */
    public function testTagPropertiesToString()
    {
        $this->object->setTagProperties(['id' => 'Test', 'name' => 'unit']);
        $this->assertEquals('href="http://v.s.cz/" id="Test" name="unit"',
            $this->object->tagPropertiesToString());
        $this->assertEquals('id="Test2" name="unit2"',
            $this->object->tagPropertiesToString(['id' => 'Test2', 'name' => 'unit2']));
    }

}
