
{foreach from=$langItems item=langItem name=langItems}
<!-- <td>{$langItem->opis}</td> --><a href="?a={$actionSetLang}&idLang={$langItem->id}" border="0"><img src="{$langItem->icon}" border="0"></a>
{/foreach}
