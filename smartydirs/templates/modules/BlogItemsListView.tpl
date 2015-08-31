<div class="blog">
    {foreach from=$blogItemsArray item=blogItem name=blogItemsArray}
    <div class="blogItem">
        <div class="blogItemHeader">
            <h1>{$blogItem->GetTitle()}</h1>
            <small>Data publikacji: {$blogItem->GetDate()}</small>
        </div>
        <div class="blogItemContent">
            <p>{$blogItem->GetHeadline()}</p>
        </div>
        <div class="blogItemFooter">
           
            {if ($blogItem->GetContentIsLink())}
               <small><a href="/{$blogItem->GetContent()}">Więcej..</a></small>
            {else}
               <small><a href="/?a={$itemViewAction}&name={$blogItem->GetName()}{$mpId}">Więcej..</a></small>
            {/if}
           
        </div>
        <div class="toolbar">
            
        </div>
    </div>
            <hr/>
    {/foreach}
</div>