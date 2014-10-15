<?php

namespace tad\Utility;


class ClassReader
{

    /**
     * @var array
     */
    protected $classes;

    /**
     * @var string
     */
    protected $code;

    public function getClassesCode()
    {
        $this->code = array_map(function ($class) {
            if (!file_exists($class) && !class_exists($class)) {
                throw new \Exception("Class $class is not an absolute file path nor a defined class name.");
            }

            $classes = array($class);
            $file = '';

            if (file_exists($class)) {
                $file = $class;
                $declaredClassesBefore = get_declared_classes();
                include $class;
                $declaredClassesAfter = get_declared_classes();
                $newlyDeclaredClasses = array_diff($declaredClassesAfter, $declaredClassesBefore);
                $classes = $newlyDeclaredClasses;
            }

            $classesJoinedCode = array_map(function ($class) use ($file) {
                $reflectionClass = new \ReflectionClass($class);
                $classStartLine = $reflectionClass->getStartLine() - 1;
                $classEndLine = $reflectionClass->getEndLine();
                $lines = $classEndLine - $classStartLine;
                $file = $file ? $file : $reflectionClass->getFileName();
                $source = file($file);
                $classCode = implode('', array_slice($source, $classStartLine, $lines));
                return $classCode;
            }, $classes);

            return implode('', $classesJoinedCode);
        }, $this->classes);

        $out = preg_replace("/(\\n|\\t|\\s+)+/us", " ", implode('', $this->code));
        return $out;
    }

    public function setClasses($classes = null)
    {
        if (!is_null($classes) && !is_array($classes) && !is_string($classes)) {
            throw new \Exception('Classes must either be an array or a string if it\'s not null');
        }
        $this->classes = is_array($classes) ? $classes : array($classes);
    }
}