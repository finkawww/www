<?php /* Smarty version 2.6.17, created on 2011-08-11 00:20:53
         compiled from modules/LangStatus.tpl */ ?>

<?php $_from = $this->_tpl_vars['langItems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['langItems'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['langItems']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['langItem']):
        $this->_foreach['langItems']['iteration']++;
?>
<!-- <td><?php echo $this->_tpl_vars['langItem']->opis; ?>
</td> --><a href="?a=<?php echo $this->_tpl_vars['actionSetLang']; ?>
&idLang=<?php echo $this->_tpl_vars['langItem']->id; ?>
" border="0"><img src="<?php echo $this->_tpl_vars['langItem']->icon; ?>
" border="0"></a>
<?php endforeach; endif; unset($_from); ?>