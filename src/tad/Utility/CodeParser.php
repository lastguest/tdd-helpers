<?php

namespace tad\Utility;


class CodeParser
{

    /**
     * @var string
     */
    protected $variableName;

    /**
     * @var array
     */
    protected $calls;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $callsCount;

    /**
     * @var int
     */
    protected $uniqueCallsCount;

    /**
     * @var int
     */
    protected $dynamicCallsCount;

    /**
     * @var bool
     */
    protected $hasRun;

    public function getCalls($variableName = null)
    {
        if (!is_string($variableName) && !$this->variableName) {
            throw new \Exception('Variable name must be a string');
        }
        $variableName = $variableName ? $variableName : $this->variableName;
        if (!$variableName) {
            throw new \Exception('Variable name not set');
        }
        $this->calls = $this->parseCode();
        $this->hasRun = true;
        return $this->calls;
    }

    public function setVariableName($variableName)
    {
        $this->variableName = $variableName;
    }

    protected function parseCode()
    {
        $matches = $this->getMethodCalls();
        $shouldAddMagicCallMethod = $this->shouldAddMagicCallMethod();
        $matches = empty($matches) ? array() : $matches;
        if ($shouldAddMagicCallMethod) {
            $matches = array_merge(array('__call'), $matches);
        }
        return $matches;
    }

    public function setCode($code)
    {
        if (!is_string($code)) {
            throw new \Exception('Code must be a string');
        }
        $this->hasRun = false;
        $this->code = $code;
    }

    /**
     * @return array
     */
    protected function getMethodCalls()
    {
        $pattern = "/\\\$this->" . $this->variableName . "->([a-zA-Z0-9_]*)\\s*\\(/uU";
        $matches = array();
        preg_match_all($pattern, $this->code, $matches);
        $this->callsCount = isset($matches[1]) ? count($matches[1]) : 0;
        if (!empty($matches)) {
            $matches = array_values(array_unique($matches[1]));
            $this->uniqueCallsCount = $matches ? count($matches) : 0;
            return $matches;
        }
        return $matches;
    }

    /**
     * @return int
     */
    protected function shouldAddMagicCallMethod()
    {
        $matches = array();
        $pattern = "/\\\$this->" . $this->variableName . "->(\\$|\\{).*\\(/uU";
        $addMagicCallMethod = preg_match_all($pattern, $this->code, $matches);
        $this->dynamicCallsCount = isset($matches[1]) ? count($matches[1]) : 0;
        return $addMagicCallMethod;
    }

    public function getCallsCount()
    {
        $this->maybeRun();
        return $this->callsCount + $this->dynamicCallsCount;
    }

    public function getUniqueCallsCount()
    {
        $this->maybeRun();
        return $this->uniqueCallsCount + $this->dynamicCallsCount;
    }

    public function getDynamicCallsCount()
    {
        $this->maybeRun();
        return $this->dynamicCallsCount;
    }

    protected function maybeRun()
    {
        if (!$this->hasRun) {
            $this->getCalls();
        }
    }
}