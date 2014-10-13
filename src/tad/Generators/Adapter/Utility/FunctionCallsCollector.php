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
        $this->shouldAppend = false;
        $this->mockObject = $mockObject ? $mockObject : null;
    }

    public function __call($function, $arguments)
    {
        $reflectionFunction = new \ReflectionFunction($function);

        $name = $reflectionFunction->name;
        $args = array(
            'name' => $name,
            'parameters' => array()
        );

        foreach ($reflectionFunction->getParameters() as $param) {
            $type = $param->getClass() ? $param->getClass()->name : false;
            if (!$type && $param->isArray()) {
                $type = 'array';
            }
            $args['parameters'][$param->name] = array(
                'type' => $type,
                'isPassedByReference' => $param->isPassedByReference(),
                'name' => $param->name,
                'isOptional' => $param->isOptional(),
                'defaultValue' => $param->isDefaultValueAvailable() && $param->getDefaultValue() ? $param->getDefaultValue() : false
            );
        }

        $this->called[$name] = $args;

        $responder = $this->mockObject ? array($this->mockObject, $function) : $function;

        return call_user_func_array($responder, $arguments);
    }

    public function _getCalled()
    {
        return $this->called;
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
        $onFile = array();
        if ($this->shouldAppend) {
            $onFile = json_decode(@file_get_contents($this->jsonFilePath), true);
        }
        $contents = json_encode(array_merge($onFile, $this->called));
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