<?php /* Smarty version 2.6.17, created on 2015-07-13 09:40:28
         compiled from default_bez_niczego.tpl */ ?>

<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="<?php echo $this->_tpl_vars['keywords']; ?>
" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="<?php echo $this->_tpl_vars['author']; ?>
" />
    	<META NAME="Robots" CONTENT="<?php echo $this->_tpl_vars['robots']; ?>
" />
    	<META HTTP-EQUIV="Pragma" CONTENT="<?php echo $this->_tpl_vars['cache']; ?>
" />
    	<META NAME="Description" CONTENT="<?php echo $this->_tpl_vars['desc']; ?>
" />
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE><?php echo $this->_tpl_vars['title']; ?>
</TITLE>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />

		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
    	<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>	
    </HEAD>
	<BODY  bgcolor="white">
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000px">
		
		<tr>
			<td colspan="2" width="100%" align="left" valign="middle">
			<table width="100%">
				<tr>
				<td align="left">				
					 <a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a> 	
				</td>
				<!--
				<td align="right">				
					<a href="/Zmiany_VAT.htm"><img src="/FrontPage/Files/Img/gorna_belka.jpg" border="0"/></a> 	
				</td>
				-->
				</tr>
				<tr>
					<td colspan="2">				
						<?php echo $this->_tpl_vars['topMenu']; ?>
<font face="Tahoma" font color="#454545"><?php echo $this->_tpl_vars['PokazKoszykStatus']; ?>

					</td>
				</tr>
				</table>
			</td>
		</tr>
<!--
		<tr>
			<td colspan="3" >
			<div class="pics" id="banerSlider">
					<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
					<a href="?WersjeProbne.htm"><img src="/FrontPage/Files/Img/baner_gora2.jpg" width="800" border="0"/></a>
					<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>			
			</div>
			</td>	
			<td valign="top"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0"></td>
		</tr>
-->		

		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="210px">	
				<table>
					<tr><td width="210px">
					<?php echo $this->_tpl_vars['leftMenu']; ?>
<br>
					</td></tr>
					<!--
					<tr><td>
						<a href="?mp=103"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0" align="left"></a>
					</td></tr>
					<tr><td><?php echo $this->_tpl_vars['KontaktHeader']; ?>
</td></tr>
					-->	
				</table>	
			</td>
		
		
			<td valign="top" width ="610px" height="500" bgcolor="white">
				<table>
					
					<tr><td><?php echo $this->_tpl_vars['content']; ?>
</td></tr>
				</table>
			</td>
		
	</table>	
	</center>
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br><?php echo $this->_tpl_vars['menuBottom']; ?>
</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></a></td></tr>
</table>
</center>
<?php echo '
<script type="text/javascript">$(\'#banerSlider\').cycle({fx:\'fade\',random:1,delay:-300,width:1000,height:300});</script> 
'; ?>

							
   	</BODY>
</HTML>
