<?php

use tad\DependencyMocker\FunctionCallsCollector;

class FunctionCallsCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $jsonFile;

    protected function setUp()
    {
        $this->jsonFile = __DIR__ . '/../_dump/jsonSource.json';
        if (file_exists($this->jsonFile)) {
            unlink($this->jsonFile);
        }
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
        $sut = new FunctionCallsCollector();
        $out = $sut->ucfirst('some');

        $this->assertEquals('Some', $out);
    }

    /**
     * @test
     * it should return an array of called reflected functions
     */
    public function it_should_return_an_array_of_called_reflected_functions()
    {
        $sut = new FunctionCallsCollector();
        $sut->ucfirst('some');

        $called = $sut->_getCalled();
        $this->assertEquals([new ReflectionFunction('ucfirst')], $called);
    }

    /**
     * @test
     * it should return an array of unique elements
     */
    public function it_should_return_an_array_of_unique_elements()
    {
        $sut = new FunctionCallsCollector();
        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');

        $called = $sut->_getCalled();
        $this->assertCount(2, $called);
        $expected = [new ReflectionFunction('ucfirst'), new ReflectionFunction('str_shuffle')];
        $this->assertEquals($expected, $called);
    }

    /**
     * @test
     * it should allow setting a source json file
     */
    public function it_should_allow_setting_a_source_json_file()
    {
        $sut = new FunctionCallsCollector();
        $sut->_setJsonFilePath($this->jsonFile);
        $this->assertEquals($this->jsonFile, $sut->_getJsonFilePath());
    }

    /**
     * @test
     * it should write the list of called functions to the file when destructing
     */
    public function it_should_write_the_list_of_called_functions_to_the_file_when_destructing()
    {
        $sut = new FunctionCallsCollector();
        $sut->_setJsonFilePath($this->jsonFile);

        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');
        $sut = null;

        $exp = json_encode(['ucfirst', 'str_shuffle']);
        $this->assertTrue(file_exists($this->jsonFile));
        $this->assertEquals($exp, file_get_contents($this->jsonFile));
    }

    /**
     * @test
     * it should allow appending to a previously existing file
     */
    public function it_should_allow_appending_to_a_previously_existing_file()
    {
        $sut = new FunctionCallsCollector();
        $contents = ['a_function', 'b_function'];
        file_put_contents($this->jsonFile, json_encode($contents));

        $sut->_setJsonFilePath($this->jsonFile);
        $sut->_shouldAppend();

        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->ucfirst('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');
        $sut->str_shuffle('some');
        $sut = null;

        $exp = json_encode(['a_function', 'b_function', 'ucfirst', 'str_shuffle']);
        $this->assertTrue(file_exists($this->jsonFile));
        $this->assertEquals($exp, file_get_contents($this->jsonFile));
    }
}
