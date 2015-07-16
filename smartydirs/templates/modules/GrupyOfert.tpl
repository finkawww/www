<center>
<table width="450">
{foreach from=$grupa item=ofertaItem name=grupa}
<tr halign="center">
	<td halign="center">
	<img src={$ofertaItem->obraz}>
	</td>
	<td valign="center">
		<a href=?a={$ofertaItem->actionPokazOferte}&idOferty={$ofertaItem->idOferty}>
			{$ofertaItem->opisShort}
		</a>
	</td>
</tr>	
{/foreach}
</table>
</center>