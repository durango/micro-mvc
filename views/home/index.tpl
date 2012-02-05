{* Smarty file *}
{extends file="layout.tpl"}
{block name="content"}
Hello world!<br><br>
<form action="/" method="post">
Your name is... <input type="text" name="name"> <input type="submit" value="Submit">
</form>
{/block}