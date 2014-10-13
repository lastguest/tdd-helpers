<?php


use tad\Generators\Adapter\AdapterClassGenerator;

class AdapterClassGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected $jsonFile;
    protected $outputFile;
    protected $jsonExampleSource;

    protected function setUp()
    {
        $this->jsonExampleSource = __DIR__ . '/../_dump/json_example_source.json';

        $this->jsonFile = __DIR__ . '/../_dump/jsonSource.json';
        if (file_exists($this->jsonFile)) {
            unlink($this->jsonFile);
        }

        $this->outputFile = __DIR__ . '/../_dump/adapter.php';
        if (file_exists($this->outputFile)) {
            unlink($this->outputFile);
        }
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should return proper class head markup
     */
    public function it_should_return_proper_class_head_markup()
    {
        $sut = new AdapterClassGenerator();
        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('tad_Adapter_IFunctions');
        $markup = <<< EOC
class SomeClass implements tad_Adapter_IFunctions {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should return proper class head for namespaced class
     */
    public function it_should_return_proper_class_head_for_namespaced_class()
    {
        $sut = new AdapterClassGenerator();
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('tad_Adapter_IFunctions');
        $markup = <<< EOC
namespace some\\namespace;

class SomeClass implements tad_Adapter_IFunctions {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should return proper class head for namespaced interfaces
     */
    public function it_should_return_proper_class_head_for_namespaced_interfaces()
    {
        $sut = new AdapterClassGenerator();
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
namespace some\\namespace;

class SomeClass implements some\\namespace\\Interface {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should append comment before the class head
     */
    public function it_should_append_comment_before_the_class_head()
    {
        $sut = new AdapterClassGenerator();
        $sut->setClassComment('Blah blah');
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
namespace some\\namespace;

/**
 * Blah blah
 */
class SomeClass implements some\\namespace\\Interface {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should allow adding file comments
     */
    public function it_should_allow_adding_file_comments()
    {
        $sut = new AdapterClassGenerator();
        $sut->setFileComment('blah blah');
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
/**
 * blah blah
 */

namespace some\\namespace;

class SomeClass implements some\\namespace\\Interface {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should properly format multi line file comments
     */
    public function it_should_properly_format_multi_line_file_comments()
    {
        $sut = new AdapterClassGenerator();
        $sut->setFileComment("blah\nblah");
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
/**
 * blah
 * blah
 */

namespace some\\namespace;

class SomeClass implements some\\namespace\\Interface {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should properly format multi line class comments
     */
    public function it_should_properly_format_multi_line_class_comments()
    {
        $sut = new AdapterClassGenerator();
        $sut->setClassComment("blah\nblah");
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
namespace some\\namespace;

/**
 * blah
 * blah
 */
class SomeClass implements some\\namespace\\Interface {

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should allow constructing it from a json source file
     */
    public function it_should_allow_constructing_it_from_a_json_source_file()
    {
        $arr = [
            'method_one_2134' => [
                'name' => 'method_one_2134',
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
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ],
            'method_two_2134' => [
                'name' => 'method_two_2134',
                'parameters' => [
                    'string' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'string',
                        'isOptional' => false,
                        'defaultValue' => false
                    ],
                    'integer' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'integer',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ]
        ];
        $sut = AdapterClassGenerator::constructFromJson($this->jsonExampleSource);

        $this->assertInstanceOf('tad\Generators\Adapter\AdapterClassGenerator', $sut);
        $this->assertEquals($arr, $sut->getFunctions());
    }

    /**
     * @test
     * it should add the magic call by default
     */
    public function it_should_add_the_magic_call_by_default()
    {

        $sut = new AdapterClassGenerator();
        $this->assertTrue($sut->willAddMagicCall());
    }

    /**
     * @test
     * it should allow setting if the class should add the magic call
     */
    public function it_should_allow_setting_if_the_class_should_add_the_magic_call()
    {
        $sut = new AdapterClassGenerator();
        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $this->assertFalse($sut->willAddMagicCall());
    }

    /**
     * @test
     * it should return just a magic call adapter if no function is specified
     */
    public function it_should_return_just_a_magic_call_adapter_if_no_function_is_specified()
    {
        $sut = new AdapterClassGenerator();
        $sut->setClassName('SomeClass');
        $markup = <<< EOC
class SomeClass {

    public function __call(\$function, \$args)
    {
        return call_user_func_array(\$function, \$args);
    }

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should allow setting the output file
     */
    public function it_should_allow_setting_the_output_file()
    {
        $sut = new AdapterClassGenerator();
        $sut->setOutputFile($this->outputFile);
        $this->assertEquals($this->outputFile, $sut->getOutputFile());
    }
}

function someMethod(array $list, stdClass $object)
{
    // do nothing
}

function noArgs()
{
    // do nothing
}

function array_func(array &$array)
{

}