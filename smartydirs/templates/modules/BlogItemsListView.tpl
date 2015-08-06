<div class="blog">
    {foreach}
    <div class="blogItem">
        <div class="blogItemHeader">
            <div class="title">{$title}</div>
        </div>
        <div class="blogItemContent">
            {$content}
        </div>
        <div class="blogItemFooter">
            <small>{$author}</small>
        </div>
        <div class="toolbar">
            {$bckAction}
        </div>
    </div>
    {/foreach}
</div>