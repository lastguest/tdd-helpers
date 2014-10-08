<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-08 15:22:29
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_call.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32340076354353a95e7e2d1-02107902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4aa5890e66be0f0f83742cd49bfaed52f46c7a4b' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_call.tpl',
      1 => 1412769328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32340076354353a95e7e2d1-02107902',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54353a95ea19a5_55167859',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54353a95ea19a5_55167859')) {function content_54353a95ea19a5_55167859($_smarty_tpl) {?>public function __call($function, $args)
{
    return call_user_func_array($function, $args);
}<?php }} ?>
