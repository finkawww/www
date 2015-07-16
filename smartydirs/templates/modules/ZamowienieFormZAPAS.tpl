<form {$form.attributes}
{$form.hidden}
<table>
	<tr><td colspan="2">{$form.hdrTest.html}</td></tr>
	{if {$form.Przykladowe.error} ne ''}
	<tr><td>
		{$form.Przykladowe.error}
	</td></tr>
	{/if}
	<tr><td>{$form.Przykladowe.label}</td><td>{$form.Przykladowe.html}</td></tr>
	<tr><td>{$form.btnReset.html}</td><td>{$form.btnSubmit.html}</tD></tr>
</table>
</form>