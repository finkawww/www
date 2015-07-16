<?php /* Smarty version 2.6.17, created on 2010-06-26 13:23:12
         compiled from ./cms/cmsIndex.tpl */ ?>
﻿<!-- CMS main page -->
<html>
	<title>System CMS</title>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../Cms/Style/style.css" />
	</head>	
	<body bgcolor=#666666>
		<!-- CMS frame table #DDDDC0-->
		<table class=tblPageFrm align=center cellspacing="0" cellpadding="0">
		<tbody valign="top">
			<tr><td valign="top">
				<img src="../Cms/Files/Img/cmstitle.jpg" border=0>
			</td></tr>
			<tr><td valign="top">
				<table border="0" width="1024" height="100%" valign="top">
					<tr>
					<td align="left" valign="top" Height="600">
						<!-- User -->
						<table class="tblLeftMenu" cellspacing="0" valign=top>
							<tr class=header colospan="2"><td align=center colspan="2">.::.Użytkownik.::.</td></tr>
							<tr>
								<td width="50%" align="right"><div class="loginInfoBold">Login:</div></td>
								<td width="*" align="left"><div class="loginInfo"><?php echo $this->_tpl_vars['adminLogin']; ?>
</div></td>
							</tr>
							<tr>
								<td align="right"><div class="loginInfoBold">Imię:</div></td>
								<td width="*" align="left"><div class="loginInfo"><?php echo $this->_tpl_vars['adminName']; ?>
</div></td>
							</tr>
							<tr>
								<td align="right"><div class="loginInfoBold">Nazwisko:</div></td>
								<td width="*" align="left"><div class="loginInfo"><?php echo $this->_tpl_vars['adminLastName']; ?>
</div></td>
							</tr>
							<tr>
								<td align="right"><div class="loginInfoBold">Sesja od:</div></td>
								<td width="*" align="left"><div class="loginInfo"><?php echo $this->_tpl_vars['adminSessionBegin']; ?>
</div></td>
							</tr>
						</table>
						<br/>
						<!-- Menu left table -->
						<table class="tblLeftMenu" cellspacing="0" valign="top">
							<tr class="header"><td align="center">.::.Menu.::.</td></tr>
							<tr><td><?php echo $this->_tpl_vars['menu_left']; ?>
</td></tr>
							<tr><td valign="center"><img src="../Cms/Files/Img/exit.gif" border="0"><a href="?a=<?php echo $this->_tpl_vars['logoutAct']; ?>
" class="leftmenu">Logout</a></td></tr>
						</table><br/>
						<!-- <table align="center" border=1>
							<tr><td width="50" align="center"><img src="http://www.smarty.net/gifs/smarty_icon.gif" /></td></tr>
							<tr><td width="50" align="center"><img src="../Cms/Files/Img/pear-power.png" /></td></tr>
						</table>-->
						
					</td>
					<td align=left width=100% height = 100% valign="top">
					<!-- Content table -->
						<table class=tblContent valign=top width=100% height="100%">
							<tr class=header><td><?php echo $this->_tpl_vars['contentHeader']; ?>
</td></tr>
							<tr>
								<td valign=top>
								<?php echo $this->_tpl_vars['content']; ?>

								</td>
							</tr>
						</table>
					</td>
					</tr>
				</table>
			</td></tr>
			</tbody>
		</table>

	</body>
</html>