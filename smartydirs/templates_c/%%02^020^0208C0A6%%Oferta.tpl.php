<?php /* Smarty version 2.6.17, created on 2011-08-11 22:53:20
         compiled from modules/Oferta.tpl */ ?>
﻿<center>
<?php echo $this->_tpl_vars['nazwaGrupy']; ?>

<br/>
<?php echo $this->_tpl_vars['nazwaOferty']; ?>


<table align="center">
<tr><td width="300"><b>Opis</b></td><td width="50" align="right"><b>Rabat</b></td><td width="80" align="right"><b>Cena</b></td><td align="center" width="50"><b>Kup</b></td></tr>
<?php $_from = $this->_tpl_vars['towar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['towar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['towar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['towarItem']):
        $this->_foreach['towar']['iteration']++;
?>
	<tr>
		<td><?php echo $this->_tpl_vars['towarItem']->opisTowaru; ?>
</td>
		<td align="right"><?php if ($this->_tpl_vars['towarItem']->rabat == 0): ?> <?php else: ?><?php echo $this->_tpl_vars['towarItem']->rabat; ?>
<?php endif; ?></td>
		<td align="right"><?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
</td>
		<td align="center"><a href="?a=<?php echo $this->_tpl_vars['towarItem']->actionDoKoszyka; ?>
&towarId=<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
"><img src="/FrontPage/Files/Img/koszyk_small.jpg" border="0"/></a></td>
	</tr>
	
<?php endforeach; endif; unset($_from); ?>
<br>
<table>

</center>