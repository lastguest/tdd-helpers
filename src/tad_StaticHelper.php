<?php

/**
 * Allows for a late static binding workaroung in PHP 5.2
 */
class tad_StaticHelper
{

    /**
     * An associative array of parent to child classes.
     * 
     * The name of the parent class is the key, the name of the chil class is the value. 
     * Will contain values like
     * 
     *     array('parentClass' => 'childClass');
     *
     * @var array
     */
    protected static $classes = array();

    /**
     * Gets the child class extending a specific parent class.
     * 
     * Given a `$classes` array like
     * 
     *     array('parentClass' => 'childClass');
     * 
     * then
     * 
     *     tad_StaticHelper::getClassExtending('parentClass')
     * 
     * will return 'childClass'.
     *
     * @param  string $parentClass The parent class to get the child class for.
     *
     * @return string/null         The name of the child class or null if the parent class has not been registered.
     */
    public static function getClassExtending($parentClass)
    {
        if (!isset(self::$classes[$parentClass])) {
            return null;
        }
        return self::$classes[$parentClass];
    }

    /**
     * Sets the child class extending a specified client class.
     *
     * Please note that no check is made to establish if a child class is
     * an actual extension of the parent class.
     * 
     * @param string $parentClass The name of the parent class to register the child class for.
     * @param string $childClass  The name of the child class extending the parent class.
     */
    public static function setClassExtending($parentClass, $childClass)
    {
        self::$classes[$parentClass] = $childClass;
    }
}
