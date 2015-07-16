<?php
		echo '<table width="600" align="center"><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$config_form = $myForm->getFormInstance();
		$config_form->addElement('header', ' hdrTest', 'Panel konfiguracyjny');
		$config_form->addElement('text', 'txtName', 'Tytuł strony');
		$option_list = array();
		$option_list[''] = '--Wybierz z listy--';
		$option_list['job'] = 'infromatyk';
		$config_form->addElement('select', 'selJob' ,'Zawód', $option_list);
		$config_form->addElement('reset', 'btnReset', 'Wyczyść');
		$config_form->addElement('submit', 'btnSubmit', 'Dalej');
		$config_form->addRule('txtName', 'Proszę wypełnić pole nazwisko!', 'required', null, 'server');
		$config_form->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
	//
		if ($config_form->validate())
		{
			$_SESSION['m'] = -1;
			$config_form->freeze();
		}	
		else
		{
			/*$defaults = array();
			$defaults['txtName'] = '';
			$config_form->setDefaults($defaults);*/
			$config_form->Display();
		}
				
		echo '</td></tr></table>';
?>