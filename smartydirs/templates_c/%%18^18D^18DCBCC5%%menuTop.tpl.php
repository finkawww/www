<?php /* Smarty version 2.6.17, created on 2015-08-17 10:12:18
         compiled from menuTop.tpl */ ?>
<ul id="menu">
<?php $_from = $this->_tpl_vars['menuTop']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuTop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuTop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuTop']['iteration']++;
?>

		<?php if ($this->_tpl_vars['menuItem']->parentMenu == NULL): ?>
		<li><a class="activeMenu" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a><span class="activeMenu"> |</span>
		<?php if ($this->_tpl_vars['menuItem']->child): ?>
			<ul class="submenu">
			<?php $_from = $this->_tpl_vars['menuItem']->child; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['childItem'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childItem']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['child']):
        $this->_foreach['childItem']['iteration']++;
?>
				<li><a class="activeMenu submenu-header" href="/<?php echo $this->_tpl_vars['child']['MenuLinkText']; ?>
"><?php echo $this->_tpl_vars['child']['Name']; ?>
</a>
					<?php if ($this->_tpl_vars['child']['child']): ?>
					<ul class="next-submenu">
						<?php $_from = $this->_tpl_vars['child']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['secondChild']):
?>
							<li><a class="activeMenu" href="/<?php echo $this->_tpl_vars['secondChild']['MenuLinkText']; ?>
"><?php echo $this->_tpl_vars['secondChild']['Name']; ?>
</a></li>
						<?php endforeach; endif; unset($_from); ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
		</li>
		<?php endif; ?>		
	<?php endif; ?>
	

<?php endforeach; endif; unset($_from); ?>
</ul>
