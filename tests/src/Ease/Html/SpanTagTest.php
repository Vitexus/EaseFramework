<?php

namespace Test\Ease\Html;

use Ease\Html\SpanTag;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:59:05.
 */
class SpanTagTest extends PairTagTest
{
    /**
     * @var Span
     */
    protected $object;
    public $rendered = '<span></span>';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new SpanTag();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
