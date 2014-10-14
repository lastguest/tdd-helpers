{if $fileComment}{$fileComment}

{/if}
{if $namespace}
namespace {$namespace};

{/if}
{if $classComment}{$classComment}
{/if}
class {$className} {if $interfaceName}implements {$interfaceName}{/if} {literal}{{/literal}
    /**
    * @var array
    */
    protected $called;

    /**
    * @var string Absolute path to the the json file logged functions will be written to.
    */
    protected $jsonFilePath;

    /**
    * @var bool
    */
    protected $shouldAppend;

    /**
    * @var null|\PHPUnit_Framework_MockObject_MockObject
    */
    protected $mockObject;

    /**
    * @param array $called
    * @param null $jsonFilePath
    * @param bool $shoulAppend
    * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
    */
    public function __construct(array $called = null, $jsonFilePath = null, $shoulAppend = false, \PHPUnit_Framework_MockObject_MockObject $mockObject = null)
{literal}{{/literal}
    $this->called = array();
    $this->shouldAppend = false;
    $this->mockObject = $mockObject ? $mockObject : null;
    {literal}}{/literal}

    /**
    * @param $function
    * @param $arguments
    * @return mixed
    */
    public function __call($function, $arguments)
{literal}{{/literal}
    $reflectionFunction = new \ReflectionFunction($function);

    $name = $reflectionFunction->name;
    $args = array(
    'name' => $name,
    'parameters' => array()
    );

    foreach ($reflectionFunction->getParameters() as $param) {literal}{{/literal}    $type = $param->getClass() ? $param->getClass()->name : false;
    if (!$type && $param->isArray()) {literal}{{/literal}    $type = 'array';
    {literal}}{/literal}
    $args['parameters'][$param->name] = array(
    'type' => $type,
    'isPassedByReference' => $param->isPassedByReference(),
    'name' => $param->name,
    'isOptional' => $param->isOptional(),
    'defaultValue' => $param->isDefaultValueAvailable() && $param->getDefaultValue() ? $param->getDefaultValue() : false
    );
    {literal}}{/literal}

    $this->called[$name] = $args;

    $responder = $this->mockObject ? array($this->mockObject, $function) : $function;

    return call_user_func_array($responder, $arguments);
    {literal}}{/literal}

    /**
    * @return array The called functions information stored under their name.
    */
    public function _getCalled()
{literal}{{/literal}
    return $this->called;
    {literal}}{/literal}

    /**
    * @param $jsonFilePath
    * @return $this
    * @throws \Exception
    */
    public function _setJsonFilePath($jsonFilePath)
{literal}{{/literal}
    if (!is_string($jsonFilePath)) {literal}{{/literal}    throw new \Exception('Json file path must be a string');
    {literal}}{/literal}
    $this->jsonFilePath = $jsonFilePath;
    return $this;
    {literal}}{/literal}

    /**
    * @return string
    */
    public function _getJsonFilePath()
{literal}{{/literal}
    return $this->jsonFilePath;
    {literal}}{/literal}

    public function __destruct()
{literal}{{/literal}
    $jsonFilePath = $this->jsonFilePath ? $this->jsonFilePath : false;
    if (!$jsonFilePath) {literal}{{/literal}    return;
    {literal}}{/literal}
    $onFile = array();
    if ($this->shouldAppend) {literal}{{/literal}    $onFile = json_decode(@file_get_contents($this->jsonFilePath), true);
    {literal}}{/literal}
    $contents = json_encode(array_merge($onFile, $this->called));
    @file_put_contents($this->jsonFilePath, $contents);
    {literal}}{/literal}

    /**
    * Sets the log to be appended to the previously stored calls
    * in place of overwriting them.
    *
    * @param bool $shouldAppend
    * @return $this
    */
    public function _shouldAppend($shouldAppend = true)
{literal}{{/literal}
    $this->shouldAppend = $shouldAppend ? true : false;
    return $this;
    {literal}}{/literal}

    /**
    *  Returns the set mock object if any.
    *
    * @return null|\PHPUnit_Framework_MockObject_MockObject
    */
    public function _getMockObject()
{literal}{{/literal}
    return $this->mockObject;
    {literal}}{/literal}

    /**
    * Sets the mock object that will respond to function calls.
    *
    * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
    * @return $this
    */
    public function _setMockObject(\PHPUnit_Framework_MockObject_MockObject $mockObject = null)
{literal}{{/literal}
    $this->mockObject = $mockObject;
    return $this;
    {literal}}{/literal}
{literal}}{/literal}
