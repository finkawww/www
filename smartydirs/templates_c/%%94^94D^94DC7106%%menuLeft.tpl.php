<?php /* Smarty version 2.6.17, created on 2013-12-16 17:27:51
         compiled from menuLeft.tpl */ ?>
<table class="leftMenuContainer">
<?php $this->assign('tmpGroup', 'X'); ?>
<?php $_from = $this->_tpl_vars['menuLeft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuLeft'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuLeft']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuLeft']['iteration']++;
?>

<?php if ($this->_tpl_vars['menuItem']->active): ?>
    <?php if ($this->_tpl_vars['menuItem']->grupa == $this->_tpl_vars['tmpGroup']): ?>
    <tr>
		<td>	
		<?php if ($this->_tpl_vars['menuItem']->level == 1): ?>
		
		<?php elseif ($this->_tpl_vars['menuItem']->level == 2): ?>
		<span minwidth="100px" align="right"><img src="../Cms/Files/Img/corner-dots.gif" border="0"></span>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
			<a class="inactiveMenuLeft" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
		<?php else: ?>
			<a class="activeMenuLeft" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
		<?php endif; ?>
		</td>
	</tr>
	<?php else: ?>
		<?php $this->assign('tmpGroup', $this->_tpl_vars['menuItem']->grupa); ?></span>
		<tr><td><span class="activeMenu"><?php echo $this->_tpl_vars['tmpGroup']; ?>
</span></td></tr>
		<tr>
			<td>
			<?php if ($this->_tpl_vars['activeMenu']->level == 1): ?>
			
			<?php elseif ($this->_tpl_vars['activeMenu']->level == 2): ?>
			<span minwidth="100px" align="right"><img src="../Cms/Files/Img/corner-dots.gif" border="0"></span>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
				<a class="inactiveMenuLeft" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
		<?php else: ?>
				<a class="activeMenuLeft" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>
		<?php endif; ?>

		  	</td>
		</tr> 
	<?php endif; ?>  
<?php endif; ?> 
<?php endforeach; endif; unset($_from); ?>

</table>