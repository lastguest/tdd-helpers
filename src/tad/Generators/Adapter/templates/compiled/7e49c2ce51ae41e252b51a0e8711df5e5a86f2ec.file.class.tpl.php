<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-09 15:39:12
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/class.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212095508054353a95a1ea23-02968814%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e49c2ce51ae41e252b51a0e8711df5e5a86f2ec' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/class.tpl',
      1 => 1412861938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212095508054353a95a1ea23-02968814',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54353a95c34694_94749807',
  'variables' => 
  array (
    'fileComment' => 0,
    'namespace' => 0,
    'classComment' => 0,
    'className' => 0,
    'interface' => 0,
    'magicCall' => 0,
    'methods' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54353a95c34694_94749807')) {function content_54353a95c34694_94749807($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['fileComment']->value) {?>
<?php echo $_smarty_tpl->tpl_vars['fileComment']->value;?>


<?php }?>
<?php if ($_smarty_tpl->tpl_vars['namespace']->value) {?>
<?php echo $_smarty_tpl->tpl_vars['namespace']->value;?>


<?php }?>
<?php if ($_smarty_tpl->tpl_vars['classComment']->value) {?>
<?php echo $_smarty_tpl->tpl_vars['classComment']->value;?>

<?php }?>
class <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
<?php if ($_smarty_tpl->tpl_vars['interface']->value) {?> implements <?php echo $_smarty_tpl->tpl_vars['interface']->value;?>
<?php }?> {
<?php if ($_smarty_tpl->tpl_vars['magicCall']->value) {?>

<?php echo preg_replace('!^!m',str_repeat(' ',4),$_smarty_tpl->tpl_vars['magicCall']->value);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['methods']->value) {?>

<?php echo preg_replace('!^!m',str_repeat(' ',4),$_smarty_tpl->tpl_vars['methods']->value);?>

<?php }?>

}<?php }} ?>
