<?php

use tad\Generators\Adapter\FunctionCallsCollectorGenerator;

class FunctionCallsCollectorGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FunctionCallsCollectorGenerator
     */
    protected $sut;

    protected function strip($markup)
    {
        return preg_replace('/\\s+/', '', $markup);
    }

    protected function setUp()
    {
        $this->sut = new FunctionCallsCollectorGenerator();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should return a plain adapter class if nothing is set
     */
    public function it_should_return_a_plain_adapter_class_if_nothing_is_set()
    {
        $markup = <<< EOC
class CollectorAdapter
{
    protected \$called;
    protected \$jsonFilePath;
    protected \$shouldAppend;

    public function __construct()
    {
        \$this->called = array();
        \$this->jsonFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions_dump' . time();
        \$this->shouldAppend = false;
    }

    public function __call(\$function, \$arguments)
    {
        \$reflectionFunction = new \ReflectionFunction(\$function);
        \$this->called[\$reflectionFunction->name] = \$reflectionFunction;
        return call_user_func_array(\$function, \$arguments);
    }

    public function _getCalled()
    {
        return array_values(\$this->called);
    }

    public function _setJsonFilePath(\$jsonFilePath)
    {
        if (!is_string(\$jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        \$this->jsonFilePath = \$jsonFilePath;
    }

    public function _getJsonFilePath()
    {
        return \$this->jsonFilePath;
    }

    public function __destruct()
    {
        \$jsonFilePath = \$this->jsonFilePath ? \$this->jsonFilePath : false;
        if (!\$jsonFilePath) {
            return;
        }
        \$onFile = \$this->shouldAppend ? json_decode(@file_get_contents(\$this->jsonFilePath)) : array();
        \$contents = json_encode(array_merge(\$onFile, array_keys(\$this->called)));
        @file_put_contents(\$this->jsonFilePath, \$contents);
    }

    public function _shouldAppend(\$shouldAppend = true)
    {
        \$this->shouldAppend = \$shouldAppend ? true : false;
    }

}
EOC;

        $out = $this->strip($this->sut->getClassMarkup());
        $this->assertEquals($this->strip($markup), $out);
    }

    /**
     * @test
     * it should allow setting class name interface and so on
     */
    public function it_should_allow_setting_class_name_interface_and_so_on()
    {
        $this->sut->setFileComment('blah blah');
        $this->sut->setNamespace('my\namespace');
        $this->sut->setClassComment('blah blah');
        $this->sut->setClassName('MyCollector');
        $this->sut->setInterfaceName('myInterface');
        $markup = <<< EOC
/**
 * blah blah
 */

namespace my\\namespace;

/**
 * blah blah
 */
class MyCollector implements myInterface
{
    protected \$called;
    protected \$jsonFilePath;
    protected \$shouldAppend;

    public function __construct()
    {
        \$this->called = array();
        \$this->jsonFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions_dump' . time();
        \$this->shouldAppend = false;
    }

    public function __call(\$function, \$arguments)
    {
        \$reflectionFunction = new \ReflectionFunction(\$function);
        \$this->called[\$reflectionFunction->name] = \$reflectionFunction;
        return call_user_func_array(\$function, \$arguments);
    }

    public function _getCalled()
    {
        return array_values(\$this->called);
    }

    public function _setJsonFilePath(\$jsonFilePath)
    {
        if (!is_string(\$jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        \$this->jsonFilePath = \$jsonFilePath;
    }

    public function _getJsonFilePath()
    {
        return \$this->jsonFilePath;
    }

    public function __destruct()
    {
        \$jsonFilePath = \$this->jsonFilePath ? \$this->jsonFilePath : false;
        if (!\$jsonFilePath) {
            return;
        }
        \$onFile = \$this->shouldAppend ? json_decode(@file_get_contents(\$this->jsonFilePath)) : array();
        \$contents = json_encode(array_merge(\$onFile, array_keys(\$this->called)));
        @file_put_contents(\$this->jsonFilePath, \$contents);
    }

    public function _shouldAppend(\$shouldAppend = true)
    {
        \$this->shouldAppend = \$shouldAppend ? true : false;
    }

}
EOC;

        $out = $this->strip($this->sut->getClassMarkup());
        $this->assertEquals($this->strip($markup), $out);
    }

}