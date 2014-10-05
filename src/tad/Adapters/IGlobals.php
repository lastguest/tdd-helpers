<?php
/**
 * Global Variables Adatper interface
 * 
 * The interface is used in the class to allow simple mocking of the class
 * using its interface in tests. PHPUnit mocking, for example:
 * 
 *     $mockG = $this->getMock('tad_Adapters_IGlobals');
 */
interface tad_Adapters_IGlobals
{
    public function __call($name, $args);
}
