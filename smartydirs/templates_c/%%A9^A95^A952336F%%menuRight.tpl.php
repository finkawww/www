<?php /* Smarty version 2.6.17, created on 2014-01-23 00:25:44
         compiled from menuRight.tpl */ ?>
<table class="rightMenuContainer">
<?php $_from = $this->_tpl_vars['menuRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuRight'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuRight']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuRight']['iteration']++;
?>
	
	<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
	<tr><td width="210px">
		<a class="menuItem" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
	</td></tr>
	<?php else: ?>
	<tr><td width="210px">
		<a class="menuItem" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
	</td></tr>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>