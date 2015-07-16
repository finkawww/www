<?php /* Smarty version 2.6.17, created on 2011-02-17 22:34:53
         compiled from modules/GrupyOfert.tpl */ ?>
<center>
<table width="450">
<?php $_from = $this->_tpl_vars['grupa']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['grupa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['grupa']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ofertaItem']):
        $this->_foreach['grupa']['iteration']++;
?>
<tr halign="center">
	<td halign="center">
	<img src=<?php echo $this->_tpl_vars['ofertaItem']->obraz; ?>
>
	</td>
	<td valign="center">
		<a href=?a=<?php echo $this->_tpl_vars['ofertaItem']->actionPokazOferte; ?>
&idOferty=<?php echo $this->_tpl_vars['ofertaItem']->idOferty; ?>
>
			<?php echo $this->_tpl_vars['ofertaItem']->opisShort; ?>

		</a>
	</td>
</tr>	
<?php endforeach; endif; unset($_from); ?>
</table>
</center>