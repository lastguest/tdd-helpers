<?php

use Codeception\Platform\Logger;
use tad\Generators\Adapter\Utility\FunctionReflectionCollector;

class FunctionReflectionCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var tad\Generators\Adapter\Utility\FunctionReflectionCollector
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new FunctionReflectionCollector();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should allow setting the list of functions to reflect
     */
    public function it_should_allow_setting_the_list_of_functions_to_reflect()
    {
        $functions = ['str_shuffle'];
        $this->sut->setFunctions($functions);
        $this->assertEquals($functions, $this->sut->getFunctions());
    }

    /**
     * @test
     * it should return a proper array of reflected functions
     */
    public function it_should_return_a_proper_array_of_reflected_functions()
    {
        $expected = ['int_argument_function_23' => [
            'name' => 'int_argument_function_23',
            'parameters' => [
                'val' => [
                    'type' => false,
                    'isPassedByReference' => false,
                    'name' => 'val',
                    'isOptional' => true,
                    'defaultValue' => 3
                ]
            ]
        ],
            'name_spaced_type_hinting_function_23' => [
                'name' => 'name_spaced_type_hinting_function_23',
                'parameters' => [
                    'log' => [
                        'type' => 'Codeception\Platform\Logger',
                        'isPassedByReference' => false,
                        'name' => 'log',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ]
        ];
        $this->sut->setFunctions(['int_argument_function_23', 'name_spaced_type_hinting_function_23']);
        $out = $this->sut->getReflectedFunctionsArray();

        $this->assertEquals($expected, $out);
    }
}

interface Interface2244
{

}

function some_method_3344()
{
}

function type_hinting_function_23(stdClass $object, array $array = null)
{
}

function interface_type_hinting_function_23(Interface2244 $interface)
{
}

function name_spaced_type_hinting_function_23(Logger $log)
{

}

function int_argument_function_23($val = 3)
{

}
