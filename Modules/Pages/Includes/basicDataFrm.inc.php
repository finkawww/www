<?php
		//echo "<table width=\"600\" align=\"center\"><tr><td>";
		$myForm = null;
		$myForm = new Form('pageFORM', 'POST') ;
		$pageAdd_form = null;
		$pageAdd_form = $myForm->getFormInstance();
		$pageAdd_form->addElement('header', ' hdrTest', 'Nowa strona - ustawienia główne');
		$pageAdd_form->addElement('text', 'txtName', 'Nazwa strony', array('size' => 25, 'maxlength'=> 12));
		$pageAdd_form->addElement('text', 'txtTechName', 'Nazwa techniczna(unikalna)', array('size' => 25, 'maxlength'=> 12));
		$option_list = array();
		$option_list['']= '--Wybierz z listy--';
		$option_list['T'] = 'Tak';
		$option_list['N'] = 'Nie';
		$pageAdd_form->addElement('select', 'selActive', 'Aktywna', $option_list);
		$option_list1 = array();
		$option_list1['']= '--Wybierz z listy--';
		$option_list1['T'] = 'Tak';
		$option_list1['N'] = 'Nie';
		$pageAdd_form->addElement('select', 'selAuth', 'Autoryzacja', $option_list1);
		$pageAdd_form->addElement('textarea', 'Opis', 'Opis', array('cols'=>30, 'rows'=>6));
								 		
	//  $adminAdd_form->addElement('hidden', 'a', $action, null);
		$pageAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$pageAdd_form->addElement('submit', 'btnSubmit', 'Zapisz i przypisz sekcje');
		$action1=1;
		//$pageAdd_form->addElement('hidden', 'a', $action1, null);
		
		$pageAdd_form->addRule('txtName', 'Proszę wypełnić pole nazwa!', 'required', null, 'server');
		$pageAdd_form->addRule('txtTechName', 'Proszę wypełnić pole nazwa techniczna!', 'required', null, 'server');
		$pageAdd_form->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');
		$pageAdd_form->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
	//	echo "</td></tr></table>";
		if ($pageAdd_form->validate())
		{
			//session_start();
			$pageAdd_form->freeze();
			//unset($myForm);
			//unset($pageAdd_form);
			//$pageAdd_form
			$pageAdd_form->process('process_data', false);
			
		}
		else
		{
			$pageAdd_form->Display();
		//	$pageAdd_form->Display();
		}
		
		function process_data($values)
		{
			$module = new modulesMgr();
 			$module->loadModule('Sections');
 			$action = $module->getModuleActionIdByName('ShowPageSections');
 			$action2 = $module->getModuleActionIdByName('showAdmins');
 			echo '<table class="tblPotwierdzenie" align="center" width = "750">';
 			echo '<tr class="header"><td colspan="2" align = \"center\">Wprowadzone dane:</td></tr>';
 			foreach ($values as $key=>$value)
 			{
 				if ($key == 'txtName')
 				{
 					echo '<tr><td>Nazwa:</td><td>' . $value.'</td></tr>';
 					$name=$value;
 				}
 				if ($key == 'txtTechName')
 				{
 					echo '<tr><td>Nazwa techn.:</td><td align = "left">' . $value.'</td></tr>';
 					$techname = $value;
 				}
 				if ($key == 'selActive')
 				{
 					echo '<tr><td>Aktywna:</td><td>' . $value.'</td></tr>';
 					$active=$value;
 				}
 				if ($key == 'selAuth')
 				{
 					echo '<tr><td>Autoryzacja:</td><td>' . $value.'</td></tr>';
 					$auth=$value;
 				}
 				if ($key == 'Opis')
 				{
 					echo '<tr><td>Opis:</td><td>' . $value.'</td></tr>';
 					$desc=$value;
 				}
 				//zapisuje strone 
					 				 
 			}
 			
 			$pageMgr = new PagesMgr();
 			$pageMgr->addPage($name, $techname, $active, 'N', $auth, $desc);
 			$pageId = $pageMgr->getPageIdByName($techname);
 			$QueryString = "&txtName=$name&txtSurName=$surname&txtLogin=$login&txtPass=$pass";
 			
 			echo "<tr class=\"header\"><td colspan=\"2\" align = \"right\"><a href=\"?pageId=$pageId&a=$action".$QueryString."\" class=\"leftmenu\"><input type=\"button\" value=\"Dalej\"></a>";
 			echo "<a href=\"index.php\"?a=$action2\" class=\"leftmenu\"><input type=\"button\" value=\"Anuluj\"></a></td></tr>";
 			//echo "<input type=\"button\" value=\"Anuluj\" onclick=\"document.location.href='index.php?a=$action2'\"></td></tr>";
 			echo "</table>";	
		}
?>