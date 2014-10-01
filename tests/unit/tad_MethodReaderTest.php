<?php

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
}

class tad_MethodReaderTest extends \PHPUnit_Framework_TestCase
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
        $sut = new tad_MethodReaderImpl('ClassToRead', 'methodB');
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
        $sut = new tad_MethodReaderImpl('ClassToRead', ['methodB', 'methodC']);
        $dependencies = $sut->getDependencies();
        $expected = [
            'stdClass' => ['arg'],
            'ClassToRead' => ['readMe']
        ];
        $this->assertEquals($expected, $dependencies);
    }
}