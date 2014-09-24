# Test-Driven Development Helpers and Adapters

The packages provides two adapters for globally defined functions and variables and a static mocker class.  
The adapters answer to my need for a way to apply TDD techiques to WordPress plugin and theme development. 

## Adapters

### Functions adapter
Wraps call to globally defined functions in a method call. If <code>some_function</code> is a function defined in the global scope then a call to it could be made using the adapter like

    $adapter = new tad_FunctionsAdapter();
    $var = $adapter->some_function();

the adapter uses an interface for more flexible mocking in tests like

    $mockF = $this->getMock('tad_FunctionsAdapterInterface');

### Globals adapter
Allows superglobals to be accessed via an object method fashion.  
Usage example to access <code>$GLOBALS['foo']</code> is

    $g = new tad_GlobalsAdapter();
    $foo = $g->globals('foo');

To get the superglobal array call the function with no arguments, i.e.
to get the <code>$_SERVER</code> array

    $g = new tad_GlobalsAdapter();
    $g->server();

## Static Mocker
A test helper to mock (in a way and with limits) static method calls.  
Tested class should allow for class name injection like

    public function __construct($var1, $var2, $util = 'StaticClass')
    {
        $this->util = $util;

        $var = $this->util::doSomething();
    }

and then in the test file

    class StaticClass extends tad_StaticMocker
    {}


    class ClassNameTest extends \PHPUnit_Framework_TestCase
    {
        public function test_construct_calls_static_class_doSomething()
        {
            // Create a stub for the SomeClass class.
            $stub = $this->getMock('SomeClass');

            // Configure the stub.
            $stub->expects($this->any())
                ->method('doSomething')
                ->will($this->returnValue('foo'));

            StaticClass::_setListener($stub);

            $sut = new ClassName('some', 'var', 'StaticClass');
        }
    }

## Testable objects
The <code>abstract</code> class <code>tad_TestableObject</code> is meant to be used as a parent class to any class that's meant to be built for testing using the <code>tad_FunctionsAdapter</code> and <code>tad_GlobalsAdapater</code> adapter classes.  
Once a class extending it is defined in the code

    class MyObject extends tad_TestableObject{
        ...
    }

then the following testing oriented methods will be available to the class:

* <code>setFunctionsAdapter</code> and <code>getFunctionsAdapter</code> allows injecting and getting the current global functions adapter
* <code>setGlobalsAdapter</code> and <code>getGlobalsAdapter</code> allows injecting and getting the current global variables adapter
* <code>getMockFunctions</code>, a <code>static</code> method, allows getting a <code>tad_FunctionsAdapterInterface</code> mock object tailored on the class methods; specifying a method name, or an array of names, will allow getting a mock with method specific stub methods. The list of <code>tad_FunctionsAdapterInterface</code> methods to stub for each method must be explicitly indicated using the <code>@f</code> notation in the method comment block.
* <code>getMockGlobals</code>, a <code>static</code> method, allows getting a <code>tad_GlobalsAdapterInterface</code> mock object tailored on the class methods; specifying a method name, or an array of names, will allow getting a mock with method specific stub methods. The list of <code>tad_GlobalsAdapterInterface</code> methods to stub for each method must be explicitly indicated using the <code>@g</code> notation in the method comment block.

### Example
Given a class like

    class MyTestableClass extends tad_TestableObject
    {
    
        /**
         * @f functionOne functionTwo
         * @g server
         */
        public function methodOne()
        {
            ...
            $a = $this->f->functionOne();
            ...
            $b = $this->f->functionTwo();
            ...
            $c = $this->g->server('some');
        }

        /**
         * @f functionThree functionFour
         * @g globals
         */
        public function methodTwo()
        {
            ...
            $a = $this->f->functionThree();
            ...
            $b = $this->f->functionFour();
            ...
            $c = $this->g->globals('value');
        }
    }

the class will use the DocBlock to create *ad hoc* mocks during tests and it's meant to be used inside a <code>PHPUnit_Framework_TestCase</code> class definition

    // $mockF will define the stub methods
    //    '__call'
    //    'functionOne'
    //    'functionTwo'
    //    'functionThree'
    //    'functionFour'
    $mockF = MyTestableClass::getMockFunctions($this);

    // $mockG will define the methods
    //    '__call'
    //    'server'
    //    'globals'
    $mockG = MyTestableClass::getMockGlobals($this);

those stubs will then be configurable as any test double produced using the <code>PHPUnit_Framework_TestCase::getMock()</code> method.  
Specifying a method name, or an array of method names, will produce a mock stubbing adapter methods used in the specified methods alone

    // $mockF will define the stub methods
    //    '__call'
    //    'functionOne'
    //    'functionTwo'
    $mockF = MyTestableClass::getMockFunctions($this, 'methodOne');

    // $mockG will define the methods
    //    '__call'
    //    'server'
    $mockG = MyTestableClass::getMockGlobals($this, 'methodOne');
