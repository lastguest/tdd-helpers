<?php

namespace tad\Generators\Adapter;


use tad\Base\ClassGeneratorBase;
use tad\Generators\Adapter\Utility\FileWriter;

class AdapterClassGenerator extends ClassGeneratorBase
{
    protected $functions;
    protected $addMagicCall = true;

    public function __construct(array $functions = null, \Smarty $smarty = null, FileWriter $fileWriter = null)
    {
        if (is_array($functions)) {
            array_walk($functions, function ($el, $index) {
                if (!is_a($el, 'ReflectionFunction')) {
                    throw new \Exception("All array elements should be ReflectionFunction instances, $index is not");
                }
            });
            $this->functions = $functions;
        }

        $this->smarty = $smarty ? $smarty : \tad_Base_SmartyFactory::on(__FILE__);
        $this->fileWriter = $fileWriter ? $fileWriter : null;
    }

    public static function constructFromJson($jsonFilePath)
    {
        if (!is_string($jsonFilePath)) {
            throw new \Exception('Json file path must be a string');
        }
        if (!file_exists($jsonFilePath)) {
            throw new \Exception('Json file does not exist');
        }
        $functions = json_decode(file_get_contents($jsonFilePath));
        if (!is_array($functions)) {
            throw new \Exception('Value stored in json file must be an array');
        }
        $existingFunctions = array_filter($functions, function ($func) {
            return function_exists($func);
        });
        $refFunctions = array_map(function ($functionName) {
            return new \ReflectionFunction($functionName);
        }, $existingFunctions);
        return new self($refFunctions);
    }

    public function getFunctions()
    {
        return $this->functions;
    }

    public function willAddMagicCall()
    {
        return $this->addMagicCall;
    }

    public function addMagicCall($toggle = true)
    {
        $this->addMagicCall = $toggle ? true : false;
    }

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

    public function getMethodMarkup(\ReflectionFunction $method)
    {
        $vars = array(
            'methodName' => $method->name,
            'signatureArgsString' => $this->getSignatureArgsString($method),
            'callArgsString' => $this->getCallArgsString($method)
        );
        $this->smarty->assign($vars);
        return $this->smarty->fetch('method_common.tpl');
    }

    /**
     * @param \ReflectionFunction $method
     * @return array
     */
    protected function getSignatureArgsString(\ReflectionFunction $method)
    {
        $argsStrings = array_map(function ($parameter) {
            $typeHintedClass = '';
            if ($parameter->getClass()) {
                $typeHintedClass = $parameter->getClass()->name . ' ';
            } else if ($parameter->isArray()) {
                $typeHintedClass = 'array ';
            }
            $reference = $parameter->isPassedByReference() ? '&' : '';
            $optionalOrDefaultValue = '';
            if ($parameter->isOptional()) {
                $optionalOrDefaultValue = ' = null';
            } else if ($parameter->isDefaultValueAvailable()) {
                $optionalOrDefaultValue = ' = ' . (string)$parameter->getDefaultValue();
            }
            return sprintf('%s%s$%s%s', $typeHintedClass, $reference, $parameter->name, $optionalOrDefaultValue);
        }, $method->getParameters());
        return implode(', ', $argsStrings);
    }

    /**
     * @param \ReflectionFunction $method
     * @return array|string
     */
    protected function getCallArgsString(\ReflectionFunction $method)
    {
        $callArgs = array_map(function ($parameter) {
            return sprintf('$%s', $parameter->name);
        }, $method->getParameters());
        $callArgs = implode(', ', $callArgs);
        return $callArgs;
    }

}