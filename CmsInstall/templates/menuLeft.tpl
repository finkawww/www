{foreach from=$menuLeft item=menuItem name=menuLeft}
	{if $menuItem->level eq 1}
		
	{elseif $menuItem->level eq 2}
		<span minwidth="100px" align="right"><img src="../Cms/Files/Img/corner-dots.gif" borger="0"></span>		
	{elseif $menuItem->level eq 3}
		<span width="150px">&nbsp;</span><img src="../Cms/Files/Img/corner-dots.gif" borger="0">
	{elseif $menuItem->level eq 4}
		<span width=200px">&nbsp;</span><img src="../Cms/Files/Img/corner-dots.gif" borger="0">
	{/if}
		
	{if $menuItem->sel eq 1}
		{$menuItem->caption}
	{else}
		<a class="menuLeft" href="?m={$menuItem->id}">{$menuItem->caption}</a>
	{/if}
		
	<br />
{/foreach}