<center>
<form {$form.attributes}>
{$form.hidden}
<table border="0" width="600">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="justify"><div class="granat">{$form.header.hdr}</div></td></tr>
	
	{if $form.txtNazwa.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2">{$form.txtNazwa.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNazwa.label}</div></td><td><div class="font">{$form.txtNazwa.html}{if $form.txtNazwa.required}*{/if}</div></td></tr>
	
	
	{if $form.selKraj.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.selKraj.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selKraj.label}</div></td><td><div class="font">{$form.selKraj.html}</div></td></tr>
	
	{if $form.txtKodPocztowy.error ne ''}
	<tr><td colspan="2">
		<font size="2"><div class="bordo">{$form.txtKodPocztowy.error}</div></font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtKodPocztowy.label}</div></td><td><div class="font">{$form.txtKodPocztowy.html}{if $form.txtKodPocztowy.required}*{/if}</div></td></tr>
	
	{if $form.txtMiasto.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2">{$form.txtMiasto.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtMiasto.label}</div></td><td><div class="font">{$form.txtMiasto.html}{if $form.txtMiasto.required}*{/if}</div></td></tr>
	
	{if $form.txtUlica.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2"><div class="bordo">{$form.txtUlica.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtUlica.label}</div></td><td><div class="font">{$form.txtUlica.html}{if $form.txtUlica.required}*{/if}</div></td></tr>
	
	{if $form.txtNrDomu.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2"><div class="font">{$form.txtNrDomu.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrDomu.label}</div></td><td><div class="font">{$form.txtNrDomu.html}{if $form.txtNrDomu.required}*{/if}</div></td></tr>
	
	{if $form.txtNrMieszkania.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2">{$form.txtNrMieszkania.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrMieszkania.label}</div></td><td><div class="font">{$form.txtNrMieszkania.html}{if $form.txtNrMieszkania.required}*{/if}</div></td></tr>
	
	<tr><td><div class="font">{$form.txtNrTel.label}</div></td><td><div class="font">{$form.txtNrTel.html}{if $form.txtNrTel.required}*{/if}</div></td></tr>
	
	{if $form.selFaktura.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2">{$form.selFaktura.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selFaktura.label}</div></td><td><div class="font">{$form.selFaktura.html}</div></td></tr>
	
		
	<tr><td colspan="2" align="center">{$form.btnReset.html}{$form.btnSubmit.html}</tD></tr>
</table>
</td></tr></table>
</form>
</center>