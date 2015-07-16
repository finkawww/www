<?php
	echo"
	<table class=CenterSingleBorder align=center cellspacing=0 celpadding=0 bgcolor=#E0DEEE>
	<tr><td>
		<table width=\"750\" align=\"center\" bgcolor=#E0DEEE>
		<tr><td>";
			include "basicDataFrm.inc.php";
		echo"
		</td></tr>
		<tr><td>
			Sekcje (Read only)
		</td></tr>
		<tr><td>";
			include "readOnlyGridFrm.inc.php";
		echo"
		</td></tr>
		<tr><td>
		<table width = \"100%\">
			<tr><td align = \"right\">
				<input type=\"button\" value=\"Zarządzanie sekcjami\" onClick=\"document.location.href='?a=$action';\ enabled=\"false\">
			</td><tr>
		</table>
		</td></tr>
		</table>
	</td></tr>";
?>