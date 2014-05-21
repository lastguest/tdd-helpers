# Test-Driven Development Helpers and Adapters

The packages provides two adapters for globally defined functions and variables, a PHPUnit test case extension with methods to use those and a static mocker class.

## Adapters

### Functions adapter
Wraps call to globally defined functions in a method call. If <code>some_function</code> is a function defined in the global scope then a call to it could be made using the adapter like

    $adapter = new \tad\adapters\Functions();
    $var = $adapter->some_function();

the adapter uses an interface for more flexible mocking in tests like

    $mockF = $this->getMock('\tad\interfaces\FunctionsAdapter');

### Globals adapter
Allows superglobals to be accessed via an object method fashion.  
Usage example to access <code>$GLOBALS['foo']</code> is

    $g = new \tad\adapters\Globals();
    $foo = $g->globals('foo');

To get the superglobal array call the function with no arguments, i.e.
to get the <code>$_SERVER</code> array

    $g = new \tad\adapters\GlobalsAdapter();
    $g->server();

## Test case
The library packages the <code>\tad\test\cases\TadLibTestCase</code> class, an extension of <code>PHPUnit_Framework_TestCase</code> class, that adds two convenience methods to the test case
    
    // get a mock of the Functions adapter and stub 3 methods
    $mockF = $this->getMockFunctions(array('method1', 'method2', 'method3'));
    
    // get a mock of the Globals adapter
    $mockG = $this->getMockGlobals();

## Static Mocker
A test helper to mock (in a way and with limits) static method calls.  
Tested class should allow for class name injection like

    public function __construct($var1, $var2, $util = '\some\StaticClass')
    {
        $this->util = $util;

        $var = $this->util::doSomething();
    }

and then in the test file

    class StaticClass extends \tad\test\helpers\StaticMocker
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

            $sut = new ClassName('some', 'var', '\StaticClass');
        }
    }
