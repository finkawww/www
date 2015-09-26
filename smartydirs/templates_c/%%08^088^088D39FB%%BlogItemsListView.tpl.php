<?php /* Smarty version 2.6.17, created on 2015-08-31 16:17:18
         compiled from modules/BlogItemsListView.tpl */ ?>
<div class="blog">
    <?php $_from = $this->_tpl_vars['blogItemsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blogItemsArray'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blogItemsArray']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['blogItem']):
        $this->_foreach['blogItemsArray']['iteration']++;
?>
    <div class="blogItem">
        <div class="blogItemHeader">
            <h1><?php echo $this->_tpl_vars['blogItem']->GetTitle(); ?>
</h1>
            <small>Data publikacji: <?php echo $this->_tpl_vars['blogItem']->GetDate(); ?>
</small>
        </div>
        <div class="blogItemContent">
            <p><?php echo $this->_tpl_vars['blogItem']->GetHeadline(); ?>
</p>
        </div>
        <div class="blogItemFooter">
           
            <?php if (( $this->_tpl_vars['blogItem']->GetContentIsLink() )): ?>
               <small><a href="/<?php echo $this->_tpl_vars['blogItem']->GetContent(); ?>
">Więcej..</a></small>
            <?php else: ?>
               <small><a href="/?a=<?php echo $this->_tpl_vars['itemViewAction']; ?>
&name=<?php echo $this->_tpl_vars['blogItem']->GetName(); ?>
<?php echo $this->_tpl_vars['mpId']; ?>
">Więcej..</a></small>
            <?php endif; ?>
           
        </div>
        <div class="toolbar">
            
        </div>
    </div>
            <hr/>
    <?php endforeach; endif; unset($_from); ?>
</div>