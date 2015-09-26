<?php
/*
------------------------------------
Klasa dziedzicz�ca po Smarty.
Definiuje obiekt pochodny Smarty 
i ustawia parametry domy�lne.
Created: 28.08.2007
Mod: 28.08.2007
Author: P. Brodzi�ski
------------------------------------
*/

require_once rootPath.'/Includes/smarty.conf.php';
require_once rootPath.'/Smarty/Smarty.class.php';

class mySmarty extends Smarty
{
	public function __construct()
	{
		parent :: __construct();
		
		if (defined('SMARTY_TEMPLATE_DIR'))
		{
			$this->template_dir = SMARTY_TEMPLATE_DIR;
		}
		if (defined('SMARTY_COMPILE_DIR'))
		{
			$this->compile_dir = SMARTY_COMPILE_DIR;
		}
		if (defined('SMARTY_CONFIG_DIR'))
		{
			$this->config_dir = SMARTY_CONFIG_DIR;
		}
		if (defined('SMARTY_CACHE_DIR'))
		{
			$this->cache_dir = SMARTY_CACHE_DIR;
		}
		if (defined('SMARTY_DEBUGGING'))
		{
			$this->debugging = SMARTY_DEBUGGING;
		}
		if (defined('SMARTY_COMPILE_CHECK'))
		{
			$this->compile_dir = SMARTY_COMPILE_CHECK;
		}
		if (defined('SMARTY_COMPILE_DIR'))
		{
			$this->compile_dir = SMARTY_COMPILE_DIR;
		}
		$this->caching = 0;
	}
}
?>