<?php

use tad\DependencyMocker\MethodReader;

class ClassToRead
{
    public function methodA()
    {
        echo 'foo';
    }

    public function methodB(stdClass $arg)
    {
        echo $arg->method();
    }

    public function methodC(ClassToRead $readMe)
    {
    }

    public function methodD(ClassToRead $arg1, stdClass $arg2)
    {
    }

    public function methodE(stdClass $arg)
    {
        echo $arg->method();
    }

    public function methodF(stdClass $stdClass1, $someArg, array $arrayArg, stdClass $stdClass2)
    {

    }
}

class MethodReaderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should allow getting a method dependencies
     */
    public function it_should_allow_getting_a_method_dependencies()
    {
        $sut = new MethodReader('ClassToRead', 'methodB');
        $dependencies = $sut->getDependencies();
        $expected = ['stdClass' => ['arg']];
        $this->assertEquals($expected, $dependencies);
    }

    /**
     * @test
     * it should allow getting dependencies of more than one method
     */
    public function it_should_allow_getting_dependencies_of_more_than_one_method()
    {
        $sut = new MethodReader('ClassToRead', ['methodB', 'methodC']);
        $dependencies = $sut->getDependencies();
        $expected = [
            'stdClass' => ['arg'],
            'ClassToRead' => ['readMe']
        ];
        $this->assertEquals($expected, $dependencies);
    }

    /**
     * @test
     * it should return duplicate entries if differently named
     */
    public function it_should_return_duplicate_entries_if_differently_named()
    {
        $sut = new MethodReader('ClassToRead', ['methodB', 'methodC', 'methodD']);
        $dependencies = $sut->getDependencies();
        $expected = [
            'stdClass' => ['arg', 'arg2'],
            'ClassToRead' => ['readMe', 'arg1']
        ];
        $this->assertEquals($expected, $dependencies);
    }

    /**
     * @test
     * it should not return duplicate entries
     */
    public function it_should_not_return_duplicate_entries()
    {
        $sut = new MethodReader('ClassToRead', ['methodB', 'methodB', 'methodB']);
        $dependencies = $sut->getDependencies();
        $expected = [
            'stdClass' => ['arg']
        ];
        $this->assertEquals($expected, $dependencies);
    }

    /**
     * @test
     * it should not return duplicat entried for different methods
     */
    public function it_should_not_return_duplicat_entried_for_different_methods()
    {
        $sut = new MethodReader('ClassToRead', ['methodB', 'methodE']);
        $dependencies = $sut->getDependencies();
        $expected = [
            'stdClass' => ['arg']
        ];
        $this->assertEquals($expected, $dependencies);
    }

    /**
     * @test
     * it should not return scalar or array parameters as dependencies by default
     */
    public function it_should_not_return_scalar_or_array_parameters_as_dependencies_by_default()
    {
//        public function methodF(stdClass $stdClass1, $someArg, array $arrayArg, stdClass $stdClass2){
        $sut = new MethodReader('ClassToRead', ['methodF']);
        $dependencies = $sut->getDependencies();
        $expected = ['stdClass' => ['stdClass1', 'stdClass2']];
        $this->assertEquals($expected, $dependencies);
    }
}