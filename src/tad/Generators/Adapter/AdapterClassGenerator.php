<?php

namespace tad\Generators\Adapter;


class AdapterClassGenerator
{
    protected $fileComment;
    protected $ns;
    protected $classComment;
    protected $className;
    protected $interfaceName;
    protected $functions;
    protected $newline = "\n";
    protected $tab = "\t";
    protected $addMagicCall = true;
    protected $outputFilePath;
    protected $smarty;

    public function __construct(array $functions = null, \Smarty $smarty = null)
    {
        if (is_array($functions)) {
            array_walk($functions, function ($el, $index) {
                if (!is_a($el, 'ReflectionFunction')) {
                    throw new \Exception("All array elements should be ReflectionFunction instances, $index is not");
                }
            });
            $this->functions = $functions;
        }

        $this->smarty = $smarty ? $smarty : new \Smarty();
    }

    public function getMethodMarkup(\ReflectionFunction $method)
    {
        $vars = array(
            'methodName' => $method->name,
            'signatureArgsString' => $this->getSignatureArgsString($method),
            'callArgsString' => $this->getCallArgsString($method)
        );
        $this->smarty->assign($vars);
        return $this->smarty->fetch($this->getTemplate('method_common'));
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

    public function setClassName($className)
    {
        if (!is_string($className)) {
            throw new \Exception('Class name must be a string');
        }
        $this->className = $className;
    }

    public function setInterfaceName($interfaceName)
    {
        if (!is_string($interfaceName)) {
            throw new \Exception('Interface name must be a string');
        }
        $this->interfaceName = $interfaceName;
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
        return $this->smarty->fetch($this->getTemplate('class'));
    }

    public function setNamespace($namespace)
    {
        if (!is_string($namespace)) {
            throw new \Exception('namespace must be a string');
        }
        $this->ns = ltrim($namespace, '\\');
    }

    public function setClassComment($classComment)
    {
        if (!is_string($classComment)) {
            throw new \Exception('Class comment must be a string');
        }
        $this->classComment = $classComment;
    }

    protected function getCommentedLines($string)
    {
        $lines = array_map(function ($line) {
            return sprintf(' * %s', $line);
        }, explode("\n", $string));
        return implode("\n", $lines);
    }

    public function setFileComment($fileComment)
    {
        if (!is_string($fileComment)) {
            throw new \Exception('File comment must be a string');
        }
        $this->fileComment = $fileComment;
    }

    /**
     * @param $string
     * @throws \Exception
     * @throws \SmartyException
     * @return string
     */
    protected function getCommentedString($string)
    {
        $this->smarty->assign('comment', $string);
        return $this->smarty->fetch($this->getTemplate('comment'));
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

    public function getFunctions()
    {
        return $this->functions;
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

    public function willAddMagicCall()
    {
        return $this->addMagicCall;
    }

    public function addMagicCall($toggle = true)
    {
        $this->addMagicCall = $toggle ? true : false;
    }

    protected function getMagicCallMarkup()
    {
        return $this->smarty->fetch($this->getTemplate('method_call'));
    }

    public function setOutputFile($filePath)
    {
        if (!is_string($filePath)) {
            throw new \Exception('File path should be a string');
        }
        $this->outputFilePath = $filePath;
    }

    public function getOutputFile()
    {
        return $this->outputFilePath;
    }

    public function generate()
    {
        if (!$this->outputFilePath) {
            return;
        }
        $vars = array(
            'class' => $this->getClassMarkup()
        );
        $this->smarty->assign($vars);
        $contents = $this->smarty->fetch($this->getTemplate('file'));

        file_put_contents($this->outputFilePath, $contents);
    }

    private function getTemplate($templateName)
    {
        if (!is_string($templateName)) {
            throw new \Exception('Template name must be a string');
        }
        $templateFile = dirname(__FILE__) . '/templates/' . $templateName . '.tpl';
        if (!file_exists($templateFile)) {
            throw new \Exception("Template $templateName does not exist");
        }
        return $templateFile;
    }

}