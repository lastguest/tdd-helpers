<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-09 18:29:19
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/functionsCallCollector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:81576737054369a55637ab3-87135902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '738a76c0260733b43161eea7b23a23d61b809fb5' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/functionsCallCollector.tpl',
      1 => 1412872100,
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
    protected $called;
    protected $jsonFilePath;
    protected $shouldAppend;

    public function __construct()
    {
        $this->called = array();
        $this->jsonFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions_dump' . time();
        $this->shouldAppend = false;
}

    public function __call($function, $arguments)
    {
        $reflectionFunction = new \ReflectionFunction($function);
        $this->called[$reflectionFunction->name] = $reflectionFunction;
        return call_user_func_array($function, $arguments);
    }

    public function _getCalled()
    {
        return array_values($this->called);
    }

    public function _setJsonFilePath($jsonFilePath)
    {
        if (!is_string($jsonFilePath)) {
        throw new \Exception('Json file path must be a string');
        }
        $this->jsonFilePath = $jsonFilePath;
    }

    public function _getJsonFilePath()
    {
        return $this->jsonFilePath;
    }

    public function __destruct()
    {
        $jsonFilePath = $this->jsonFilePath ? $this->jsonFilePath : false;
        if (!$jsonFilePath) {
        return;
    }
        $onFile = $this->shouldAppend ? json_decode(@file_get_contents($this->jsonFilePath)) : array();
        $contents = json_encode(array_merge($onFile, array_keys($this->called)));
        @file_put_contents($this->jsonFilePath, $contents);
    }

    public function _shouldAppend($shouldAppend = true)
    {
        $this->shouldAppend = $shouldAppend ? true : false;
    }

}
<?php }} ?>
