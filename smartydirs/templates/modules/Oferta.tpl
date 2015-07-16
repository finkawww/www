<center>
{$nazwaGrupy}
<br/>
{$nazwaOferty}

<table align="center">
<tr><td width="300"><b>Opis</b></td><td width="50" align="right"><div class="font"><b>Rabat</b></td><td width="80" align="right"><b>Cena</b></td><td align="center" width="50"><b>Kup</b></td></tr>
{foreach from=$towar item=towarItem name=towar}
	<tr>
		<td>{$towarItem->opisTowaru}</td>
		<td align="right">{if $towarItem->rabat eq 0} {else}{$towarItem->rabat}{/if}</td>
		<td align="right"><div class="font">{$towarItem->cenaTowaru}</td>
		<td align="center"><a href="?a={$towarItem->actionDoKoszyka}&towarId={$towarItem->idTowaru}"><img src="/FrontPage/Files/Img/koszyk_small.jpg" border="0"/></a></td>
	</tr>
	
{/foreach}
<br>
<table>

</center>  