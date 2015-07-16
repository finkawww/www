{foreach from=$menuBottom item=menuItem name=menuBottom}
	{if $menuItem->sel eq 1}
		{$menuItem->caption}
	{else}
		<a class="menuBottom" href="?m={$menuItem->id}">{$menuItem->caption}</a>
	{/if}
{/foreach}