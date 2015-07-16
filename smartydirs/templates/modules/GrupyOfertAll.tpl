<br/>

<table >
<tr>
{foreach from=$grupyOfert item=grupy name=grupyOfert}
{if (($smarty.foreach.grupyOfert.index mod 2) eq 0) && ($smarty.foreach.grupyOfert.index gt 0)}
		{if $smarty.foreach.grupyOfert.index gt 0}</tr>{/if}<tr>
{/if}
	<td>
	<table width="360">
		<tr><td class="cennik_header_DOS" colspan="2"><div class="granat">{$grupy->nazwa}</div></td></tr>
		<tr valign="top"><td width="120"><img src="{$grupy->pict}" border="0" /></td><td align="left" width="240"><br/>{$grupy->opis}</td></tr>
		<tr><td colspan="2" align="right"><a href="?a={$actionPokazOferte}&idGrupy={$grupy->id}"><img src="./images/buy.png" border="0"></a></td></tr>
	</table>
	</td>
{/foreach}
</tr>
</table>
