<table width="620" border="0" cellspacing="15> 
{foreach from=$aktItems item=aktItem name=aktItems}
	<tr>
		<td width="620" align="left"><div class="granat">{$aktItem->program} {$aktItem->wersja} | {$aktItem->data}</div></td>
	</tr>
	<tr>
		<td colspan="2" width="620">
			{$aktItem->opis}
		</td>
	</tr>
{/foreach}
<tr>
	<td align="center" colspan="2">
		{foreach from=$pages item=pagesItem name=pages}
		{if $pagesItem eq $actualPage}
			{$pagesItem}
		{else}
			<a href="?page={$pagesItem}">{$pagesItem}</a>
		{/if}
		{/foreach}		
	</td>
</tr>
</table>
