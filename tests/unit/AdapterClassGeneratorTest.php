<?php

use tad\DependencyMocker\AdapterClassGenerator;

class AdapterClassGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected $jsonFile;
    protected $outputFile;

    protected function setUp()
    {
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
     * it should require constructing it using an array of ReflectionFunction
     */
    public function it_should_require_constructing_it_using_an_array_of_reflection_function()
    {
        $this->setExpectedException('Exception');
        new AdapterClassGenerator();

        $this->setExpectedException('Exception');
        new AdapterClassGenerator(['some', 'foo']);

    }

    /**
     * @test
     * it should return PHP markup for a method calling a function
     */
    public function it_should_return_php_markup_for_a_method_calling_a_function()
    {
        $in = new ReflectionFunction('someMethod');
        $sut = new AdapterClassGenerator();
        $markup = <<<EOC
public function someMethod(array \$list, stdClass \$object){
    return someMethod(\$list, \$object);
}
EOC;
        $this->assertEquals($markup, $sut->getMethodMarkup($in));
    }

    /**
     * @test
     * it should return proper PHP markup for functions with arguments
     */
    public function it_should_return_proper_php_markup_for_functions_with_arguments()
    {
        $in = new ReflectionFunction('someMethod');
        $sut = new AdapterClassGenerator();
        $markup = <<<EOC
public function someMethod(array \$list, stdClass \$object){
    return someMethod(\$list, \$object);
}
EOC;
        $this->assertEquals($markup, $sut->getMethodMarkup($in));
    }

    /**
     * @test
     * it should return proper PHP markup for function with no arguments
     */
    public function it_should_return_proper_php_markup_for_function_with_no_arguments()
    {
        $in = new ReflectionFunction('noArgs');
        $sut = new AdapterClassGenerator();
        $markup = <<<EOC
public function noArgs(){
    return noArgs();
}
EOC;
        $this->assertEquals($markup, $sut->getMethodMarkup($in));
    }

    /**
     * @test
     * it should return proper markup for functions with string arguments
     */
    public function it_should_return_proper_markup_for_functions_with_string_arguments()
    {
        $in = new ReflectionFunction('str_shuffle');
        $sut = new AdapterClassGenerator();
        $markup = <<<EOC
public function str_shuffle(\$str){
    return str_shuffle(\$str);
}
EOC;
        $this->assertEquals($markup, $sut->getMethodMarkup($in));
    }

    /**
     * @test
     * it should return proper markup for functions with scalar arguments
     */
    public function it_should_return_proper_markup_for_functions_with_scalar_arguments()
    {
        $in = new ReflectionFunction('abs');
        $sut = new AdapterClassGenerator();
        $markup = <<<EOC
public function abs(\$number){
    return abs(\$number);
}
EOC;
        $this->assertEquals($markup, $sut->getMethodMarkup($in));
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
     * it should return properly formatted class with one function
     */
    public function it_should_return_properly_formatted_class_with_one_function()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('someMethod')]);
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
namespace some\\namespace;

class SomeClass implements some\\namespace\\Interface {

    public function someMethod(array \$list, stdClass \$object){
        return someMethod(\$list, \$object);
    }

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should return properly formatted class with two functions
     */
    public function it_should_return_properly_formatted_class_with_two_functions()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('someMethod'), new ReflectionFunction('noArgs')]);
        $sut->setNamespace('some\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
namespace some\\namespace;

class SomeClass implements some\\namespace\\Interface {

    public function someMethod(array \$list, stdClass \$object){
        return someMethod(\$list, \$object);
    }

    public function noArgs(){
        return noArgs();
    }

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should properly format a class with comments and methods
     */
    public function it_should_properly_format_a_class_with_comments_and_methods()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('someMethod'), new ReflectionFunction('noArgs')]);
        $sut->setFileComment("some\ncomment");
        $sut->setClassComment("blah\nblah");
        $sut->setNamespace('some\\namespace');

        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $sut->setInterfaceName('some\namespace\Interface');
        $markup = <<< EOC
/**
 * some
 * comment
 */

namespace some\\namespace;

/**
 * blah
 * blah
 */
class SomeClass implements some\\namespace\\Interface {

    public function someMethod(array \$list, stdClass \$object){
        return someMethod(\$list, \$object);
    }

    public function noArgs(){
        return noArgs();
    }

}
EOC;
        $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should properly call functions accepting arguments by reference
     */
    public function it_should_properly_call_functions_accepting_arguments_by_reference()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('array_func')]);
        $sut->setClassName('SomeClass');
        $sut->addMagicCall(false);
        $sut->setClassName('SomeClass');
        $markup = <<< EOC
class SomeClass {

    public function array_func(array &\$array){
        return array_func(\$array);
    }

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
        $functions = ['ucfirst', 'str_shuffle'];
        $expected = array_map(function ($func) {
            return new ReflectionFunction($func);
        }, $functions);
        file_put_contents($this->jsonFile, json_encode($functions));

        $sut = AdapterClassGenerator::constructFromJson($this->jsonFile);

        $this->assertInstanceOf('tad\DependencyMocker\AdapterClassGenerator', $sut);
        $this->assertEquals($expected, $sut->getFunctions());
    }

    /**
     * @test
     * it should skip not defined functions
     */
    public function it_should_skip_not_defined_functions()
    {
        $functions = ['ucfirst', 'str_shuffle', 'non_existing_function'];
        $expected = array_map(function ($func) {
            return new ReflectionFunction($func);
        }, ['ucfirst', 'str_shuffle']);
        file_put_contents($this->jsonFile, json_encode($functions));

        $sut = AdapterClassGenerator::constructFromJson($this->jsonFile);

        $this->assertInstanceOf('tad\DependencyMocker\AdapterClassGenerator', $sut);
        $this->assertEquals($expected, $sut->getFunctions());
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

    public function __call(\$function, \$args){
        return call_user_func_array(\$function, \$args);
    }

}
EOC;
    $this->assertEquals($markup, $sut->getClassMarkup());
    }

    /**
     * @test
     * it should return proper markup for an adapter with functions and magic call
     */
    public function it_should_return_proper_markup_for_an_adapter_with_functions_and_magic_call()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('someMethod')]);
        $sut->setClassName('SomeClass');
        $markup = <<< EOC
class SomeClass {

    public function __call(\$function, \$args){
        return call_user_func_array(\$function, \$args);
    }

    public function someMethod(array \$list, stdClass \$object){
        return someMethod(\$list, \$object);
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
        $this->assertEquals($this->outputFile, $sut->getOuputFile());
    }

    /**
     * @test
     * it should write a class to file
     */
    public function it_should_write_a_class_to_file()
    {
        $sut = new AdapterClassGenerator([new ReflectionFunction('someMethod')]);
        $sut->addMagicCall(true);
        $sut->setClassName('SomeClass');
        $sut->setOutputFile($this->outputFile);

        $contents = <<< EOC
<?php
class SomeClass {

    public function __call(\$function, \$args){
        return call_user_func_array(\$function, \$args);
    }

    public function someMethod(array \$list, stdClass \$object){
        return someMethod(\$list, \$object);
    }

}
EOC;
        $sut->generate();
        $this->assertEquals($contents, file_get_contents($this->outputFile));
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