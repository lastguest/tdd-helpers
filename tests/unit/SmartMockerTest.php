<?php

use PhpParser\Node\Expr\Cast\Int;
use tad\DependencyMocker\SmartMocker;

interface Int1
{
}

class DependencyClass231
{
}

class TestClass231
{

    public function methodOne(stdClass $one, stdClass $two, stdClass $three)
    {

    }
}

class TestClass232
{

    public function __construct(DependencyClass231 $dep231, Int1 $int1)
    {

    }

    public function methodOne(stdClass $one, stdClass $two, stdClass $three)
    {

    }
}

class SmartMockerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }


    /**
     * @test
     * it should retrieve set methods class and argument list
     */
    public function it_should_retrieve_set_methods_class_and_argument_list()
    {
        $deps = ['stdClass' => ['one', 'two', 'three']];
        $methodReader = $this->getMockBuilder('\tad\DependencyMocker\IMethodReader')
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setMethodName', 'setClassName', 'getDependencies'))
            ->getMock();
        $methodReader->expects($this->once())
            ->method('getDependencies')
            ->will($this->returnValue($deps));

        $sut = new SmartMocker('TestClass231', array('methodOne'), null, $methodReader);

        $sut->getMocks();
    }

    /**
     * @test
     * it should return a mock for each dependency named as the arg name
     */
    public function it_should_return_a_mock_for_each_dependency_named_as_the_arg_name()
    {
        $deps = ['stdClass' => ['one', 'two', 'three']];
        $methodReader = $this->getMockBuilder('\tad\DependencyMocker\IMethodReader')
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setMethodName', 'setClassName', 'getDependencies'))
            ->getMock();
        $methodReader->expects($this->once())
            ->method('getDependencies')
            ->will($this->returnValue($deps));

        $sut = new SmartMocker('TestClass231', array('methodOne'), null, $methodReader);

        extract($sut->getMocksArray());
        $this->assertNotNull($one);
        $this->assertInstanceOf('stdClass', $one);
        $this->assertNotNull($two);
        $this->assertInstanceOf('stdClass', $two);
        $this->assertNotNull($three);
        $this->assertInstanceOf('stdClass', $three);
    }

    /**
     * @test
     * it should allow specifying extra methods
     */
    public function it_should_allow_specifying_extra_methods()
    {
        $deps = ['stdClass' => ['one', 'two', 'three']];
        $methodReader = $this->getMockBuilder('\tad\DependencyMocker\IMethodReader')
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setMethodName', 'setClassName', 'getDependencies'))
            ->getMock();
        $methodReader->expects($this->once())
            ->method('getDependencies')
            ->will($this->returnValue($deps));

        $sut = new SmartMocker('TestClass231', array('methodOne'), array('stdClass' => array('methodFoo', 'methodBaz')), $methodReader);

        extract($sut->getMocksArray());

        $this->assertTrue(method_exists($one, 'methodFoo'));
        $this->assertTrue(method_exists($one, 'methodBaz'));
        $this->assertTrue(method_exists($two, 'methodFoo'));
        $this->assertTrue(method_exists($two, 'methodBaz'));
        $this->assertTrue(method_exists($three, 'methodFoo'));
        $this->assertTrue(method_exists($three, 'methodBaz'));
    }

    /**
     * @test
     * it should mock constructor method parameters by default
     */
    public function it_should_mock_constructor_method_parameters_by_default()
    {
//        public function __construct(DependencyClass231 $dep231, Int1 $int1)
//        public function methodOne(stdClass $one, stdClass $two, stdClass $three)


        $deps = [
            'DependencyClass231' => ['dep231'],
            'Int1' => ['int1'],
            'stdClass' => ['one', 'two', 'three']
        ];
        $methodReader = $this->getMockBuilder('\tad\DependencyMocker\IMethodReader')
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setMethodName', 'setClassName', 'getDependencies'))
            ->getMock();
        $methodReader->expects($this->once())
            ->method('setMethodName')
            ->with(['__construct', 'methodOne']);
        $methodReader->expects($this->once())
            ->method('getDependencies')
            ->will($this->returnValue($deps));

        $sut = new SmartMocker('TestClass232', array('methodOne'), null, $methodReader);

        extract($sut->getMocksArray());

        $this->assertNotNull($dep231);
        $this->assertInstanceOf('DependencyClass231', $dep231);
        $this->assertNotNull($int1);
        $this->assertInstanceOf('Int1', $int1);
        $this->assertNotNull($one);
        $this->assertInstanceOf('stdClass', $one);
        $this->assertNotNull($two);
        $this->assertInstanceOf('stdClass', $two);
        $this->assertNotNull($three);
        $this->assertInstanceOf('stdClass', $three);
    }

    /**
     * @test
     * it should mock constructor dependencies if __construct method is a target method
     */
    public function it_should_mock_constructor_dependencies_if_construct_method_is_a_target_method()
    {
        $deps = [
            'DependencyClass231' => ['dep231'],
            'Int1' => ['int1'],
            'stdClass' => ['one', 'two', 'three']
        ];
        $methodReader = $this->getMockBuilder('\tad\DependencyMocker\IMethodReader')
            ->disableOriginalConstructor()
            ->setMethods(array('__construct', 'setMethodName', 'setClassName', 'getDependencies'))
            ->getMock();
        $methodReader->expects($this->once())
            ->method('getDependencies')
            ->will($this->returnValue($deps));

        $sut = new SmartMocker('TestClass232', array('__construct', 'methodOne'), null, $methodReader);

        extract($sut->getMocksArray());
//     public function __construct(DependencyClass231 $dep231, Int1 $int1)
//     public function methodOne(stdClass $one, stdClass $two, stdClass $three)
        $this->assertNotNull($dep231);
        $this->assertInstanceOf('DependencyClass231', $dep231);
        $this->assertNotNull($int1);
        $this->assertInstanceOf('Int1', $int1);
        $this->assertNotNull($one);
        $this->assertInstanceOf('stdClass', $one);
        $this->assertNotNull($two);
        $this->assertInstanceOf('stdClass', $two);
        $this->assertNotNull($three);
        $this->assertInstanceOf('stdClass', $three);
    }
}