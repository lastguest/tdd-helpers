<?php

use tad\Utility\CodeParser;
use Way\Tests\Assert;

class ClassParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var tad\Utility\CodeParser
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new CodeParser();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should return a list of functions invoked by the class
     */
    public function it_should_return_a_list_of_functions_invoked_by_the_class()
    {
        $code = <<< EOC
<?php

class ClassA
{
    public \$foo;

    public function methodOne()
    {
        \$this->foo->method_A();
    }

    public function methodTwo()
    {
        \$this->foo->method_A();
    }

    public function methodThree()
    {
        \$this->foo->method_B();
    }

    public function methodFour()
    {
        \$this->foo->method_B();
    }
}
EOC;
        $this->sut->setCode($code);
        $this->sut->setVariableName('foo');
        $calls = ['method_A', 'method_B'];

        $this->assertEquals($calls, $this->sut->getCalls());
    }

    /**
     * @test
     * it should include the __call method in the returned values if dynamic function calls are made
     */
    public function it_should_include_the_call_method_in_the_returned_values_if_dynamic_function_calls_are_made()
    {
        $code = <<< EOC
<?php

class ClassWithDynamicMethodCalls {
protected \$f;

    protected  function callDynamic(){
        \$name = 'foo';
        \$this->f->{'method' . \$name}();
        \$this->f->\$method_name();
        \$this->f->method_A();
        \$this->f->method_B();
    }
}
EOC;

        $this->sut->setCode($code);
        $this->sut->setVariableName('f');
        $calls = ['__call', 'method_A', 'method_B'];
        $this->assertEquals($calls, $this->sut->getCalls());
    }

    /**
     * @test
     * it should allow getting a count of the adapter calls
     */
    public function it_should_allow_getting_a_count_of_the_adapter_calls()
    {
        $code = <<< EOC
<?php

class ClassA
{
    public \$foo;

    public function methodOne()
    {
        \$this->foo->method_A();
    }

    public function methodTwo()
    {
        \$this->foo->method_A();
    }

    public function methodThree()
    {
        \$this->foo->method_B();
    }

    public function methodFour()
    {
        \$this->foo->method_B();
    }
}
EOC;
        $this->sut->setCode($code);
        $this->sut->setVariableName('foo');
        $callsCount = 4;
        $uniqueCallsCount = 2;
        $dynamicCalls = 0;

        $this->assertEquals($callsCount, $this->sut->getCallsCount());
        $this->assertEquals($uniqueCallsCount, $this->sut->getUniqueCallsCount());
        $this->assertEquals($dynamicCalls, $this->sut->getDynamicCallsCount());
    }

    /**
     * @test
     * it should return proper count for classes containing dynamic method calls
     */
    public function it_should_return_proper_count_for_classes_containing_dynamic_method_calls()
    {
        $code = <<< EOC
<?php

class ClassWithDynamicMethodCalls {
protected \$f;

    protected  function callDynamic(){
        \$name = 'foo';
        \$this->f->{'method' . \$name}();
        \$this->f->\$method_name();
        \$this->f->method_A();
        \$this->f->method_B();
    }
}
EOC;

        $this->sut->setCode($code);
        $this->sut->setVariableName('f');

        $callsCount = 4;
        $uniqueCallsCount = 4;
        $dynamicCalls = 2;

        $this->assertEquals($callsCount, $this->sut->getCallsCount());
        $this->assertEquals($uniqueCallsCount, $this->sut->getUniqueCallsCount());
        $this->assertEquals($dynamicCalls, $this->sut->getDynamicCallsCount());
    }
}

