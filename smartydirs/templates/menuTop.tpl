<span>
{foreach from=$menuTop item=menuItem name=menuTop}
	{if $menuItem->sel eq 1}
		<a class="inactiveMenu" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
	{else}
		<a class="activeMenu" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
	{/if}
{/foreach}
</span>

