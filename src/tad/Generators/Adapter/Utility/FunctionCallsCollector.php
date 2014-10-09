<?php
namespace tad\Generators\Adapter\Utility;

class FunctionCallsCollector implements \tad_Adapters_FunctionsInterface
{
    protected $called;
    protected $jsonFilePath;
    protected $shouldAppend;

    public function __construct()
    {
        $this->called = array();
        $this->jsonFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions_dump' . time();
        $this->shouldAppend = false;
    }

    public function __call($function, $arguments)
    {
        $reflectionFunction = new \ReflectionFunction($function);
        $this->called[$reflectionFunction->name] = $reflectionFunction;
        return call_user_func_array($function, $arguments);
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
    }

}