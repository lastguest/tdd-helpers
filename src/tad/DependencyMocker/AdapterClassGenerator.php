<?php

namespace tad\DependencyMocker;

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
        $out = sprintf('%s%s%sclass %s%s {%s%s}', $fileComment, $nsString, $classComment, $this->className, $interfaceEntry, "\n", $this->getMethodsMarkup());
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
} 