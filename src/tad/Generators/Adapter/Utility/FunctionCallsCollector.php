<?php
namespace tad\Generators\Adapter\Utility;

class FunctionCallsCollector implements \tad_Adapters_FunctionsInterface
{
    /**
     * @var array
     */
    protected $called;

    /**
     * @var string Absolute path to the the json file logged functions will be written to.
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

    /**
     * @param array $called
     * @param null $jsonFilePath
     * @param bool $shoulAppend
     * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
     */
    public function __construct(array $called = null, $jsonFilePath = null, $shoulAppend = false, \PHPUnit_Framework_MockObject_MockObject $mockObject = null)
    {
        $this->called = array();
        $this->shouldAppend = false;
        $this->mockObject = $mockObject ? $mockObject : null;
    }

    /**
     * @param $function
     * @param $arguments
     * @return mixed
     */
    public function __call($function, $arguments)
    {
        $args = \tad_Generators_Adapter_Utility_FunctionDumper::dumpFunction($function);
        $this->called[$args['name']] = $args;

        $responder = $this->mockObject ? array($this->mockObject, $function) : $function;

        return call_user_func_array($responder, $arguments);
    }

    /**
     * @return array The called functions information stored under their name.
     */
    public function _getCalled()
    {
        return $this->called;
    }

    /**
     * @param $jsonFilePath
     * @return $this
     * @throws \Exception
     */
    public function _setJsonFilePath($jsonFilePath)
    {
        if (!is_string($jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        $this->jsonFilePath = $jsonFilePath;
        return $this;
    }

    /**
     * @return string
     */
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
        $onFile = array();
        if ($this->shouldAppend) {
            $onFile = json_decode(@file_get_contents($this->jsonFilePath), true);
        }
        $contents = json_encode(array_merge($onFile, $this->called));
        @file_put_contents($this->jsonFilePath, $contents);
    }

    /**
     * Sets the log to be appended to the previously stored calls
     * in place of overwriting them.
     *
     * @param bool $shouldAppend
     * @return $this
     */
    public function _shouldAppend($shouldAppend = true)
    {
        $this->shouldAppend = $shouldAppend ? true : false;
        return $this;
    }

    /**
     *  Returns the set mock object if any.
     *
     * @return null|\PHPUnit_Framework_MockObject_MockObject
     */
    public function _getMockObject()
    {
        return $this->mockObject;
    }

    /**
     * Sets the mock object that will respond to function calls.
     *
     * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
     * @return $this
     */
    public function _setMockObject(\PHPUnit_Framework_MockObject_MockObject $mockObject = null)
    {
        $this->mockObject = $mockObject;
        return $this;
    }
}