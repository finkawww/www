<center>
<form {$form.attributes}>
{$form.hidden}
<table width="400" border="0">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="center"><div class="granat">{$form.header.hdr}</div><br></td></tr>
	
	{if $form.txtImie.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtImie.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtImie.label}</div></td><td><div class="font">{$form.txtImie.html}{if $form.txtImie.required}*{/if}</div></td></tr>
	
	{if $form.txtNazwisko.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtNazwisko.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNazwisko.label}</div></td><td><div class="font">{$form.txtNazwisko.html}{if $form.txtNazwisko.required}*{/if}</div></td></tr>
	
	{if $form.selKraj.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.selKraj.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selKraj.label}</div></td><td><div class="font">{$form.selKraj.html}</div></td></tr>
		
	{if $form.txtKodPocztowy.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtKodPocztowy.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtKodPocztowy.label}</div></td><td><div class="font">{$form.txtKodPocztowy.html}{if $form.txtKodPocztowy.required}*{/if}</div></td></tr>
	
	{if $form.txtMiasto.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtMiasto.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtMiasto.label}</div></td><td><div class="font">{$form.txtMiasto.html}{if $form.txtMiasto.required}*{/if}</div></td></tr>
	
	{if $form.txtUlica.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtUlica.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtUlica.label}</div></td><td><div class="font">{$form.txtUlica.html}{if $form.txtUlica.required}*{/if}</div></td></tr>
	
	{if $form.txtNrDomu.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtNrDomu.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrDomu.label}</div></td><td><div class="font">{$form.txtNrDomu.html}{if $form.txtNrDomu.required}*{/if}</div></td></tr>
	
	{if $form.txtNrMieszkania.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtNrMieszkania.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrMieszkania.label}</div></td><td><div class="font">{$form.txtNrMieszkania.html}</div></td></tr>
	
	<tr><td><div class="font">{$form.txtNrTel.label}<font></td><td><div class="font">{$form.txtNrTel.html}</div></td></tr>
	
	{if $form.selFaktura.error ne ''}
	<tr><td>
		<font size="2"><div class="bordo">{$form.selFaktura.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selFaktura.label}</div></td><td><div class="font">{$form.selFaktura.html}</div></td></tr>
	
		
	<tr><td colspan="2" align="center">{$form.btnReset.html}{$form.btnSubmit.html}</tD></tr>
</table>
</td></tr></table>
</form>
</center>