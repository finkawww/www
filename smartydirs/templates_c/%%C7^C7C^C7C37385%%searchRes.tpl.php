<?php /* Smarty version 2.6.17, created on 2011-02-17 22:55:59
         compiled from modules/searchRes.tpl */ ?>
<h2><center>Wyniki wyszukiwania</center></h2>
<center>
<table width = "400">
		<tr><td width="100%"><hr/></td></tr>
		<tr><td align = "center">
			<table width = "100%">
				<tr><td><b>Treść</b></td></tr>
				<?php echo $this->_tpl_vars['resStrony']; ?>

			</table>
		</td></tr>
		<tr><td width="100%"><hr/></td></tr>
		<tr><td align = "center">
			<table>
				<tr><td><b>Oferty</b></td></tr>
				<?php echo $this->_tpl_vars['resOferty']; ?>

			</table>
		</tr></td>
		<tr><td width="100%"><hr/></td></tr>
		<tr><td align="center">
			<table>
				<tr><td><b>Towary</b></td></tr>
				<?php echo $this->_tpl_vars['resTowary']; ?>

			</table>
		</td></tr>
</table>	
</center>