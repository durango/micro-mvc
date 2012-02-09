<?php /* Smarty version Smarty-3.1.7, created on 2012-02-05 02:01:45
         compiled from "/srv/www/cpanel.danieldurante.com/views/home/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10475279474f2e295957bcd3-32813028%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9af9cf64221afcbfdd44622f90f24544b6c78261' => 
    array (
      0 => '/srv/www/cpanel.danieldurante.com/views/home/index.tpl',
      1 => 1328424953,
      2 => 'file',
    ),
    '88111a09fe65c731ea2d4e17bfc9dde3aba873e7' => 
    array (
      0 => '/srv/www/cpanel.danieldurante.com/views/layout.tpl',
      1 => 1328425076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10475279474f2e295957bcd3-32813028',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'before' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2e29595d534',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2e29595d534')) {function content_4f2e29595d534($_smarty_tpl) {?><h1>Welcome!</h1>
<?php if ($_smarty_tpl->tpl_vars['before']->value!=''){?>
<strong>Before Message:</strong> <?php echo $_smarty_tpl->tpl_vars['before']->value;?>
<br><br>
<?php }?>

Hello world!<br><br>
<form action="/" method="post">
Your name is... <input type="text" name="name"> <input type="submit" value="Submit">
</form>
<?php }} ?>