<?php

namespace Test\Ease;

use Ease\Page;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 23:58:37.
 */
class PageTest extends ContainerTest
{
    /**
     * @var Page
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Page();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Ease\Page::singleton
     */
    public function testSingleton()
    {
        if (get_class($this->object) == 'Ease\Page') {
            $this->assertInstanceOf(get_class($this->object), Page::singleton());
        }
    }

    /**
     * @covers Ease\Page::addJavaScript
     *
     * @todo   Implement testAddJavaScript().
     */
    public function testAddJavaScript()
    {
        $this->object->addJavaScript('alert("hallo");');
        $this->object->addJavaScript('alert("wordld");', false);
    }

    /**
     * @covers Ease\Page::includeJavaScript
     *
     * @todo   Implement testIncludeJavaScript().
     */
    public function testIncludeJavaScript()
    {
        $this->object->includeJavaScript('test.js');
    }

    /**
     * @covers Ease\Page::addCSS
     */
    public function testAddCSS()
    {
        $this->object->addCSS('.test {color:red;}');
    }

    /**
     * @covers Ease\Page::includeCss
     */
    public function testIncludeCss()
    {
        $this->object->includeCss('test.css');
    }

    /**
     * @covers Ease\Page::redirect
     */
    public function testRedirect()
    {
        $this->object->redirect('http://v.s.cz/');
    }

    /**
     * @covers Ease\Page::getUri
     */
    public function testGetUri()
    {
        $_SERVER['REQUEST_URI'] = 'test';
        Page::getUri();
    }

    /**
     * @covers Ease\Page::phpSelf
     */
    public function testPhpSelf()
    {
        Page::phpSelf();
    }

    /**
     * @covers Ease\Page::onlyForLogged
     */
    public function testOnlyForLogged()
    {
        $this->object->onlyForLogged();
    }

    /**
     * @covers Ease\Page::getRequestValues
     */
    public function testGetRequestValues()
    {
        $this->object->getRequestValues();
    }

    /**
     * @covers Ease\Page::isPosted
     */
    public function testIsPosted()
    {
        $_SERVER['REQUEST_METHOD'] = 'test';
        \Ease\Page::isPosted();
    }

    /**
     * @covers Ease\Page::sanitizeAsType
     */
    public function testSanitizeAsType()
    {
        $this->assertInternalType('string',
            $this->object->sanitizeAsType('123', 'string'));
        $this->assertInternalType('integer',
            $this->object->sanitizeAsType('123', 'int'));
        $this->assertInternalType('boolean',
            $this->object->sanitizeAsType('0', 'boolean'));
    }

    /**
     * @covers Ease\Page::getRequestValue
     */
    public function testGetRequestValue()
    {
        $_REQUEST['test'] = 'lala';
        $this->assertEquals('lala', $this->object->getRequestValue('test'));
    }

    /**
     * @covers Ease\Page::getGetValue
     */
    public function testGetGetValue()
    {
        $_GET['test'] = 'lolo';
        $this->assertEquals('lolo', $this->object->getGetValue('test'));
    }

    /**
     * @covers Ease\Page::getPostValue
     */
    public function testGetPostValue()
    {
        $_POST['test'] = 'lili';
        $this->assertEquals('lili', $this->object->getPostValue('test'));
    }

    /**
     * @covers Ease\Page::isFormPosted
     */
    public function testIsFormPosted()
    {
        unset($_POST);
        $this->assertFalse($this->object->isFormPosted());
        $_POST['test'] = 'lili';
        $this->assertTrue($this->object->isFormPosted());
    }

    /**
     * @covers Ease\Page::keepRequestValue
     */
    public function testKeepRequestValue()
    {
        $this->object->keepRequestValue('test');
    }

    /**
     * @covers Ease\Page::keepRequestValues
     */
    public function testKeepRequestValues()
    {
        $this->object->keepRequestValues(['id', 'test']);
    }

    /**
     * @covers Ease\Page::unKeepRequestValue
     */
    public function testUnKeepRequestValue()
    {
        $this->object->unKeepRequestValue('test');
    }

    /**
     * @covers Ease\Page::unKeepRequestValues
     */
    public function testUnKeepRequestValues()
    {
        $this->object->unKeepRequestValues();
    }

    /**
     * @covers Ease\Page::getLinkParametersToKeep
     */
    public function testGetLinkParametersToKeep()
    {
        $this->object->getLinkParametersToKeep();
    }

    /**
     * @covers Ease\Page::setupWebPage
     */
    public function testSetupWebPage()
    {
        $this->object->setupWebPage();
    }

    /**
     * @covers Ease\Page::setOutputFormat
     */
    public function testSetOutputFormat()
    {
        $this->object->setOutputFormat('html');
    }

    /**
     * @covers Ease\Page::getOutputFormat
     */
    public function testGetOutputFormat()
    {
        $this->object->getOutputFormat();
    }

    /**
     * @covers Ease\Page::takeStatusMessages
     */
    public function testTakeStatusMessages()
    {
        $this->object->takeStatusMessages(['info' => ['test', 'test2']]);
    }

    /**
     * @covers Ease\Page::arrayToUrlParams
     */
    public function testArrayToUrlParams()
    {
        $this->object->arrayToUrlParams(['a' => 1, 'b' => 2], 'http://v.s.cz/');
    }
}
