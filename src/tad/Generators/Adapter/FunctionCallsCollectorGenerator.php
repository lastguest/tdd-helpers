<?php

namespace tad\Generators\Adapter;


use tad\Generators\Adapter\Utility\FileWriter;
use tad\Generators\Base\ClassGeneratorBase;

class FunctionCallsCollectorGenerator extends ClassGeneratorBase
{
    public function __construct(\Smarty $smarty = null, FileWriter $fileWriter = null){
        $this->smarty = $smarty ? $smarty : \tad_Base_SmartyFactory::on(__FILE__);
        $this->fileWriter = $fileWriter ? $fileWriter : null;
    }
    /**
     * Writes the generated class to file.
     *
     * @throws \Exception
     */
    public function generate()
    {
        $class = $this->getClassMarkup();
        $this->smarty->assign('class', $class);
        $contents = $this->smarty->fetch('file.tpl');
        (new FileWriter($this->outputFilePath, $contents))->write();
    }

    /**
     * Returns the generated class PHP code.
     *
     * @return string
     */
    public function getClassMarkup()
    {
        $vars = array(
            'fileComment' => $this->fileComment ? $this->getCommentedString($this->fileComment) : false,
            'namespace' => $this->ns ? $this->ns : false,
            'classComment' => $this->classComment ? $this->getCommentedString($this->classComment) : false,
            'className' => $this->className ? $this->className : 'CollectorAdapter',
            'interfaceName' => $this->interfaceName ? $this->interfaceName : false
        );
        $this->smarty->assign($vars);
        return $this->smarty->fetch('functionsCallCollector.tpl');
    }
}