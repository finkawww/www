<?php /* Smarty version 2.6.17, created on 2012-03-09 13:13:17
         compiled from modules/ZamowieniePozostaleForm.tpl */ ?>
<center>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table border="0" width="400">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="center"><div class="granat"><?php echo $this->_tpl_vars['form']['header']['hdr']; ?>
</div></td></tr>
	<?php if ($this->_tpl_vars['form']['selPlatnosc']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><div class="font"><?php echo $this->_tpl_vars['form']['selPlatnosc']['error']; ?>
</div></font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selPlatnosc']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selPlatnosc']['html']; ?>
</div></td></tr>
	<!-- opis dostawy -->
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selDostawa']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selDostawa']['html']; ?>
</div></td></tr>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['Uwagi']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['Uwagi']['html']; ?>
</div></td></tr>
	<!--<tr><td><?php echo $this->_tpl_vars['form']['captcha']['label']; ?>
</td><td><?php echo $this->_tpl_vars['form']['captcha']['html']; ?>
</td></tr>-->
	<tr><td colspan="2" align="center"><div class="font"><?php echo $this->_tpl_vars['form']['btnReset']['html']; ?>
<?php echo $this->_tpl_vars['form']['btnSubmit']['html']; ?>
</div></tD></tr>
</table>

</td></tr></table>
</form>
</center>