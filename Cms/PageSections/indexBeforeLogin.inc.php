<?php
echo "
<html>
	<title></title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	<link rel=\"stylesheet\" type=\"text/css\" href=\"../Cms/Style/style.css\" />
</head>
<body>
<!-- CMS frame table #DDDDC0-->
						<table valign=top width=100% height=100%>
								<tr><td valign=top>";
								$content = $contentRnd->renderContent($m, $a);
								echo $content;
							echo 
							"</td></tr>
						</table>
</body>
</html>";
?>