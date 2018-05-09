<?php

namespace Test\Ease\Html;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:58:51.
 */
class InputHiddenTagTest extends InputTagTest
{
    /**
     * @var InputHiddenTag
     */
    protected $object;
    public $rendered = '<input name="test" type="hidden" />';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Ease\Html\InputHiddenTag('test');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

}
