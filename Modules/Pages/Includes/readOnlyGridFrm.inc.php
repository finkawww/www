<?php
$DBInt = DBSingleton::getInstance();
	$query = "Select id, LastName, Name, Login from cmsUsers Order By Name";
	$result = $DBInt->ExecQuery($query);
 	$localText = $this->spaceText .= '&nbsp;&nbsp;&nbsp;';
 	$dark = true;
 	echo '<table class="Grid">';
 	echo '<tr class="gridHeader"><td width="20" height="20"></td><td width="20" height="20"></td><td>Login</td><td>Imie</td><td>Nazwisko</td></tr>';
 	$module = new modulesMgr();
 	$module->loadModule('AdminUsr');
 	$action = $module->getModuleActionIdByName('adminAdd');
 	$editaction = $module->getModuleActionIdByName('adminEdit');
 	$delaction = $module->getModuleActionIdByName('adminDelete');
 	$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
 	
 	do
 	{
 		$name = $userData['Name']; 
 		$lastName = $userData['LastName'];
 		$login = $userData['Login'];
 		$dark = !$dark;
 		$id = $userData['id'];
 		if ($dark)
 		{
 			echo "<tr class=\"rowdark\"><td><img src=\"../Cms/Files/Img/stock_edit-16.png\" border=0></td>
 				 <td width=20><img src=\"../Cms/Files/Img/stock_delete-16.png\" height=16 border=0></td>
 				 <td>$login</td><td>$name</td><td>$lastName</td></tr>";
 		}
 		else
 		{
 			echo "<tr class=\"rowlight\"><td width=20><img src=\"../Cms/Files/Img/stock_edit-16.png\" border=0></td>
 				 <td width=20><img src=\"../Cms/Files/Img/stock_delete-16.png\" height=16 border=0></td>
 				 <td>$login</td><td>$name</td><td>$lastName</td></tr>";
 		}
 	}
 	while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC));
 	echo "</table>"
 	
?>