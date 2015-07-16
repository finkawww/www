<center>
<form {$form.attributes}>
{$form.hidden}
<table border="0" width="400">
<tr><td>

<table width="100%">
	<tr><td colspan="2" align="center"><div class="granat">{$form.header.hdr}</div></td></tr>
	{if $form.selPlatnosc.error ne ''}
	<tr><td colspan="2">
		<font color="red" size="2"><div class="font">{$form.selPlatnosc.error}</div></font>
	</td></tr>
	{/if}
	<tr><td><div class="font">{$form.selPlatnosc.label}</div></td><td><div class="font">{$form.selPlatnosc.html}</div></td></tr>
	<!-- opis dostawy -->
	<tr><td><div class="font">{$form.selDostawa.label}</div></td><td><div class="font">{$form.selDostawa.html}</div></td></tr>
	<tr><td><div class="font">{$form.Uwagi.label}</div></td><td><div class="font">{$form.Uwagi.html}</div></td></tr>
	<!--<tr><td>{$form.captcha.label}</td><td>{$form.captcha.html}</td></tr>-->
	<tr><td colspan="2" align="center"><div class="font">{$form.btnReset.html}{$form.btnSubmit.html}</div></tD></tr>
</table>

</td></tr></table>
</form>
</center>