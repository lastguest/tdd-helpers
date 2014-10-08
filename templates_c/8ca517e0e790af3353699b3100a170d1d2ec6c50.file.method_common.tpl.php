<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-08 11:38:56
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_common.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21185640475434ee59e48184-70914965%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ca517e0e790af3353699b3100a170d1d2ec6c50' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/method_common.tpl',
      1 => 1412761134,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21185640475434ee59e48184-70914965',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_5434ee59ec0428_98585723',
  'variables' => 
  array (
    'methodName' => 0,
    'signatureArgsString' => 0,
    'callArgsString' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434ee59ec0428_98585723')) {function content_5434ee59ec0428_98585723($_smarty_tpl) {?>public function <?php echo $_smarty_tpl->tpl_vars['methodName']->value;?>
(<?php echo $_smarty_tpl->tpl_vars['signatureArgsString']->value;?>
)
{
    return <?php echo $_smarty_tpl->tpl_vars['methodName']->value;?>
(<?php echo $_smarty_tpl->tpl_vars['callArgsString']->value;?>
);
}<?php }} ?>
