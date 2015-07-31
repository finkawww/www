<ul id="menu">
{foreach from=$menuTop item=menuItem name=menuTop}
	{if $menuItem->sel eq 1}
		<li><a class="inactiveMenu" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a></li>
	{else}
		<li><a class="activeMenu" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a></li>
	{/if}
{/foreach}
</ul>

