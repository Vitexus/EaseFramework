<?php

namespace Test\Ease;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-09-22 at 07:47:58.
 */
class MoleculeTest extends AtomTest
{
    /**
     * @var Molecule
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Ease\Molecule();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Ease\Molecule::setObjectName
     */
    public function testSetObjectName()
    {
        $this->object->setObjectName('Testing');
        $this->assertEquals('Testing', $this->object->getObjectName());
        $this->object->setObjectName();
        $this->assertEquals(get_class($this->object),
            $this->object->getObjectName());
    }

    /**
     * @covers Ease\Molecule::getObjectName
     */
    public function testGetObjectName()
    {
        $this->assertNotEmpty($this->object->getObjectName());
    }

    /**
     * @covers Ease\Molecule::loadConfig
     * @expectedException Ease\Exception
     */
    public function testLoadConfig()
    {
        $this->object->loadConfig('src/molecule.json');
        $this->assertArrayHasKey('opt', $this->object->configuration);
        $this->assertTrue(defined('KEY'));
        $this->object->loadConfig('unexistent.json');
    }

    /**
     * @covers Ease\Molecule::setupProperty
     */
    public function testSetupProperty()
    {
        if (!defined('OBJNAME')) {
            define('OBJNAME', 'CONSTATNT');
        }

        $options                  = ['key' => 'value'];
        $this->object->objectName = 'Original';
        $this->object->setupProperty($options, 'objectName', 'OBJNAME');
        $this->assertEquals('Original', $this->object->objectName);

        $this->object->objectName = null;
        $this->object->setupProperty($options, 'objectName', 'OBJNAME');
        $this->assertEquals('CONSTATNT', $this->object->objectName);

        $options['objectName'] = 'ARRAY';
        $this->object->setupProperty($options, 'objectName', 'OBJNAME');
        $this->assertEquals('ARRAY', $this->object->objectName);
    }
}
