<?php

namespace tad\adapters;

/**
 * Globally defined functions wrapper
 */
class Functions implements \tad\interfaces\FunctionsAdapter
{
    
    /**
     * Wraps call to globally defined functions in a method call.
     *
     * if 'some_function' is a function defined in the global scope
     * then a call to it could be made using the adapter like
     *
     *     $adapter = new \tad\adapters\FunctionsAdapter();
     *     $var = $adapter->some_function();
     *
     * @param  string $function  The function name.
     * @param  array $arguments  An array of function arguments.
     *
     * @return mixed            The wrapped function return value.
     */
    public function __call($function, Array $arguments = null)
    {
        if (!is_string($function) or !function_exists($function)) {
            return;
        }
        return call_user_func_array($function, $arguments);
    }
}
