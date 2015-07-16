<html>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="../Cms/Style/style.css" />
</head>
<body bgcolor=#666666>
<!-- CMS frame table #DDDDC0-->
	<table class=tblPageFrm align=center cellspacing="0" cellpadding="0">
		<tbody valign="top">
			<tr><td valign="top">
				<img src="../Cms/Files/Img/cmstitle.jpg" border="0">
			</td></tr>
			<tr><td valign="top">
				<table border=0 width=1024 height="100%" valign="top">
					<tr>
					<td align=left valign=top Height=600>
						<!-- User -->
						<table class=tblLeftMenu cellspacing=0 valign=top>
							<tr class=header><td colspan=2 align=left>
								<table cellspacing=0 cellpadding=0 border=0>
								<tr class=header>
									<td align=left><img src="../Cms/Files/Img/user-24x24.png"/></td>
									<td>Użytkownik</td>
								</tr>
								</table>
								</td></tr>
							<tr>
								<td width="50%" align="right"><div class="leftmenu">Login:</div></td>
								<td width="*" align="left"><div class="leftmenuBold">Admin</div></td>
							</tr>
							<tr>
								<td align="right"><div class="leftmenu">Imię:</div></td>
								<td></td>
							</tr>
							<tr>
								<td align="right"><div class="leftmenu">Nazwisko:</div></td>
								<td></td>
							</tr>
							<tr>
								<td align="right"><div class="leftmenu">Sesja od:</div></td>
								<td></td>
							</tr>
						</table>
						<br/>
						<!-- Menu left table -->
						<table class=tblLeftMenu border = 0 cellspacing=0 valign=top cellpadding=0>
							<tr class=header>
								<td width="10" align=left>
									<img src="../Cms/files/img/process-24x24.png" border="0">
								</td>
								<td align=left width=190>
									Menu
								</td>
							</tr>
							<tr><td colspan=2>{$menu_left}</td></tr>
							<tr><td width=10>
								<img src="../Cms/files/img/exit.gif" border="0">
							</td><td align=left>
								<a href="?a={$logoutAct}" class="leftmenu">Logout</a></td></tr>
						</table>
					</td>
					<td align=left width=100% height = 100% valign="top">
					<!-- Content table -->
						<table class=tblContent valign=top width=100% height="100%" cellspacing=0 border=0>
							<tr class=header>
								<td width=25>
									<img src="../Cms/Files/Img/info-24x24.png" width=24 height=24 />
								</td>
								<td>
									{$contentHeader}
								</td>
							</tr>
							<tr>
								<td valign=top colspan=2>
									{$content}								
							</td></tr>
						</table>
					</td>
					</tr>
				</table>
			</td></tr>
		</tbody>
	</table>
</body>
</html>
