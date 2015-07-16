<?php /* Smarty version 2.6.17, created on 2013-12-16 17:27:51
         compiled from menuTop.tpl */ ?>
<span>
<?php $_from = $this->_tpl_vars['menuTop']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuTop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuTop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuTop']['iteration']++;
?>
	<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
		<a class="inactiveMenu" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
	<?php else: ?>
		<a class="activeMenu" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</span>
