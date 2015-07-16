<?php
	if (isset($_GET["pageId"]))
	{
		$pageId = $_GET["pageId"];
	}
	else
	{
		$pageId = 0;
	}
	$DBInt = DBSingleton::getInstance();

// danestrony
	$query = "select * from cmsPages where id=$pageId";
   	$result = $DBInt->ExecQuery($query);
   	$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
   
	$pageName = $userData['PageName'];
   	$shortName = $userData['ShortName'];
   	$admin = $userData['Admin'];
   	$authorized = $userData['AuthorizedOnly'];
   	$desc = $userData['Desc'];
 	
   echo "
   <br/>
   	<table class=CenterSingleBorder align=center cellspacing=0 celpadding=0 bgcolor=#E0DEEE width=750>
	<tr><td>
	   	<table border=\"0\">
	   		<tr><td colspan=\"2\"><div class=\"boldText\">Dane strony:</td></tr>
	   		<tr><td><div class=\"boldText\">Nazwa strony:</div></td><td><div class=\"defaultText\">$pageName</td></tr>
	   		<tr><td><div class=\"boldText\">Nazwa techniczna:</div></td><td><div class=\"defaultText\">$shortName</td></tr>
   			<tr><td><div class=\"boldText\">Strona administracyjna:</div></td><td><div class=\"defaultText\">$admin</td></tr>
   			<tr><td><div class=\"boldText\">Wymaga autoryzacji:</div></td><td><div class=\"defaultText\">$authorized</td></tr>
   			<tr><td><div class=\"boldText\">Opis:</div></td><td><div class=\"defaultText\">$desc</td></tr>
  		</table>
  	</td></tr>
  	<tr><td> 
   ";
   

// sekcje


	$query = " select s.id, s.name, s.shortname,
  				Case
    				When s.ContentType = 1 Then \"Moduł\"
    				When s.ContentType = 0 Then \"Strona\"
  				End as \"Typ zawartości\"
				From
  					cmsSections s
    				inner join cmsSectionstopages sp on s.id = sp.pk_sectionId
				Where
  				sp.PK_PageId = 2";
	
	$result = $DBInt->ExecQuery($query);
 	$localText = $this->spaceText .= '&nbsp;&nbsp;&nbsp;';
 	$dark = true;
 	echo '<table class="Grid">';
 	echo '<tr class="gridHeader"><td width="20" height="20"></td><td width="20" height="20"></td><td>Nazwa</td><td>Nazwa techn.</td><td>Zawartość</td></tr>';
 	$module = new modulesMgr();
 	$module->loadModule('AdminUsr');
 	$action = $module->getModuleActionIdByName('adminAdd');
 	$editaction = $module->getModuleActionIdByName('adminEdit');
 	$delaction = $module->getModuleActionIdByName('adminDelete');
 	$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
 	
 	do
 	{
 		$name = $userData['Name']; 
 		$lastName = $userData['shortName'];
 		$login = $userData['"Typ zawartosci"'];
 		$dark = !$dark;
 		$id = $userData['id'];
 		if ($dark)
 		{
 			$klasa = 'rowdark';
 		}
 		else
 		{
 			$klasa = 'rowlight';
 		}
 		
 		echo "<tr class=\"$klasa\"><td><img src=\"../Cms/Files/Img/stock_edit-16.png\" border=0></td>
 				 <td width=20><img src=\"../Cms/Files/Img/stock_delete-16.png\" height=16 border=0></td>
 				 <td>$login</td><td>$name</td><td>$lastName</td></tr>";
 		
 	}
 	while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC));
 	echo "</table>
 	
 	</td></tr>
 	</table>"
 
?>