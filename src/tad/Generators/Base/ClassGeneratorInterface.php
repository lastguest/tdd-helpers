<?php

namespace tad\Generators\Base;

interface ClassGeneratorInterface {

    /**
     * @param string $className
     */
    public function setClassName($className);

    /**
     * @param string $interfaceName
     */
    public function setInterfaceName($interfaceName);

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace);

    /**
     * @param string $classComment
     */
    public function setClassComment($classComment);

    /**
     * @param string $fileComment
     */
    public function setFileComment($fileComment);

    /**
     * @param string $filePath
     */
    public function setOutputFile($filePath);

    /**
     * @return string
     */
    public function getOutputFile();

    /**
     * Writes the class to file.
     */
    public function generate();

    /**
     * Returns the strin in PHP comment format.
     *
     * @param $string
     * @return string
     */
    public function getCommentedString($string);

    /**
     * Return the PHP code for the generated class.
     *
     * @return string
     */
    public function getClassMarkup();
}