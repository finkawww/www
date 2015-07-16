<?php /* Smarty version 2.6.17, created on 2013-10-09 15:30:07
         compiled from modules/ZamowienieFakturaFirmaForm.tpl */ ?>
<center>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table border="0" width="600">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="justify"><div class="granat"><?php echo $this->_tpl_vars['form']['header']['hdr']; ?>
</div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNazwa']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><?php echo $this->_tpl_vars['form']['txtNazwa']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwa']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwa']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNazwa']['required']): ?>*<?php endif; ?></div></td></tr>
	
	
	<?php if ($this->_tpl_vars['form']['selKraj']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['selKraj']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selKraj']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selKraj']['html']; ?>
</div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtKodPocztowy']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['error']; ?>
</div></font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtKodPocztowy']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtMiasto']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><?php echo $this->_tpl_vars['form']['txtMiasto']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtMiasto']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtUlica']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtUlica']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtUlica']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrDomu']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrDomu']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrMieszkania']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrMieszkania']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrTel']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['selFaktura']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><?php echo $this->_tpl_vars['form']['selFaktura']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selFaktura']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selFaktura']['html']; ?>
</div></td></tr>
	
		
	<tr><td colspan="2" align="center"><?php echo $this->_tpl_vars['form']['btnReset']['html']; ?>
<?php echo $this->_tpl_vars['form']['btnSubmit']['html']; ?>
</tD></tr>
</table>
</td></tr></table>
</form>
</center>