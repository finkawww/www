<div class="blogItem">
    <div class="blogItemHeader">
        <div class="title">{$blogItem->GetTitle()}</div>
        <small>Data publikacji: {$blogItem->GetDate()}</small>
    </div>
    <div class="blogItemContent">
        <p>
        {$blogItem->GetContent()}
        </p>
    </div>    
    <div class="blogItemFooter">
        <a href="?a={$bckAction}&category={$blogItem->GetCategory()}{$mpId}">Powrót</a>
    </div>
</div>