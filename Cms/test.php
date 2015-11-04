<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="../Cms/Style/style.css" />

</head>
<body>
<?php
include '../Includes/application.inc.php';
//
Try
{
	/*$mp='../Includes/mp.php';
	require_once($mp);
	$mpobj = new mp();
	echo $mpobj->execute();*/
	
	
	$myForm = new form('form');
	$empty_form = $myForm->getFormInstance();
	//$empty_form->registerElementType('fckeditor','item_desc')
	$empty_form->addElement('header', ' hdrTest', 'Pusty formularz');
	$empty_form->addElement('text', 'txtName', 'Imi� i nazwisko');
	$option_list = array();
	$option_list[''] = '--Wybierz z listy--';
	$option_list['job'] = 'infromatyk';
	$empty_form->addElement('select', 'selJob' ,'Zaw�d', $option_list);
	$empty_form->addElement('reset', 'btnReset', 'Wyczy��');
	$empty_form->addElement('submit', 'btnSubmit', 'Dalej');
	$empty_form->addRule('txtName', 'Prosz� wype�ni� pole nazwisko!', 'required', null, 'server');
	$empty_form->applyFilter('__ALL__', 'trim');
	$myForm->setStyle();
	if ($empty_form->validate())
	{
		$empty_form->freeze();
	}
	else
	{
		$defaults = array();
		$defaults['txtName'] = 'Piotr Brodzi�ski';
		$empty_form->setDefaults($defaults);
	}
	$empty_form->display();
	echo "po";
	
	/*
	echo "przed";
	$tmpForm = new Form('MyForm');
	$form = $tmpForm->getFormInstance();	
	$form->addElement('header', 'test', 'Formularz');
	$form->display();
	echo "<br />";*/
	
	include '../fckeditor/fckeditor_php5.php';
	
	$objFCKeditor = new FCKEditor('FCKeditor1');
	$objFCKeditor->BasePath = '/FCKeditor/';
	$objFCKeditor->Create();
	
	$installer = new installMgr();
	$installer->setModuleSrc('Clients');
	$installer->installModule();	
	
	$DBInt = DBSingleton::getInstance();
 
	$result = $DBInt->ExecQuery('Select id from a');
	while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$id = $userData['id'];
		echo $id;
		
		//var_dump($userData);
		
	}
	
	//$DBnt2 = DBSingleton::getInstance(); 	
	//echo "pu";
	
	  
	//FORMS
	$myForm = new form('form');
	$empty_form = $myForm->getFormInstance();
	//$empty_form->registerElementType('fckeditor','item_desc')
	$empty_form->addElement('header', ' hdrTest', 'Pusty formularz');
	$empty_form->addElement('text', 'txtName', 'Imi� i nazwisko');
	$option_list = array();
	$option_list[''] = '--Wybierz z listy--';
	$option_list['job'] = 'infromatyk';
	$empty_form->addElement('select', 'selJob' ,'Zaw�d', $option_list);
	$empty_form->addElement('reset', 'btnReset', 'Wyczy��');
	$empty_form->addElement('submit', 'btnSubmit', 'Dalej');
	$empty_form->addRule('txtName', 'Prosz� wype�ni� pole nazwisko!', 'required', null, 'server');
	$empty_form->applyFilter('__ALL__', 'trim');
	$myForm->setStyle();
	if ($empty_form->validate())
	{
		$empty_form->freeze();
	}
	else
	{
		$defaults = array();
		$defaults['txtName'] = 'Piotr Brodzi�ski';
		$empty_form->setDefaults($defaults);
	}
	$empty_form->display();
	echo "po";
	/*$dsn2 = 'mysql';
	if(PEAR::isError($dbh = DB::connect($dsn2)))
	  throw new Exception('Lipa-b��d');
  	echo "po";*/
}
Catch(Exception $e)
{
	$exc = new ExceptionClass($e, 'test.php');
   	$exc->writeException();
}
?>
</body>
</html>