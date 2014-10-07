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
    protected $tab = '    ';

    protected $addMagicCall = true;
    protected $outputFilePath;

    public function __construct(array $functions = null)
    {
        if (!is_array($functions)) {
            return;
        }
        array_walk($functions, function ($el, $index) {
            if (!is_a($el, 'ReflectionFunction')) {
                throw new \Exception("All array elements should be ReflectionFunction instances, $index is not");
            }
        });
        $this->functions = $functions;
    }

    public function getMethodMarkup(\ReflectionFunction $method)
    {
        return $this->getTabbedMethodMarkup($method, false);
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
        return $argsStrings;
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
        $fileComment = $this->fileComment ? $this->getCommentedString($this->fileComment) . $this->newline : '';
        $nsString = $this->ns ? sprintf('namespace %s;%s', $this->ns, $this->newline . $this->newline) : '';
        $classComment = $this->classComment ? $this->getCommentedString($this->classComment) : '';
        $interfaceEntry = $this->interfaceName ? sprintf(' implements %s', $this->interfaceName) : '';
        $out = sprintf('%s%s%sclass %s%s {', $fileComment, $nsString, $classComment, $this->className, $interfaceEntry);
        $magicCall = $this->addMagicCall ? $this->getMagicCallMarkup() : '';
        $out .= sprintf('%s%s%s', $this->newline, $magicCall, $this->getMethodsMarkup());
        $out .= '}';

        // remove triple new lines
        $out = preg_replace('/\n{3}/', "\n\n", $out);

        return $out;
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
     * @return string
     */
    protected function getCommentedString($string)
    {
        return sprintf('/**%s%s%s */%s', $this->newline, $this->getCommentedLines($string), $this->newline, $this->newline);
    }

    protected function getMethodsMarkup(array $functions = null)
    {
        $functions = $functions ? $functions : $this->functions;
        if (!$functions) {
            return '';
        }
        $methods = array_map(function ($function) {
            return $this->getTabbedMethodMarkup($function);
        }, $functions);
        return implode("\n", $methods) . $this->newline . $this->newline;
    }

    /**
     * @param \ReflectionFunction $method
     * @return string
     */
    protected function getTabbedMethodMarkup(\ReflectionFunction $method, $indent = true)
    {
        $indent = $indent ? $this->tab : '';
        $signatureArgsString = $this->getSignatureArgsString($method);
        $callArgsString = $this->getCallArgsString($method);

        $out = $indent ? $this->newline : '';
        $out .= $indent . sprintf('public function %s(%s){', $method->name, implode(', ', $signatureArgsString));
        $out .= sprintf('%sreturn %s(%s);', $this->newline . $indent . $this->tab, $method->name, $callArgsString);
        $out .= $this->newline . $indent . '}';

        return $out;
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
        $out = $this->newline;
        $out .= $this->tab . 'public function __call($function, $args){';
        $out .= $this->newline . $this->tab;
        $out .= $this->tab . 'return call_user_func_array($function, $args);';
        $out .= $this->newline;
        $out .= $this->tab . '}' . $this->newline . $this->newline;

        return $out;
    }

    public function setOutputFile($filePath)
    {
        if (!is_string($filePath)) {
            throw new \Exception('File path should be a string');
        }
        $this->outputFilePath = $filePath;
    }

    public function getOuputFile()
    {
        return $this->outputFilePath;
    }

    public function generate()
    {
        if (!$this->outputFilePath) {
            return;
        }

        $contents = '<?php';
        $contents .= $this->newline;
        $contents .= $this->getClassMarkup();

        file_put_contents($this->outputFilePath, $contents);
    }

}