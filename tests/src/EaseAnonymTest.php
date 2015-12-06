<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-07-19 at 00:35:22.
 *
 * @backupGlobals disabled
 */
class EaseAnonymTest extends PHPUnit_Framework_TestCase
{

    protected $backupGlobalsBlacklist = array('_SERVER');

    /**
     * @var Ease\Anonym
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $_SERVER['REMOTE_USER'] = 'Tester';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $this->object = new Ease\Anonym;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers EaseAnonym::setObjectName
     */
    public function testSetObjectName()
    {
        $this->assertEquals('EaseAnonym@127.0.0.1 [Tester]', $this->object->getObjectName());

        $this->object->setObjectName('Tested');
        $this->assertEquals('Tested', $this->object->getObjectName());
    }

    /**
     * @covers EaseAnonym::getUserLevel
     */
    public function testGetUserLevel()
    {
        $this->assertEquals(-1, $this->object->getUserLevel());
    }

    /**
     * @covers EaseAnonym::getUserID
     */
    public function testGetUserID()
    {
        $this->assertNull($this->object->getUserID());
    }

    /**
     * @covers EaseAnonym::getUserLogin
     */
    public function testGetUserLogin()
    {
        $this->assertNull($this->object->getUserLogin());
    }

    /**
     * @covers EaseAnonym::isLogged
     */
    public function testIsLogged()
    {
        $this->assertFalse($this->object->isLogged());
    }

    /**
     * @covers EaseAnonym::getSettingValue
     */
    public function testGetSettingValue()
    {
        $this->assertNull($this->object->getSettingValue('null'));
    }

    /**
     * @covers EaseAnonym::getUserEmail
     */
    public function testGetUserEmail()
    {
        $this->assertNull($this->object->getUserEmail());
    }

    /**
     * @covers EaseAnonym::getPermission
     */
    public function testGetPermission()
    {
        $this->assertNull($this->object->getPermission('admin'));
    }

    /**
     * @covers EaseAnonym::logout
     */
    public function testLogout()
    {
        $this->assertTrue($this->object->logout());
    }

}
