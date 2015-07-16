<table class="leftMenuContainer">
{assign var='tmpGroup' value='X'}
{foreach from=$menuLeft item=menuItem name=menuLeft}

{if $menuItem->active}
    {if $menuItem->grupa eq $tmpGroup}
    <tr>
		<td>	
		{if $menuItem->level eq 1}
		
		{elseif $menuItem->level eq 2}
		<span minwidth="100px" align="right"><img src="../Cms/Files/Img/corner-dots.gif" border="0"></span>
		{/if}
		{if $menuItem->sel eq 1}
			<a class="inactiveMenuLeft" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
		{else}
			<a class="activeMenuLeft" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
		{/if}
		</td>
	</tr>
	{else}
		{assign var='tmpGroup' value=$menuItem->grupa}</span>
		<tr><td><span class="activeMenu">{$tmpGroup}</span></td></tr>
		<tr>
			<td>
			{if $activeMenu->level eq 1}
			
			{elseif $activeMenu->level eq 2}
			<span minwidth="100px" align="right"><img src="../Cms/Files/Img/corner-dots.gif" border="0"></span>
		{/if}
		
		{if $menuItem->sel eq 1}
				<a class="inactiveMenuLeft" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
		{else}
				<a class="activeMenuLeft" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>
		{/if}

		  	</td>
		</tr> 
	{/if}  
{/if} 
{/foreach}

</table>