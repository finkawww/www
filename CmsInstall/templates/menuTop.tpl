{foreach from=$menuTop item=menuItem name=menuTop}
	{if $menuItem->sel eq 1}
		{$menuItem->caption}
	{else}
		<a class="menuTop" href="?m={$menuItem->id}">{$menuItem->caption}</a>
	{/if}
{/foreach}