<?php
	$module = new modulesMgr();
 	$module->loadModule('Pages');
 	$action = $module->getModuleActionIdByName('addPage');
 	
	echo "
		<table width = \"100%\">
			<tr><td align = \"right\">
				<input type=\"button\" value=\"Dodaj nową stronę\" onClick=\"document.location.href='?a=$action';\">
			</td><tr>
			<tr><td>";
	//-------------wyswietlam grid
			$DBInt = DBSingleton::getInstance();
			$query = "Select id, PageName, ShortName, Active, AuthorizedOnly, `Desc` 
						From cmsPages 
						Where Admin = 'N' 
						Order By PageName";
			$result = $DBInt->ExecQuery($query);
			
			echo '<table class="Grid">';
 			echo '<tr class="gridHeader"><td width="20" height="20"></td><td width="20" height="20"></td>
 					<td>Nazwa strony</td>
 					<td>Nazwa techniczna</td>
 					<td>Aktywna</td>
 					<td>Dostęp aut.</td>
 					<td>Opis</td>
 				 </tr>';
			$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
 			do 
			{
				$dark = !$dark;
				$name = $userData['PageName'];
				$shortName = $userData['ShortName'];
				$active = $userData['Active'];
				$authorized = $userData['AuthorizedOnly'];
				$opis = $userData['Desc'];
				
				if ($dark)
 				{
 					$color = 'rowdark';	
 				}
 				else
 				{
 					$color = 'rowlight';	
 				}
 				
 				echo "<tr class=\"$color\"><td><a href=\"?a=$editaction&id=$id\" class=\"menuleft\"><img src=\"../Cms/Files/Img/stock_edit-16.png\" border=\"0\"></a></td>
 				 	 <td width=20><a href=\"?a=$delaction&id=$id\"><img src=\"../Cms/Files/Img/stock_delete-16.png\" height=16 border=\"0\"></a></td>
	 				 <td>$name</td>
	 				 <td>$shortName</td>
	 				 <td>$active</td>
	 				 <td>$authorized</td>
	 				 <td>$opis</td></tr>";
	 			/*else
 				{
	 			echo "<tr class=\"rowlight\"><td width=20><a href=\"?a=$editaction&id=$id\" class=\"menuleft\"><img src=\"../Cms/Files/Img/stock_edit-16.png\" border=\"0\"></a></td>
 					 <td width=20><a href=\"?a=$delaction&id=$id\"><img src=\"../Cms/Files/Img/stock_delete-16.png\" height=16 border=\"0\"></a></td>
 				 	<td>$login</td>
 				 	<td>$name</td>
 				 	<td>$lastName</td></tr>";
 				}*/
			}
			while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC));
			
			echo '</table>'; //koniec grid
	//-------------
	echo	"</td></tr>
			<tr><td align = \"right\">
				<input type=\"button\" value=\"Dodaj nową stronę\" onClick=\"document.location.href='?a=$action';\">
			</td></tr>
		</table>
	";

	//dodac grid align oraz colalign oraz actionString
	
	$query = "Select id, PageName, ShortName, Active, AuthorizedOnly, `Desc` 
	    		From cmsPages 
	    		Where Admin = 'N' 
				Order By PageName";
	$module = new modulesMgr();
 	$module->loadModule('Pages');
 	
 	$action = $module->getModuleActionIdByName('addPage');
 		
	$grid = new gridRenderer();
	$grid->setTitle('Grid testowy LALALLA');
	$grid->setGridAlign('center');
	$grid->setGridWidth(500);
	$grid->addColumn("PageName", "Kol 1", 200, false, 'right');
	$grid->addColumn("ShortName", "Kol 2", 50, false, 'center');
	$grid->addColumn('Active', 'Czy aktywna', 100, false, 'left');
	$grid->addColumn("id", "", 200, true, 'right');
 	$grid->enabledDelAction($action);
 	$grid->enabledEditAction($action);
	$grid->setDataQuery($query);
	$grid->renderHtmlGrid();				
	
?>