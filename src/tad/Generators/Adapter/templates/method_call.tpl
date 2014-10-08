public function __call($function, $args)
{literal}{{/literal}
    return call_user_func_array($function, $args);
{literal}}{/literal}