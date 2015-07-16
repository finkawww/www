<?php /* Smarty version 2.6.17, created on 2014-07-11 12:06:41
         compiled from modules/AktualizacjeFull.tpl */ ?>
<table width="620" border="0" cellspacing="15> 
<?php $_from = $this->_tpl_vars['aktItems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aktItems'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aktItems']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['aktItem']):
        $this->_foreach['aktItems']['iteration']++;
?>
	<tr>
		<td width="620" align="left"><div class="granat"><?php echo $this->_tpl_vars['aktItem']->program; ?>
 <?php echo $this->_tpl_vars['aktItem']->wersja; ?>
 | <?php echo $this->_tpl_vars['aktItem']->data; ?>
</div></td>
	</tr>
	<tr>
		<td colspan="2" width="620">
			<?php echo $this->_tpl_vars['aktItem']->opis; ?>

		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
<tr>
	<td align="center" colspan="2">
		<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pagesItem']):
        $this->_foreach['pages']['iteration']++;
?>
		<?php if ($this->_tpl_vars['pagesItem'] == $this->_tpl_vars['actualPage']): ?>
			<?php echo $this->_tpl_vars['pagesItem']; ?>

		<?php else: ?>
			<a href="?page=<?php echo $this->_tpl_vars['pagesItem']; ?>
"><?php echo $this->_tpl_vars['pagesItem']; ?>
</a>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>		
	</td>
</tr>
</table>