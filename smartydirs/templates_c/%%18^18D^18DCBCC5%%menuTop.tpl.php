<?php /* Smarty version 2.6.17, created on 2015-07-20 08:48:04
         compiled from menuTop.tpl */ ?>
<ul id="menu">
<?php $_from = $this->_tpl_vars['menuTop']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuTop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuTop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuTop']['iteration']++;
?>
	<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
		<li><a class="inactiveMenu" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a></li>
	<?php else: ?>
		<li><a class="activeMenu" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a></li>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</ul>
