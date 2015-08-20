<hr/>
{foreach from=$menuBottom item=menuItem name=menuBottom}
	{if $menuItem->active}
	{if $menuItem->sel eq 1}
		<a class="menuItem" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>&nbsp;&nbsp;&nbsp;|
	{else}
		<a class="menuItem" href="{$menuItem->menuRenderText}">{$menuItem->caption}</a>&nbsp;&nbsp;&nbsp;|
	{/if}
	{/if}
{/foreach}
<br/><br/>
{literal}
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{/literal}
	<div id="bottom-wrap">
			<div class="granat-bottom">
			<img src="/./FrontPage/Files/Img/logo_tiksoft.jpg">&nbsp;&nbsp;
			E-mail: <a href="mailto:finka@finka.pl">finka@finka.pl</a>&nbsp;&nbsp; 
			tel.22 408 48 00&nbsp;&nbsp;
			Copyright 1990-2015&nbsp;&nbsp;<br>
			</div>

			<div class="fb-like-box" data-href="https://www.facebook.com/programyFINKA" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true"></div>
	</div>
