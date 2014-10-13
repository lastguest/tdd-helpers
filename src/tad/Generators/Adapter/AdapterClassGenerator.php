<?php

namespace tad\Generators\Adapter;


use tad\Generators\Adapter\Utility\FileWriter;
use tad\Generators\Base\ClassGeneratorBase;

class AdapterClassGenerator extends ClassGeneratorBase
{
    protected $functions;
    protected $addMagicCall = true;

    /**
     * @param array $functions
     * @param \Smarty $smarty
     * @param FileWriter $fileWriter
     * @throws \Exception If an element of the `functions` array is not a ReflectionFunction instance.
     */
    public function __construct(array $functions = null, \Smarty $smarty = null, FileWriter $fileWriter = null)
    {
        $this->functions = $functions ? $functions : array();
        $this->smarty = $smarty ? $smarty : \tad_Base_SmartyFactory::on(__FILE__);
        $this->fileWriter = $fileWriter ? $fileWriter : null;
    }

    /**
     * Returns an instance built on the functions defined in the json file.
     *
     * @param $jsonFilePath
     * @return AdapterClassGenerator
     * @throws \Exception If the json file is not string, doesn't exist or the stored value is not an array.
     */
    public static function constructFromJson($jsonFilePath)
    {
        if (!is_string($jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        if (!file_exists($jsonFilePath)) {
            throw new \Exception('Json file does not exist');
        }
        $functions = json_decode(file_get_contents($jsonFilePath), true);
        if (!is_array($functions)) {
            throw new \Exception('Value stored in json file must be an array');
        }
        return new self($functions);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @return bool
     */
    public function willAddMagicCall()
    {
        return $this->addMagicCall;
    }

    /**
     * @param bool $toggle
     */
    public function addMagicCall($toggle = true)
    {
        $this->addMagicCall = $toggle ? true : false;
    }

    /**
     * Returns the PHP code for an adapter class wrapping specified functions.
     *
     * @return string
     * @throws \Exception
     * @throws \SmartyException
     */
    public function getClassMarkup()
    {
        $vars = array(
            'fileComment' => $this->fileComment ? $this->getCommentedString($this->fileComment) : false,
            'namespace' => $this->ns ? sprintf('namespace %s;', $this->ns) : false,
            'classComment' => $this->classComment ? $this->getCommentedString($this->classComment) : false,
            'className' => $this->className,
            'interface' => $this->interfaceName ? $this->interfaceName : false,
            'magicCall' => $this->addMagicCall ? $this->getMagicCallMarkup() : false,
            'methods' => $this->getMethodsMarkup()
        );

        $this->smarty->assign($vars);
        return $this->smarty->fetch('class.tpl');
    }

    protected function getMagicCallMarkup()
    {
        return $this->smarty->fetch('method_call.tpl');
    }

    protected function getMethodsMarkup(array $functions = null)
    {
        $functions = $functions ? $functions : $this->functions;
        if (!$functions) {
            return false;
        }
        $methods = array_map(function ($function) {
            return $this->getMethodMarkup($function);
        }, $functions);
        return implode($this->newline, $methods);
    }

    /**
     * Returns the PHP code for a method wrapping a function.
     *
     * @param \ReflectionFunction $function
     * @return string
     * @throws \Exception
     * @throws \SmartyException
     */
    public function getMethodMarkup(array $function)
    {
        $vars = array(
            'methodName' => $function['name'],
            'signatureArgsString' => $this->getSignatureArgsString($function['parameters']),
            'callArgsString' => $this->getCallArgsString($function['parameters'])
        );
        $this->smarty->assign($vars);
        return $this->smarty->fetch('method_common.tpl');
    }

    protected function getSignatureArgsString(array $function)
    {
        $argsStrings = array_map(function ($parameter) {
            $typeHintedClass = $parameter['type'] ? $parameter['type'] . ' ' : '';
            $reference = $parameter['isPassedByReference'] ? '&' : '';
            $optionalOrDefaultValue = $parameter['isOptional'] ? ' = null' : ' = ' . $parameter['defaultValue'];
            return sprintf('%s%s$%s%s', $typeHintedClass, $reference, $parameter->name, $optionalOrDefaultValue);
        }, $function['parameters']);
        return implode(', ', $argsStrings);
    }

    protected function getCallArgsString(array $function)
    {
        $callArgs = array_map(function ($parameter) {
            return sprintf('$%s', $parameter['name']);
        }, $function['parameters']);
        $callArgs = implode(', ', $callArgs);
        return $callArgs;
    }

    /**
     * Writes the generated class to file.
     *
     * @throws \Exception
     */
    public function generate()
    {
        if (!$this->outputFilePath) {
            throw new \Exception('Output file is not set');
        }
        $vars = array(
            'class' => $this->getClassMarkup()
        );
        $this->smarty->assign($vars);
        $contents = $this->smarty->fetch('file.tpl');
        if (!$this->fileWriter) {
            $this->fileWriter = new FileWriter($this->outputFilePath, $contents);
        }
        $this->fileWriter->write();
    }
}