<?php

namespace tad\Generators\Base;


use tad\Base\FileWriterInterface;
use tad\Generators\Base\ClassGeneratorInterface;

abstract class ClassGeneratorBase implements ClassGeneratorInterface
{

    /**
     * @var string
     */
    protected $fileComment = '';

    /**
     * @var string
     */
    protected $ns = '';

    /**
     * @var string
     */
    protected $classComment = '';

    /**
     * @var string
     */
    protected $className = '';

    /**
     * @var string
     */
    protected $interfaceName = '';

    /**
     * @var string
     */
    protected $newline = "\n";

    /**
     * @var string
     */
    protected $tab = "\t";

    /**
     * @var string
     */
    protected $outputFilePath;
    /**
     * @var FileWriterInterface
     */
    protected $fileWriter;

    /**
     * @var Smarty
     */
    protected $smarty;

    /**
     * @return Smarty
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

    /**
     * @param Smarty $smarty
     */
    public function setSmarty($smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * @return FileWriterInterface
     */
    public function getFileWriter()
    {
        return $this->fileWriter;
    }

    /**
     * @param FileWriterInterface $fileWriter
     */
    public function setFileWriter(FileWriterInterface $fileWriter)
    {
        $this->fileWriter = $fileWriter;
    }

    /**
     * @param string $className
     * @throws \Exception
     */
    public function setClassName($className = '')
    {
        if (!is_string($className)) {
            throw new \Exception('Class name must be a string');
        }
        $this->className = $className;
    }

    /**
     * @param string $interfaceName
     * @throws \Exception
     */
    public function setInterfaceName($interfaceName = '')
    {
        if (!is_string($interfaceName)) {
            throw new \Exception('Interface name must be a string');
        }
        $this->interfaceName = $interfaceName;
    }

    /**
     * @param string $namespace
     * @throws \Exception
     */
    public function setNamespace($namespace = '')
    {
        if (!is_string($namespace)) {
            throw new \Exception('namespace must be a string');
        }
        $this->ns = ltrim($namespace, '\\');
    }

    /**
     * @param string $classComment
     * @throws \Exception
     */
    public function setClassComment($classComment = '')
    {
        if (!is_string($classComment)) {
            throw new \Exception('Class comment must be a string');
        }
        $this->classComment = $classComment;
    }

    /**
     * @param string $fileComment
     * @throws \Exception
     */
    public function setFileComment($fileComment = '')
    {
        if (!is_string($fileComment)) {
            throw new \Exception('File comment must be a string');
        }
        $this->fileComment = $fileComment;
    }

    /**
     * @param string $filePath
     * @throws \Exception
     */
    public function setOutputFile($filePath = '')
    {
        if (!is_string($filePath)) {
            throw new \Exception('File path should be a string');
        }
        $this->outputFilePath = $filePath;
    }

    /**
     * @return string
     */
    public function getOutputFile()
    {
        return $this->outputFilePath;
    }

    /**
     * Writes the generated class to file.
     *
     * @throws \Exception
     */
    public abstract function generate();

    /**
     * Returns the generated class PHP code.
     *
     * @return string
     */
    public abstract function getClassMarkup();

    /**
     * Returns the string in doc block comment format.
     *
     * @param $string
     * @throws \Exception
     * @throws \SmartyException
     * @return string
     */
    public function getCommentedString($string)
    {
        $this->smarty->assign('comment', $string);
        return $this->smarty->fetch('comment.tpl');
    }
}