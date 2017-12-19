<?php
/**
 * Základní objekty systému.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2009-2016 Vitex@hippy.cz (G)
 */

namespace Test\Ease;

/**
 * Test class for EaseAtom.
 * Generated by PHPUnit on 2012-03-17 at 23:53:07.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2009-2012 Vitex@hippy.cz (G)
 */
class AtomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Atom
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Ease\Atom();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Ease\Atom::getObjectName
     */
    public function testgetObjectName()
    {
        $this->assertNotEmpty($this->object->getObjectName());
    }

    /**
     * @covers Ease\Atom::addStatusMessage
     */
    public function testaddStatusMessage()
    {
        $this->object->cleanMessages();
        $this->object->addStatusMessage(_('Status message add test'), 'info');
        $this->assertNotEmpty($this->object->getStatusMessages());
    }

    /**
     * @covers Ease\Atom::addStatusMessages
     */
    public function testaddstatusMessages()
    {
        $this->object->addStatusMessage('Ok');
        $this->object->addstatusMessages(array('info' => array('test msg 1'), 'debug' => array(
                'test msg 2', )));
        $this->assertArrayHasKey('info', $this->object->getStatusMessages());
        $this->assertNull($this->object->addStatusMessages(false));
    }

    /**
     * @covers Ease\Atom::cleanMessages
     */
    public function testcleanMessages()
    {
        $this->object->addStatusMessage('Clean Test');
        $this->object->CleanMessages();
        $this->assertEmpty($this->object->statusMessages,
            _('Stavové zprávy jsou mazány'));
    }

    /**
     * @covers Ease\Atom::getStatusMessages
     */
    public function testgetstatusMessages()
    {
        $this->object->cleanMessages();
        $this->object->addStatusMessage('Message', 'warning');
        $this->object->addStatusMessage('Message', 'debug');
        $this->object->addStatusMessage('Message', 'error');
        $messages = $this->object->getstatusMessages();
        $this->assertEquals(3, count($messages));

        $this->object->getStatusMessages(true);
        $messages = $this->object->getstatusMessages();
        $this->assertEquals(0, count($messages));
    }

    /**
     * @covers Ease\Atom::takeStatusMessages
     */
    public function testtakestatusMessages()
    {
        $msgSrc = new \Ease\Atom();
        $this->object->cleanMessages();
        $msgSrc->addStatusMessage('testing info message', 'info');
        $msgSrc->addStatusMessage('testing success message', 'success');
        $this->object->takestatusMessages($msgSrc);
        $this->object->takestatusMessages($msgSrc->statusMessages);
        $this->assertArrayHasKey('info', $this->object->getStatusMessages());
    }

    /**
     * @covers Ease\Atom::sysFilename
     */
    public function testsysFilename()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $this->assertContains(
                '\\\\', $this->object->sysFilename('/'),
                _('Windows Files conversion')
            );
        } else {
            $this->assertContains(
                '/', $this->object->sysFilename('\\\\'),
                _('Unix File Conversion')
            );
        }
    }

    /**
     * @covers Ease\Atom::__toString
     */
    public function test__toString()
    {
        $this->assertEmpty($this->object->__toString());
    }

    /**
     * @covers Ease\Atom::draw
     */
    public function testDraw($whatWant = null)
    {
        $this->assertEquals('', $this->object->draw());
    }
}
