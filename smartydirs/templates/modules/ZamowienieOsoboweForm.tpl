<form {$form.attributes}>
{$form.hidden}
<table border="0" width="500"  align="justify"><tr><td>
<table width="100%" align="justify">
	<tr><td colspan="2" width="100%"><div class="granat">{$form.header.hdr}</div><br/></td></tr>
	
	
	{if $form.txtImie.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtImie.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtImie.label}</div></td><td><div class="font">{$form.txtImie.html}{if $form.txtImie.required}*{/if}</div></td></tr>
	
	{if $form.txtNazwisko.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtNazwisko.error}</div>
	</td></tr>
	{/if}
	<tr><td width="50"><div class="font">{$form.txtNazwisko.label}</div></td>
		<td><div class="font">{$form.txtNazwisko.html}{if $form.txtNazwisko.required}*{/if}</div></td></tr>
	
	{if $form.txtNIP.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2">{$form.txtNIP.error}</font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNIP.label}</div></td><td><div class="font">{$form.txtNIP.html}{if $form.txtNIP.required}*{/if}</div></td></tr>
			
	{if $form.txtUlica.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtUlica.error}</div>
	</td></tr>
	{/if}
	<tr><td  width="50"><div class="font">{$form.txtUlica.label}</div></td><td><div class="font">{$form.txtUlica.html}{if $form.txtUlica.required}*{/if}</div></td></tr>
	
	{if $form.txtNrDomu.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtNrDomu.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrDomu.label}</div></td><td><div class="font">{$form.txtNrDomu.html}{if $form.txtNrDomu.required}*{/if}</div></td></tr>
	
	{if $form.txtNrMieszkania.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtNrMieszkania.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrMieszkania.label}</div></td><td><div class="font">{$form.txtNrMieszkania.html}{if $form.txtNrMieszkania.required}*{/if}</div></td></tr>
	
	{if $form.txtKodPocztowy.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtKodPocztowy.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtKodPocztowy.label}</div></td><td><div class="font">{$form.txtKodPocztowy.html}{if $form.txtKodPocztowy.required}*{/if}</div></td></tr>
	
	{if $form.txtMiasto.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtMiasto.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtMiasto.label}</div></td><td><div class="font">{$form.txtMiasto.html}{if $form.txtMiasto.required}*{/if}</div></td></tr>

	{if $form.selKraj.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.selKraj.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selKraj.label}</div></td><td><div class="font">{$form.selKraj.html}</div></td></tr>
	

	{if $form.txtEmail.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtEmail.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtEmail.label}</div></td><td><div class="font">{$form.txtEmail.html}{if $form.txtEmail.required}*{/if}</div></td></tr>
	
	{if $form.txtEmail2.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtEmail2.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtEmail2.label}</div></td><td><div class="font">{$form.txtEmail2.html}{if $form.txtEmail2.required}*{/if}</div></td></tr>
	
	
	{if $form.txtNrTel.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.txtNrTel.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.txtNrTel.label}</div></td><td><div class="font">{$form.txtNrTel.html}{if $form.txtNrTel.required}*{/if}</div></td></tr>
	
	{if $form.selFaktura.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.selFaktura.error}</div>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selFaktura.label}</div></td><td><div class="font">{$form.selFaktura.html}</div></td></tr>
	
	{if $form.chkZgoda.error ne ''}
	<tr><td colspan="2">
		<div class="bordo">{$form.chkZgoda.error}</div>
	</td></tr>
	{/if}
	<tr><td   size="2" ><div class="font">{$form.chkZgoda.html}</div></td><td width="300"><font size="1"><div class="font">{$form.chkZgoda.label}<br/> Akceptuję <a href="/regulamin/regulamin.pdf">regulamin</a> e-sklepu Finka.pl. <br/> <tagValue name="txtChkZgoda" value="Wyrażam zgodę na przetwarzanie danych, w rozumieniu ustawy z dnia 29 sierpnia 1997 roku o ochronie danych osobowych (Dz. U. Nr 133 poz. 883 z 1997 roku), dla celów marketingowych TIK-SOFT Sp. zoo. Przysługuje Pani/Panu prawo do wglądu i poprawiania danych. TIK-SOFT Sp.z o.o. oświadcza, że podane dane nie zostaną w żadnej formie udostępnione osobom trzecim.</div></td></tr>
	<tr><td colspan="2" align="center" width="100%">{$form.btnReset.html}{$form.btnSubmit.html}</tD></tr>
</table>
</td></tr></table>
</form>
