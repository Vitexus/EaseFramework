<?php
declare(strict_types=1);

namespace Test\Ease;

// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-17 at 09:50:39.
 */
class SandTest extends AtomTest
{
    /**
     * @var Sand
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new \Ease\Sand();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        
    }
    /**
     * @covers Ease\Sand::__construct
     */
    public function testConstructor()
    {
        $classname = get_class($this->object);

        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->__construct();

        $this->assertEquals('Ease\Shared', get_class($this->object->easeShared));
        $this->assertEquals('Ease\Logger\Regent',
            get_class($this->object->logger));
        $this->assertEquals('Ease\Sand', $this->object->getObjectName());
        $this->assertEquals(['keyColumn' => 'id'], $this->object->initialIdenty);
    }

    /**
     * @covers Ease\Sand::getStatusMessages
     */
    public function testGetStatusMessages()
    {
        $this->object->addStatusMessage('Message2');
        $this->assertNotEmpty($this->object->getStatusMessages(true));
    }

    /**
     * @covers Ease\Sand::cleanMessages
     */
    public function testCleanMessages()
    {
        $this->object->cleanMessages();
        $this->assertEmpty($this->object->getStatusMessages());
    }

    /**
     * @covers Ease\Sand::setObjectIdentity
     */
    public function testSetObjectIdentity()
    {
        $this->object->setObjectIdentity(['keyColumn' => 'index_key']);
        $this->assertEquals(['keyColumn' => 'id'], $this->object->identity);
    }

    /**
     * @covers Ease\Sand::saveObjectIdentity
     */
    public function testSaveObjectIdentity()
    {
        $this->object->saveObjectIdentity();
        $this->assertEquals(['keyColumn'=>'id'], $this->object->identity);
    }

    /**
     * @covers Ease\Sand::restoreObjectIdentity
     */
    public function testRestoreObjectIdentity()
    {
        $this->object->resetObjectIdentity();
        $this->assertEquals($this->object->initialIdenty, $this->object->identity );
    }

    /**
     * @covers Ease\Sand::resetObjectIdentity
     */
    public function testResetObjectIdentity()
    {
        $this->object->resetObjectIdentity();
        $this->assertEquals($this->object->identity,
            $this->object->initialIdenty);
    }

    /**
     * @covers Ease\Sand::divDataArray
     */
    public function testDivDataArray()
    {
        $sourceArray      = [1 => 'a', 2 => 'b'];
        $destinationArray = [];
        $this->object->divDataArray($sourceArray, $destinationArray, 2);
        $this->assertEquals([2 => 'b'], $destinationArray);
        $this->assertFalse($this->object->divDataArray($sourceArray,
                $destinationArray, 'none'));
    }

    /**
     * @covers Ease\Sand::isAssoc
     */
    public function testIsAssoc()
    {
        $this->assertTrue(\Ease\JQuery\Part::isAssoc(['a' => 'b']));
        $this->assertFalse(\Ease\JQuery\Part::isAssoc(['a', 'b']));
    }

    /**
     * @covers Ease\Sand::getMyKey
     */
    public function testGetMyKey()
    {
        $this->object->setmyKey('test');
        $this->assertEquals('test', $this->object->getmyKey());
        $this->assertEquals('X', $this->object->getmyKey(['id' => 'X']));
    }

    /**
     * @covers Ease\Sand::setMyKey
     */
    public function testSetMyKey()
    {
        $this->object->setmyKey('test');
        $this->assertEquals('test', $this->object->getmyKey());

        $this->object->setkeyColumn(null);
        $this->assertNull($this->object->getmyKey());
    }

    /**
     * @covers Ease\Sand::getkeyColumn
     */
    public function testGetkeyColumn()
    {
        $this->object->setkeyColumn('test');
        $this->assertEquals('test', $this->object->getKeyColumn());
    }

    /**
     * @covers Ease\Sand::setkeyColumn
     */
    public function testSetkeyColumn()
    {
        $this->object->setkeyColumn('test');
        $this->assertEquals('test', $this->object->getKeyColumn());
    }

    /**
     * @covers Ease\Sand::dataReset
     */
    public function testDataReset()
    {
        $this->object->dataReset();
        $this->assertEmpty($this->object->getData());
    }

    /**
     * @covers Ease\Sand::setData
     */
    public function testSetData()
    {
        $this->assertNull($this->object->setData(null));

        $data = ['a' => 1, 'b' => 2];
        $this->object->setData($data, true);
        $this->assertEquals($data, $this->object->getData());
    }

    /**
     * @covers Ease\Sand::getData
     * @depends testSetData
     */
    public function testGetData()
    {
        $data = ['a' => 1, 'b' => 2];
        $this->object->setData($data);
        $this->assertEquals($data, $this->object->getData());
    }

    /**
     * @covers Ease\Sand::getDataCount
     */
    public function testGetDataCount()
    {
        $this->object->dataReset();
        $data = ['a' => 1, 'b' => 2];
        $this->object->setData($data);
        $this->assertEquals(2, $this->object->getDataCount());
    }

    /**
     * @covers Ease\Sand::getDataValue
     */
    public function testGetDataValue()
    {
        $data = ['a' => 1, 'b' => 2];
        $this->object->setData($data);
        $this->assertEquals(2, $this->object->getDataValue('b'));
        $this->assertNull($this->object->getDataValue('c'));
    }

    /**
     * @covers Ease\Sand::setDataValue
     *
     * @todo   Implement testSetDataValue().
     */
    public function testSetDataValue()
    {
        $this->object->setDataValue('c', 3);
        $this->assertEquals(3, $this->object->getDataValue('c'));
    }

    /**
     * @covers Ease\Sand::unsetDataValue
     */
    public function testUnsetDataValue()
    {
        $data = ['a' => 1, 'b' => 2];
        $this->object->setData($data);
        $this->assertTrue($this->object->unsetDataValue('a'));
        $this->assertNull($this->object->getDataValue('a'));
        $this->assertFalse($this->object->unsetDataValue('c'));
    }

    /**
     * @covers Ease\Sand::takeData
     */
    public function testTakeData()
    {
        $data = ['d' => 4, 'e' => 5];
        $this->object->takeData($data);
        $this->assertEquals(5, $this->object->getDataValue('e'));
        $data = ['f' => 6, 'g' => 7];
        $this->object->takeData($data);
        $this->assertEquals(4, $this->object->getDataValue('d'));
    }

    /**
     * @covers Ease\Sand::rip
     */
    public function testRip()
    {
        $this->assertEquals('kuprikladu', $this->object->rip('kupříkladu'));
    }

    /**
     * @covers Ease\Sand::easeEncrypt
     */
    public function testEaseEncrypt()
    {
        $enc = $this->object->easeEncrypt('secret', 'key');
        $this->assertEquals($this->object->easeDecrypt($enc, 'key'), 'secret');
    }

    /**
     * @covers Ease\Sand::easeDecrypt
     */
    public function testEaseDecrypt()
    {
        $enc = $this->object->easeEncrypt('secret', 'key');
        $this->assertEquals($this->object->easeDecrypt($enc, 'key'), 'secret');
    }

    /**
     * @covers Ease\Sand::randomNumber
     */
    public function testRandomNumber()
    {
        $a = $this->object->randomNumber();
        $b = $this->object->randomNumber();
        $this->assertFalse($a == $b);

        $this->assertGreaterThan(9, $this->object->randomNumber(10, 20));
        $this->assertLessThan(21, $this->object->randomNumber(10, 20));
        $this->assertFalse($this->object->randomNumber(30, 20));
    }

    /**
     * @covers Ease\Sand::randomString
     */
    public function testRandomString()
    {
        $a = $this->object->randomString(22);
        $b = $this->object->randomString();
        $this->assertFalse($a == $b);
    }

    /**
     * @covers Ease\Sand::recursiveIconv
     */
    public function testRecursiveIconv()
    {
        $original = ["\x80", "\x95"];
        $exepted  = ["\xe2\x82\xac", "\xe2\x80\xa2"];
        $this->assertEquals($exepted,
            $this->object->recursiveIconv('cp1252', 'utf-8', $original));

        $this->assertEquals($exepted[0],
            $this->object->recursiveIconv('cp1252', 'utf-8', $original[0]));
    }

    /**
     * @covers Ease\Sand::arrayIconv
     */
    public function testArrayIconv()
    {
        $original = "\x80";
        $exepted  = "\xe2\x82\xac";
        $this->object->arrayIconv($original, 0, ['cp1252', 'utf-8']);
        $this->assertEquals($exepted, $original);
    }

    /**
     * @covers Ease\Sand::__sleep
     *
     * @todo   Implement test__sleep().
     */
    public function test__sleep()
    {
        $this->assertTrue(is_array($this->object->__sleep()));
    }

    /**
     * @covers Ease\Sand::humanFilesize
     *
     * @todo   Implement testHumanFilesize().
     */
    public function testHumanFilesize()
    {
        $this->assertEquals('1.18 MB',
            str_replace(',', '.', $this->object->humanFilesize('1234545')));
        $this->assertEquals('11.5 GB',
            str_replace(',', '.', $this->object->humanFilesize('12345453453')));
        $this->assertEquals('1.1 PB',
            str_replace(',', '.',
                $this->object->humanFilesize('1234545345332235')));
        $this->assertEquals('NaN', $this->object->humanFilesize(false));
    }

    /**
     * @covers Ease\Sand::reindexArrayBy
     */
    public function testReindexArrayBy()
    {
        $a = [
            ['id' => '2', 'name' => 'b'],
            ['id' => '1', 'name' => 'a'],
            ['id' => '3', 'name' => 'c'],
        ];
        $c = [
            'a' => ['id' => '1', 'name' => 'a'],
            'b' => ['id' => '2', 'name' => 'b'],
            'c' => ['id' => '3', 'name' => 'c'],
        ];

        $this->assertEquals($c, $this->object->reindexArrayBy($a, 'name'));
    }

    /**
     * @covers Ease\Sand::draw
     */
    public function testDraw($whatWant = null)
    {
        $this->assertEmpty($this->object->draw());
    }

    /**
     * @covers Ease\Sand::isSerialized
     */
    public function testIsSerialized()
    {
        \Ease\Brick::isSerialized('a:6:{s:1:"a";s:6:"string";s:1:"b";i:1;s:1:"c";d:2.4;s:1:"d";i:2222222222222;s:1:"e";O:8:"stdClass":0:{}s:1:"f";b:1;}');
        $this->assertTrue(\Ease\Brick::isSerialized('a:1:{s:4:"test";b:1;'));
        $this->assertFalse(\Ease\Brick::isSerialized('XXXX'));
    }

    /**
     * @covers Ease\Sand::__wakeup
     *
     * @todo   Implement test__wakeup().
     */
    public function test__wakeup()
    {
        $this->object->__wakeup();
        $this->assertNotEmpty($this->object->objectName);
    }
}

// @codeCoverageIgnoreEnd
