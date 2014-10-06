<?php

use tad\DependencyMocker\AdapterClassGenerator;

class AdapterClassGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
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
        $sut->setNamespace('some\namespace');
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
}

function someMethod(array $list, stdClass $object)
{
    // do nothing
}

function noArgs()
{
    // do nothing
}