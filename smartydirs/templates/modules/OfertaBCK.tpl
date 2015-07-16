<center>
{foreach from=$towar item=towarItem name=towar}
	{if $smarty.foreach.towar.index+1 is div by 4}
		<br>
	{else}
	<span class="towViewOferta">
		  <a href="{$towarItem->obrazFull}"	rel="lightbox[$idOferty]" title={$towarItem->nazwaTowaru} alt="coś tam">
		  	<img src="{$towarItem->obrazMin}" width="125" height="83"/>
		  </a>	
	</span>
	{/if}
{/foreach}
<br>

{foreach from=$pages item=pagesItem name=pages}
	{if $pagesItem eq $actualPage}
		{$pagesItem}
	{else}
		<a href="?a={$nextPageAct}&idOferty={$idOferty}&nrStrony={$pagesItem}">{$pagesItem}</a>
	{/if}
{/foreach}
</center>