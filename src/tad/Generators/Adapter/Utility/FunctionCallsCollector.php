<?php
namespace tad\Generators\Adapter\Utility;

class FunctionCallsCollector implements \tad_Adapters_FunctionsInterface
{
    /**
     * @var array
     */
    protected $called;

    /**
     * @var string
     */
    protected $jsonFilePath;

    /**
     * @var bool
     */
    protected $shouldAppend;

    /**
     * @var null|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockObject;

    public function __construct(array $called = null, $jsonFilePath = null, $shoulAppend = false, \PHPUnit_Framework_MockObject_MockObject $mockObject = null)
    {
        $this->called = array();
        $this->jsonFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions_dump' . time();
        $this->shouldAppend = false;
        $this->mockObject = $mockObject ? $mockObject : null;
    }

    public function __call($function, $arguments)
    {
        $reflectionFunction = new \ReflectionFunction($function);
        $this->called[$reflectionFunction->name] = $reflectionFunction;

        $responder = $this->mockObject ? array($this->mockObject, $function) : $function;

        return call_user_func_array($responder, $arguments);
    }

    public function _getCalled()
    {
        return array_values($this->called);
    }

    public function _setJsonFilePath($jsonFilePath)
    {
        if (!is_string($jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        $this->jsonFilePath = $jsonFilePath;
        return $this;
    }

    public function _getJsonFilePath()
    {
        return $this->jsonFilePath;
    }

    public function __destruct()
    {
        $jsonFilePath = $this->jsonFilePath ? $this->jsonFilePath : false;
        if (!$jsonFilePath) {
            return;
        }
        $onFile = $this->shouldAppend ? json_decode(@file_get_contents($this->jsonFilePath)) : array();
        $contents = json_encode(array_merge($onFile, array_keys($this->called)));
        @file_put_contents($this->jsonFilePath, $contents);
    }

    public function _shouldAppend($shouldAppend = true)
    {
        $this->shouldAppend = $shouldAppend ? true : false;
        return $this;
    }

    /**
     * @return null|\PHPUnit_Framework_MockObject_MockObject
     */
    public function _getMockObject()
    {
        return $this->mockObject;
    }

    /**
     * @param null|\PHPUnit_Framework_MockObject_MockObject $mockObject
     */
    public function _setMockObject(\PHPUnit_Framework_MockObject_MockObject $mockObject = null)
    {
        $this->mockObject = $mockObject;
        return $this;
    }

}