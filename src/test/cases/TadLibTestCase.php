<?php

namespace tad\test\cases;

/**
 * An extended test case to benefit from additional adapters-related
 * methods.
 */
class TadLibTestCase extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Returns a mock of the functions adapter.
     *
     * @param  array  $methods An array containing the methods to mock.
     *
     * @return object          The mocked interface.
     */
    protected function getMockFunctions($methods = array())
    {
        return $this->getMock('\tad\interfaces\FunctionsAdapter', array_merge(array('__call'), $methods));
    }
    
    /**
     * Returns a mock of the global variables adapter.
     *
     * @param  array  $methods An array containing the methods to mock.
     *
     * @return object          The mocked interface.
     */
    protected function getMockGlobals()
    {
        return $this->getMock('\tad\interfaces\GlobalsAdapter');
    }
}
