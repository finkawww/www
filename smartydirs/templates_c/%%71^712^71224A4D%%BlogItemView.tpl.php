<?php /* Smarty version 2.6.17, created on 2015-08-31 16:17:19
         compiled from modules/BlogItemView.tpl */ ?>
<div class="blogItem">
    <div class="blogItemHeader">
        <div class="title"><?php echo $this->_tpl_vars['blogItem']->GetTitle(); ?>
</div>
        <small>Data publikacji: <?php echo $this->_tpl_vars['blogItem']->GetDate(); ?>
</small>
    </div>
    <div class="blogItemContent">
        <p>
        <?php echo $this->_tpl_vars['blogItem']->GetContent(); ?>

        </p>
    </div>    
    <div class="blogItemFooter">
        <a href="?a=<?php echo $this->_tpl_vars['bckAction']; ?>
&category=<?php echo $this->_tpl_vars['blogItem']->GetCategory(); ?>
<?php echo $this->_tpl_vars['mpId']; ?>
">Powrót</a>
    </div>
</div>