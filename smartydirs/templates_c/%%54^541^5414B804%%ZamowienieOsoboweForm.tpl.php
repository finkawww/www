<?php /* Smarty version 2.6.17, created on 2013-10-09 15:29:00
         compiled from modules/ZamowienieOsoboweForm.tpl */ ?>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table border="0" width="500"  align="justify"><tr><td>
<table width="100%" align="justify">
	<tr><td colspan="2" width="100%"><div class="granat"><?php echo $this->_tpl_vars['form']['header']['hdr']; ?>
</div><br/></td></tr>
	
	
	<?php if ($this->_tpl_vars['form']['txtImie']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtImie']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtImie']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtImie']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtImie']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNazwisko']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtNazwisko']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td width="50"><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwisko']['label']; ?>
</div></td>
		<td><div class="font"><?php echo $this->_tpl_vars['form']['txtNazwisko']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNazwisko']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNIP']['error'] != ''): ?>
	<tr><td colspan="2">
		<font color="red" size="2"><?php echo $this->_tpl_vars['form']['txtNIP']['error']; ?>
</font>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNIP']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNIP']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNIP']['required']): ?>*<?php endif; ?></div></td></tr>
			
	<?php if ($this->_tpl_vars['form']['txtUlica']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtUlica']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td  width="50"><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtUlica']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtUlica']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrDomu']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtNrDomu']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrDomu']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrDomu']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtNrMieszkania']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrMieszkania']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrMieszkania']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtKodPocztowy']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtKodPocztowy']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtKodPocztowy']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtMiasto']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtMiasto']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtMiasto']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtMiasto']['required']): ?>*<?php endif; ?></div></td></tr>

	<?php if ($this->_tpl_vars['form']['selKraj']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['selKraj']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selKraj']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selKraj']['html']; ?>
</div></td></tr>
	

	<?php if ($this->_tpl_vars['form']['txtEmail']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtEmail']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtEmail']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtEmail']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtEmail']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['txtEmail2']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtEmail2']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtEmail2']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtEmail2']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtEmail2']['required']): ?>*<?php endif; ?></div></td></tr>
	
	
	<?php if ($this->_tpl_vars['form']['txtNrTel']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['txtNrTel']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['txtNrTel']['html']; ?>
<?php if ($this->_tpl_vars['form']['txtNrTel']['required']): ?>*<?php endif; ?></div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['selFaktura']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['selFaktura']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td><div class="font"><?php echo $this->_tpl_vars['form']['selFaktura']['label']; ?>
</div></td><td><div class="font"><?php echo $this->_tpl_vars['form']['selFaktura']['html']; ?>
</div></td></tr>
	
	<?php if ($this->_tpl_vars['form']['chkZgoda']['error'] != ''): ?>
	<tr><td colspan="2">
		<div class="bordo"><?php echo $this->_tpl_vars['form']['chkZgoda']['error']; ?>
</div>
	</td></tr>
	<?php endif; ?>
	<tr><td   size="2" ><div class="font"><?php echo $this->_tpl_vars['form']['chkZgoda']['html']; ?>
</div></td><td width="300"><font size="1"><div class="font"><?php echo $this->_tpl_vars['form']['chkZgoda']['label']; ?>
<br/> Akceptuję <a href="/regulamin/regulamin.pdf">regulamin</a> e-sklepu Finka.pl. <br/> <tagValue name="txtChkZgoda" value="Wyrażam zgodę na przetwarzanie danych, w rozumieniu ustawy z dnia 29 sierpnia 1997 roku o ochronie danych osobowych (Dz. U. Nr 133 poz. 883 z 1997 roku), dla celów marketingowych TIK-SOFT Sp. zoo. Przysługuje Pani/Panu prawo do wglądu i poprawiania danych. TIK-SOFT Sp.z o.o. oświadcza, że podane dane nie zostaną w żadnej formie udostępnione osobom trzecim.</div></td></tr>
	<tr><td colspan="2" align="center" width="100%"><?php echo $this->_tpl_vars['form']['btnReset']['html']; ?>
<?php echo $this->_tpl_vars['form']['btnSubmit']['html']; ?>
</tD></tr>
</table>
</td></tr></table>
</form>