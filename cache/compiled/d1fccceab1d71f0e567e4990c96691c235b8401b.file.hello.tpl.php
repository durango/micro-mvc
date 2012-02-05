<?php /* Smarty version Smarty-3.1.7, created on 2012-02-05 02:01:53
         compiled from "/srv/www/cpanel.danieldurante.com/views/home/hello.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6780539044f2e29614d5123-18932340%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1fccceab1d71f0e567e4990c96691c235b8401b' => 
    array (
      0 => '/srv/www/cpanel.danieldurante.com/views/home/hello.tpl',
      1 => 1328425165,
      2 => 'file',
    ),
    '88111a09fe65c731ea2d4e17bfc9dde3aba873e7' => 
    array (
      0 => '/srv/www/cpanel.danieldurante.com/views/layout.tpl',
      1 => 1328425076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6780539044f2e29614d5123-18932340',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'before' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2e2961525d7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2e2961525d7')) {function content_4f2e2961525d7($_smarty_tpl) {?><h1>Welcome!</h1>
<?php if ($_smarty_tpl->tpl_vars['before']->value!=''){?>
<strong>Before Message:</strong> <?php echo $_smarty_tpl->tpl_vars['before']->value;?>
<br><br>
<?php }?>

Your name is <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
!<br><br>
&raquo; <a href="/">Go back</a>
<?php }} ?>