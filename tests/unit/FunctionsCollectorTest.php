<?php

use tad\DependencyMocker\FunctionsCollector;

class FunctionsCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should call the global function
     */
    public function it_should_call_the_global_function()
    {
        $sut = new FunctionsCollector();
        $out = $sut->ucfirst('some');

        $this->assertEquals('Some', $out);
    }

    /**
     * @test
     * it should return an array of called reflected functions
     */
    public function it_should_return_an_array_of_called_reflected_functions()
    {
        $sut = new FunctionsCollector();
        $sut->ucfirst('some');

        $called = $sut->getCalled();
        $this->assertEquals([new ReflectionFunction('ucfirst')], $called);
    }

}

function someMethod($arg1)
{
    // do nothing
}