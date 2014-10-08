<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-10-08 15:22:29
         compiled from "/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/comment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:159280667354353a95ca6820-44161772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '140f76089a2d940db32667f86edbfdc4ea6ffc8a' => 
    array (
      0 => '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/src/tad/Generators/Adapter/templates/comment.tpl',
      1 => 1412769328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159280667354353a95ca6820-44161772',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54353a95cfbb77_48323862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54353a95cfbb77_48323862')) {function content_54353a95cfbb77_48323862($_smarty_tpl) {?><?php if (!is_callable('smarty_mb_wordwrap')) include '/Users/Luca/Dropbox/Developer/WebDeveloper/websites/php52/composer-packages/tdd-helpers/vendor/smarty/smarty/libs/plugins/shared.mb_wordwrap.php';
?>/**
<?php echo preg_replace('!^!m',str_repeat(" * ",1),smarty_mb_wordwrap($_smarty_tpl->tpl_vars['comment']->value,80,"\n",false));?>

 */<?php }} ?>
