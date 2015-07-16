{if $id eq '0'}
<input type="button" value="{$clickTxt}" onClick="document.location.href='?a={$clickAct}'">
{else}
<a href="?a={$clickAct}">Zalogowany jako <b>{$login}</b></a>
<input type="button" value="{$clickTxt}" onClick="document.location.href='?a={$wylogujAction}'">
{/if}
 
