{if $fileComment}{$fileComment}

{/if}
{if $namespace}
namespace {$namespace};

{/if}
{if $classComment}{$classComment}
{/if}
class {$className} {if $interfaceName}implements {$interfaceName}{/if} {literal}{{/literal}
    protected $called;
    protected $jsonFilePath;
    protected $shouldAppend;

    public function __construct()
    {literal}{{/literal}
        $this->called = array();
{literal}}{/literal}

    public function __call($function, $arguments)
    {literal}{{/literal}
        $reflectionFunction = new \ReflectionFunction($function);
        $this->called[$reflectionFunction->name] = $reflectionFunction;
        return call_user_func_array($function, $arguments);
    {literal}}{/literal}

    public function _getCalled()
    {literal}{{/literal}
        return array_values($this->called);
    {literal}}{/literal}

    public function _setJsonFilePath($jsonFilePath)
    {literal}{{/literal}
        if (!is_string($jsonFilePath)) {literal}{{/literal}
        throw new \Exception('Json file path must be a string');
        {literal}}{/literal}
        $this->jsonFilePath = $jsonFilePath;
    {literal}}{/literal}

    public function _getJsonFilePath()
    {literal}{{/literal}
        return $this->jsonFilePath;
    {literal}}{/literal}

    public function __destruct()
    {literal}{{/literal}
        $jsonFilePath = $this->jsonFilePath ? $this->jsonFilePath : false;
        if (!$jsonFilePath) {literal}{{/literal}
        return;
    {literal}}{/literal}
        $onFile = $this->shouldAppend ? json_decode(@file_get_contents($this->jsonFilePath)) : array();
        $contents = json_encode(array_merge($onFile, array_keys($this->called)));
        @file_put_contents($this->jsonFilePath, $contents);
    {literal}}{/literal}

    public function _shouldAppend($shouldAppend = true)
    {literal}{{/literal}
        $this->shouldAppend = $shouldAppend ? true : false;
    {literal}}{/literal}

{literal}}{/literal}
