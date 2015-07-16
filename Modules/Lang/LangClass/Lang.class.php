<?php
final class LangItem
{
	public $id;
	public $icon;
	public $opis; 	
}
class LangClass
{
	private $DBInt = null;
	private $LangItems = array();
	public function __construct()
	{
		$this->DBInt = DBSingleton::GetInstance();
	}
	public function ShowStatusLangs()
	{
		$query = "SELECT id, `ShortName`, `Icon` FROM `cmsLang` ORDER BY id";
		
		$resultRec = $this->DBInt->ExecQuery($query);
		while ($data = $resultRec->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$tmpLangItem = new LangItem();
			$tmpLangItem->id = $data['id'];
			$tmpLangItem->icon = $data['Icon'];
			$tmpLangItem->opis = $data['ShortName'];
			$langItems[]=$tmpLangItem;
		}
		
		$module = new ModulesMgr();
		$module->loadModule('Lang');
		$actionSetLang = $module->getModuleActionIdByName('SetLang');
		unset($module);	
		
		$smarty = new mySmarty();
		$smarty->assign('langItems', $langItems);
		$smarty->assign('actionSetLang', $actionSetLang);
		
		$html = $smarty->fetch('modules/LangStatus.tpl');
		return $html;	
	}
	public function SetLang($idLang)
	{
		$query = "SELECT `ShortName` FROM `cmsLang` WHERE id = $idLang";
		
		$resultRec = $this->DBInt->ExecQuery($query);
		$data = $resultRec->fetchRow(DB_FETCHMODE_ASSOC);
		$lang = $data["ShortName"];
		$_SESSION['lang'] = $lang;
		header('location:?');
	}
}