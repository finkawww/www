<table class="rightMenuContainer">
{foreach from=$menuRight item=menuItem name=menuRight}
	
	{if $menuItem->sel eq 1}
	<tr><td width="210px">
		<a class="menuItem" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
	</td></tr>
	{else}
	<tr><td width="210px">
		<a class="menuItem" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
	</td></tr>
	{/if}
{/foreach}
</table>