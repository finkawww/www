<?php /* Smarty version 2.6.17, created on 2011-08-10 23:52:46
         compiled from modules/KlientStatus.tpl */ ?>
<?php if ($this->_tpl_vars['id'] == '0'): ?>
<input type="button" value="<?php echo $this->_tpl_vars['clickTxt']; ?>
" onClick="document.location.href='?a=<?php echo $this->_tpl_vars['clickAct']; ?>
'">
<?php else: ?>
<a href="?a=<?php echo $this->_tpl_vars['clickAct']; ?>
">Zalogowany jako <b><?php echo $this->_tpl_vars['login']; ?>
</b></a>
<input type="button" value="<?php echo $this->_tpl_vars['clickTxt']; ?>
" onClick="document.location.href='?a=<?php echo $this->_tpl_vars['wylogujAction']; ?>
'">
<?php endif; ?>
 