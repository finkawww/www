<?php /* Smarty version 2.6.17, created on 2015-07-30 14:55:59
         compiled from menuBottom.tpl */ ?>
<hr/>
<?php $_from = $this->_tpl_vars['menuBottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuBottom'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuBottom']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuItem']):
        $this->_foreach['menuBottom']['iteration']++;
?>
	<?php if ($this->_tpl_vars['menuItem']->active): ?>
	<?php if ($this->_tpl_vars['menuItem']->sel == 1): ?>
		<a class="menuItem" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>&nbsp;&nbsp;&nbsp;|
	<?php else: ?>
		<a class="menuItem" href="<?php echo $this->_tpl_vars['menuItem']->menuRenderText; ?>
"><?php echo $this->_tpl_vars['menuItem']->caption; ?>
</a>&nbsp;&nbsp;&nbsp;|
	<?php endif; ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<br/><br/>
<?php echo '
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
'; ?>

	<div id="bottom-wrap">
			<div class="granat-bottom">
			<img src="./FrontPage/Files/Img/logo_tiksoft.jpg">&nbsp;&nbsp;
			E-mail: <a href="mailto:finka@finka.pl">finka@finka.pl</a>&nbsp;&nbsp; 
			tel.22 408 48 00&nbsp;&nbsp;
			Copyright 1990-2015&nbsp;&nbsp;<br>
			</div>

			<div class="fb-like-box" data-href="https://www.facebook.com/programyFINKA" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true"></div>
	</div>