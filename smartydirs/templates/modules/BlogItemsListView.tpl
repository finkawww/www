<div class="blog">
    {foreach from=$blogItemsArray item=blogItem name=blogItemsArray}
    <div class="blogItem">
        <div class="blogItemHeader">
            <h2 class="blog-list-header"><a href="/{$blogItem->GetContent()}">{$blogItem->GetTitle()}</a></h2>
            <small>Data publikacji: {$blogItem->GetDate()}</small>
        </div>
        <div class="blogItemContent">
            <p>{$blogItem->GetHeadline()}</p>
        </div>
        <div class="blogItemFooter">
           
            {if ($blogItem->GetContentIsLink())}
               <small><a rel = "nofollow" href="/{$blogItem->GetContent()}">Więcej..</a></small>
            {else}
               <small><a rel = "nofollow" href="/?a={$itemViewAction}&name={$blogItem->GetName()}{$mpId}">Więcej..</a></small>
            {/if}
           
        </div>
        <div class="toolbar">
            
        </div>
    </div>
            <hr/>
    {/foreach}
</div>