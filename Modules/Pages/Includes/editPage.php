<?php
	include fckEditor;
	
	$objFCKeditor = new FCKEditor('FCKeditor1');
	$objFCKeditor->BasePath = '/FCKeditor/';
	$objFCKeditor->Create();
?>