<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-08 11:35:45
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_call.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8720480255434e662dfdf86-05127912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4aa5890e66be0f0f83742cd49bfaed52f46c7a4b' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_call.tpl',
      1 => 1412760943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8720480255434e662dfdf86-05127912',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_5434e662e30e43_21201250',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434e662e30e43_21201250')) {function content_5434e662e30e43_21201250($_smarty_tpl) {?>public function __call($function, $args)
{
    return call_user_func_array($function, $args);
}<?php }} ?>
