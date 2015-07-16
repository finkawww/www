<?php
echo "
<!-- CMS main page -->
<html>
	<title></title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	<link rel=\"stylesheet\" type=\"text/css\" href=\"../Cms/Style/style.css\" />
</head>
<body bgcolor=#666666>
<!-- CMS frame table #DDDDC0-->
	<table class=tblPageFrm align=center cellspacing=\"0\" cellpadding=\"0\">
		<tbody valign=\"top\">
			<tr><td valign=\"top\">
				<img src=\"../Cms/Files/Img/cmstitle.jpg\" border=0>
			</td></tr>
			<tr><td valign=\"top\">
				<table border=0 width=1024 height=\"100%\" valign=\"top\">
					<tr>
					<td align=left valign=top Height=600>
						<!-- User -->
						<table class=tblLeftMenu cellspacing=0 valign=top>
							<tr class=header colospan=\"2\"><td align=center colspan=\"2\">.::.Użytkownik.::.</td></tr>
							<tr>
								<td width=\"50%\" align=\"right\"><div class=\"leftmenu\">Login:</div></td>
								<td width=\"*\" align=\"left\"><div class=\"leftmenuBold\">Admin</div></td>
							</tr>
							<tr>
								<td align=\"right\"><div class=\"leftmenu\">Imię:</div></td>
								<td></td>
							</tr>
							<tr>
								<td align=\"right\"><div class=\"leftmenu\">Nazwisko:</div></td>
								<td></td>
							</tr>
							<tr>
								<td align=\"right\"><div class=\"leftmenu\">Sesja od:</div></td>
								<td></td>
							</tr>
						</table>
						<br/>
						<!-- Menu left table -->
						<table class=tblLeftMenu cellspacing=0 valign=top>
							<tr class=header><td align=center>.::.Menu.::.</td></tr>
							<tr><td>$menu_left</td></tr>
							<tr><td valign=\"center\"><img src=\"../Cms/files/img/exit.gif\" border=\"0\"><a href=\"?a=$logoutAct\" class=\"leftmenu\">Logout</a></td></tr>
						</table>
					</td>
					<td align=left width=100% height = 100% valign=\"top\">
					<!-- Content table -->
						<table class=tblContent valign=top width=100% height=\"100%\">
							<tr class=header><td>$contentHeader</td></tr>
							<tr><td valign=top>";
								$content = $contentRnd->renderContent($m, $a);
								echo $content;
							echo 
							"</td></tr>
						</table>
					</td>
					</tr>
				</table>
			</td></tr>
		</tbody>
	</table>
</body>
</html>";
?>