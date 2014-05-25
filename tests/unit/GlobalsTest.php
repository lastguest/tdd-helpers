<?php
/**
 * GlobalsTest
 */
class GlobalsTest extends \PHPUnit_Framework_TestCase
{
    protected $sut;

    public function setUp()
    {
        $this->sut = new \tad\adapters\Globals();
    }
    public function testWillReturnTheGlobalsArray()
    {
        $r = $this->sut->globals();
        $this->assertSame($GLOBALS,$r);
    }
    public function testWillReturnTheServerArray()
    {
        $r = $this->sut->server();
        $this->assertSame($_SERVER, $r);
    }
    public function testWillReturnTheFooGlobalVariable()
    {
        $GLOBALS['foo'] = 'baz';
        $r = $this->sut->globals('foo');
        $this->assertSame('baz',$r);
    }
}
