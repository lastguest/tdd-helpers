<?php


abstract class tad_TestableObject
{

    protected $f;
    protected $g;

    protected static function getMock(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation, $toStubClassName, $alwaysStubMethods = null)
    {
        $mockObject = new tad_MockObject($testCase, get_called_class(), $toStubClassName);
        return $mockObject->getMock($methodNameOrArray, $notation, $alwaysStubMethods);
    }

    public function setFunctionsAdapter(tad_FunctionsAdapter $f = null)
    {
        $this->f = $f ? $f : new tad_FunctionsAdapter();
    }

    public function getFunctionsAdapter()
    {
        return $this->F;
    }

    public function setGlobalsAdapter(tad_GlobalsAdapterInterface $g = null)
    {
        $this->g = $g ? $g : new tad_GlobalsAdapter();
    }

    public function getGlobalsAdapter()
    {
        return $this->g;
    }

    public static function getMockFunctions(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation = null)
    {
        $notation = $notation ? $notation : 'f';
        return self::getMock($testCase, $methodNameOrArray, $notation, 'tad_FunctionsAdapterInterface', array('__call'));
    }

    public static function getMockGlobals(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation = null)
    {
        $notation = $notation ? $notation : 'g';
        return self::getMock($testCase, $methodNameOrArray, $notation, 'tad_GlobalsAdapterInterface', array('__call'));
    }
    public static function getMockFunctionsBuilder(PHPUnit_Framework_TestCase $testCase){
        return new tad_MockObject($testCase, get_called_class(), 'tad_FunctionsAdapterInterface');
    }
    public static function getMockGlobalsBuilder(PHPUnit_Framework_TestCase $testCase){
        return new tad_MockObject($testCase, get_called_class(), 'tad_GlobalsAdapterInterface');
    }
}