<ul id="menu">
{foreach from=$menuTop item=menuItem name=menuTop}

		{if $menuItem->parentMenu == NULL}
		<li><a class="activeMenu" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a><span class="activeMenu"> |</span>
		{if $menuItem->child}
			<ul class="submenu">
			{foreach from=$menuItem->child item=child name=childItem}
				<li><a class="activeMenu submenu-header" href="/{$child.MenuLinkText}">{$child.Name}</a>
					{if $child.child}
					<ul class="next-submenu">
						{foreach from=$child.child item=secondChild}
							<li><a class="activeMenu" href="/{$secondChild.MenuLinkText}">{$secondChild.Name}</a></li>
						{/foreach}
						</ul>
					{/if}
				</li>
			{/foreach}
			</ul>
		</li>
		{/if}		
	{/if}
	

{/foreach}
</ul>

