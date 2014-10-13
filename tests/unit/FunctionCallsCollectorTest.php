<?php


use tad\Generators\Adapter\Utility\FunctionCallsCollector;

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
     * it should setting a PHPUnit mock object to stub and mock calls
     */
    public function it_should_setting_a_php_unit_mock_object_to_stub_and_mock_calls()
    {
        $sut = new FunctionCallsCollector();
        $mockObject = $this->getMock('stdClass', array('someMethod'));
        $mockObject->expects($this->once())
            ->method('someMethod')
            ->will($this->returnValue('foo'));

        $sut->_setMockObject($mockObject);

        $this->assertSame($mockObject, $sut->_getMockObject());
        $this->assertEquals('foo', $sut->someMethod());
    }

    /**
     * @test
     * it should call the method on the mock object before calling the function
     */
    public function it_should_call_the_method_on_the_mock_object_before_calling_the_function()
    {
        $sut = new FunctionCallsCollector();
        $mockObject = $this->getMock('stdClass', array('array_map'));
        $mockObject->expects($this->any())
            ->method('array_map')
            ->will($this->returnValue('foo'));

        $sut->_setMockObject($mockObject);

        $this->assertEquals('foo', $sut->array_map());
    }

    /**
     * @test
     * it should allow unsetting the mock and having the real function answer
     */
    public function it_should_allow_unsetting_the_mock_and_having_the_real_function_answer()
    {
        $sut = new FunctionCallsCollector();
        $mockObject = $this->getMock('stdClass', array('str_repeat'));
        $mockObject->expects($this->any())
            ->method('str_repeat')
            ->will($this->returnValue('foo'));

        $sut->_setMockObject($mockObject);

        $this->assertEquals('foo', $sut->str_repeat('some', 2));

        $sut->_setMockObject();

        $this->assertEquals('somesome', $sut->str_repeat('some', 2));
    }

    /**
     * @test
     * it should return data about the str_shuffle function
     */
    public function it_should_return_data_about_str_shuffle_function()
    {
        $expected = ['str_shuffle' => [
            'name' => 'str_shuffle',
            'parameters' => [
                'str' => [
                    'type' => false,
                    'isPassedByReference' => false,
                    'name' => 'str',
                    'isOptional' => false,
                    'defaultValue' => false
                ]
            ]
        ]
        ];
        $sut = new FunctionCallsCollector();
        $sut->str_shuffle('some');
        $this->assertEquals($expected, $sut->_getCalled());
    }

    /**
     * @test
     * it should return accurate data about type hinting function
     */
    public function it_should_return_accurate_data_about_type_hinting_function()
    {
        $expected = ['type_hinting_function' => [
            'name' => 'type_hinting_function',
            'parameters' => [
                'object' => [
                    'type' => 'stdClass',
                    'isPassedByReference' => false,
                    'name' => 'object',
                    'isOptional' => false,
                    'defaultValue' => false
                ],
                'array' => [
                    'type' => 'array',
                    'isPassedByReference' => false,
                    'name' => 'array',
                    'isOptional' => true,
                    'defaultValue' => false
                ]
            ]
        ]
        ];
        $sut = new FunctionCallsCollector();
        $sut->type_hinting_function(new stdClass());
        $this->assertEquals($expected, $sut->_getCalled());
    }

    /**
     * @test
     * it should return proper called information for interface type hints
     */
    public function it_should_return_proper_called_information_for_interface_type_hints()
    {
        $expected = ['interface_type_hinting_function' => [
            'name' => 'interface_type_hinting_function',
            'parameters' => [
                'interface' => [
                    'type' => 'Interface2233',
                    'isPassedByReference' => false,
                    'name' => 'interface',
                    'isOptional' => false,
                    'defaultValue' => false
                ]
            ]
        ]
        ];
        $sut = new FunctionCallsCollector();
        $sut->interface_type_hinting_function($this->getMock('Interface2233'));
        $this->assertEquals($expected, $sut->_getCalled());
    }
//    function name_spaced_type_hinting_function(Codeception\PHPUnit\Log $log){

    /**
     * @test
     * it should return proper information about namespace type hinted parameters
     */
    public function it_should_return_proper_information_about_namespace_type_hinted_parameters()
    {
        $expected = ['name_spaced_type_hinting_function' => [
            'name' => 'name_spaced_type_hinting_function',
            'parameters' => [
                'log' => [
                    'type' => 'Codeception\PHPUnit\Log',
                    'isPassedByReference' => false,
                    'name' => 'log',
                    'isOptional' => false,
                    'defaultValue' => false
                ]
            ]
        ]
        ];
        $sut = new FunctionCallsCollector();
        $sut->name_spaced_type_hinting_function($this->getMock('Codeception\PHPUnit\Log'));
        $this->assertEquals($expected, $sut->_getCalled());
    }

    /**
     * @test
     * it should return proper information about int argument functions
     */
    public function it_should_return_proper_information_about_int_argument_functions()
    {
        $expected = ['int_argument_function' => [
            'name' => 'int_argument_function',
            'parameters' => [
                'val' => [
                    'type' => false,
                    'isPassedByReference' => false,
                    'name' => 'val',
                    'isOptional' => true,
                    'defaultValue' => 3
                ]
            ]
        ]
        ];
        $sut = new FunctionCallsCollector();
        $sut->int_argument_function();
        $this->assertEquals($expected, $sut->_getCalled());
    }
}

interface Interface2233{

}

function someMethod()
{
}

function type_hinting_function(stdClass $object, array $array = null)
{
}

function interface_type_hinting_function(Interface2233 $interface){
}

function name_spaced_type_hinting_function(Codeception\PHPUnit\Log $log){

}

function int_argument_function($val = 3){

}
