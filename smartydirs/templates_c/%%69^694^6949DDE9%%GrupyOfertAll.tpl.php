<?php /* Smarty version 2.6.17, created on 2015-08-04 11:24:31
         compiled from modules/GrupyOfertAll.tpl */ ?>
<br/>

<table >
<tr>
<?php $_from = $this->_tpl_vars['grupyOfert']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['grupyOfert'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['grupyOfert']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grupy']):
        $this->_foreach['grupyOfert']['iteration']++;
?>
<?php if (( ( ($this->_foreach['grupyOfert']['iteration']-1) % 2 ) == 0 ) && ( ($this->_foreach['grupyOfert']['iteration']-1) > 0 )): ?>
		<?php if (($this->_foreach['grupyOfert']['iteration']-1) > 0): ?></tr><?php endif; ?><tr>
<?php endif; ?>
	<td>
	<table width="360">
		<tr><td class="cennik_header_DOS" colspan="2"><div class="granat"><?php echo $this->_tpl_vars['grupy']->nazwa; ?>
</div></td></tr>
		<tr valign="top"><td width="120"><img src="<?php echo $this->_tpl_vars['grupy']->pict; ?>
" border="0" /></td><td align="left" width="240"><br/><?php echo $this->_tpl_vars['grupy']->opis; ?>
</td></tr>
		<tr><td colspan="2" align="right"><a href="?a=<?php echo $this->_tpl_vars['actionPokazOferte']; ?>
&idGrupy=<?php echo $this->_tpl_vars['grupy']->id; ?>
"><img src="/images/buy.png" border="0"></a></td></tr>
	</table>
	</td>
<?php endforeach; endif; unset($_from); ?>
</tr>
</table>