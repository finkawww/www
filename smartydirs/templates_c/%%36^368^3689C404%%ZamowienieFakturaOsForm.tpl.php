<?php /* Smarty version 2.6.17, created on 2012-03-10 15:58:58
         compiled from modules/ZamowienieFakturaOsForm.tpl */ ?>
<center>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="400" border="0">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="center"><div class="granat"><?php echo $this->_tpl_vars['form']['header']['hdr']; ?>
</div><br></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtImie']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtImie']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtImie']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtImie']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtImie']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNazwisko']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtNazwisko']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwisko']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwisko']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNazwisko']['required']): ?>*<?php endif; ?></div></td></tr>
	
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
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtKodPocztowy']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtMiasto']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtMiasto']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtMiasto']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtUlica']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtUlica']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtUlica']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrDomu']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtNrDomu']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrDomu']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrMieszkania']['error'] != ''): ?>
	<tr><td colspan="2">
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['html']; ?>
</div></td></tr>
	
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['label']; ?>
<font></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['html']; ?>
</div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['selFaktura']['error'] != ''): ?>
	<tr><td>
		<font size="2"><div class="bordo"><?php echo $this->_tpl_vars['form']['selFaktura']['error']; ?>
</div>
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