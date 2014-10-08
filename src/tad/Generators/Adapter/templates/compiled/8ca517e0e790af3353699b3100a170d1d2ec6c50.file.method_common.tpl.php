<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-08 15:22:29
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_common.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93959276154353a958a1857-34081115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ca517e0e790af3353699b3100a170d1d2ec6c50' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_common.tpl',
      1 => 1412769328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93959276154353a958a1857-34081115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'methodName' => 0,
    'signatureArgsString' => 0,
    'callArgsString' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54353a95956519_43836622',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54353a95956519_43836622')) {function content_54353a95956519_43836622($_smarty_tpl) {?>public function <?php echo $_smarty_tpl->tpl_vars['methodName']->value;?>
(<?php echo $_smarty_tpl->tpl_vars['signatureArgsString']->value;?>
)
{
    return <?php echo $_smarty_tpl->tpl_vars['methodName']->value;?>
(<?php echo $_smarty_tpl->tpl_vars['callArgsString']->value;?>
);
}<?php }} ?>
