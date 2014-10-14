<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-14 17:23:04
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/functionsCallCollector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:81576737054369a55637ab3-87135902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '738a76c0260733b43161eea7b23a23d61b809fb5' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/functionsCallCollector.tpl',
      1 => 1413300166,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81576737054369a55637ab3-87135902',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54369a558594b6_90311845',
  'variables' => 
  array (
    'fileComment' => 0,
    'namespace' => 0,
    'classComment' => 0,
    'className' => 0,
    'interfaceName' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54369a558594b6_90311845')) {function content_54369a558594b6_90311845($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['fileComment']->value) {?><?php echo $_smarty_tpl->tpl_vars['fileComment']->value;?>


<?php }?>
<?php if ($_smarty_tpl->tpl_vars['namespace']->value) {?>
namespace <?php echo $_smarty_tpl->tpl_vars['namespace']->value;?>
;

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['classComment']->value) {?><?php echo $_smarty_tpl->tpl_vars['classComment']->value;?>

<?php }?>
class <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['interfaceName']->value) {?>implements <?php echo $_smarty_tpl->tpl_vars['interfaceName']->value;?>
<?php }?> {
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
{
    $this->called = array();
    $this->shouldAppend = false;
    $this->mockObject = $mockObject ? $mockObject : null;
    }

    /**
    * @param $function
    * @param $arguments
    * @return mixed
    */
    public function __call($function, $arguments)
{
    $reflectionFunction = new \ReflectionFunction($function);

    $name = $reflectionFunction->name;
    $args = array(
    'name' => $name,
    'parameters' => array()
    );

    foreach ($reflectionFunction->getParameters() as $param) {    $type = $param->getClass() ? $param->getClass()->name : false;
    if (!$type && $param->isArray()) {    $type = 'array';
    }
    $args['parameters'][$param->name] = array(
    'type' => $type,
    'isPassedByReference' => $param->isPassedByReference(),
    'name' => $param->name,
    'isOptional' => $param->isOptional(),
    'defaultValue' => $param->isDefaultValueAvailable() && $param->getDefaultValue() ? $param->getDefaultValue() : false
    );
    }

    $this->called[$name] = $args;

    $responder = $this->mockObject ? array($this->mockObject, $function) : $function;

    return call_user_func_array($responder, $arguments);
    }

    /**
    * @return array The called functions information stored under their name.
    */
    public function _getCalled()
{
    return $this->called;
    }

    /**
    * @param $jsonFilePath
    * @return $this
    * @throws \Exception
    */
    public function _setJsonFilePath($jsonFilePath)
{
    if (!is_string($jsonFilePath)) {    throw new \Exception('Json file path must be a string');
    }
    $this->jsonFilePath = $jsonFilePath;
    return $this;
    }

    /**
    * @return string
    */
    public function _getJsonFilePath()
{
    return $this->jsonFilePath;
    }

    public function __destruct()
{
    $jsonFilePath = $this->jsonFilePath ? $this->jsonFilePath : false;
    if (!$jsonFilePath) {    return;
    }
    $onFile = array();
    if ($this->shouldAppend) {    $onFile = json_decode(@file_get_contents($this->jsonFilePath), true);
    }
    $contents = json_encode(array_unique(array_merge($onFile, $this->called)));
    @file_put_contents($this->jsonFilePath, $contents);
    }

    /**
    * Sets the log to be appended to the previously stored calls
    * in place of overwriting them.
    *
    * @param bool $shouldAppend
    * @return $this
    */
    public function _shouldAppend($shouldAppend = true)
{
    $this->shouldAppend = $shouldAppend ? true : false;
    return $this;
    }

    /**
    *  Returns the set mock object if any.
    *
    * @return null|\PHPUnit_Framework_MockObject_MockObject
    */
    public function _getMockObject()
{
    return $this->mockObject;
    }

    /**
    * Sets the mock object that will respond to function calls.
    *
    * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
    * @return $this
    */
    public function _setMockObject(\PHPUnit_Framework_MockObject_MockObject $mockObject = null)
{
    $this->mockObject = $mockObject;
    return $this;
    }
}
<?php }} ?>
