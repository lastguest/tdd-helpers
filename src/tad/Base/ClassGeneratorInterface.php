<?php
/**
 * Created by PhpStorm.
 * User: Luca
 * Date: 08/10/14
 * Time: 15:31
 */

namespace tad\Base;


use tad\Generators\Adapter\Utility\FileWriter;

interface ClassGeneratorInterface {

    public function setClassName($className);

    public function setInterfaceName($interfaceName);

    public function setNamespace($namespace);

    public function setClassComment($classComment);

    public function setFileComment($fileComment);

    public function setOutputFile($filePath);

    public function getOutputFile();

    public function generate();

    /**
     * @param $string
     * @throws \Exception
     * @throws \SmartyException
     * @return string
     */
    public function getCommentedString($string);

    public function getCommentedLines($string);

    public function getClassMarkup();

    public function getMethodMarkup(\ReflectionFunction $method);
}