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

## Changelog
* 2.0.0 - "udpated" the package to be PHP <code>5.2</code> compatible with WordPress minimum requirements
* 1.1.0 - first public release