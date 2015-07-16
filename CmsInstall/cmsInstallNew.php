<?php
include '../Includes/application.inc.php';

error_reporting(E_ALL); 
ini_set('display_errors',1); 

echo 'a';
include '../CmsInstall/ddl.inc.php';
$DBInt = DBSingleton::getInstance();

//- wypelniam tabele wartosciami domyslnymi - Languages, cmsUsers (login Admin, haslo Admin)
try
{
	echo 'Wypełniam tabelę cmsLang<br />';
	$dmlMenu = "INSERT INTO cmsLang(`Name`, `ShortName`) Values ('Polski', 'PL');";
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = "INSERT INTO cmsLang(`Name`, `ShortName`) Values ('Angielski', 'ENG');";
	$DBInt -> ExecQuery($dmlMenu);
	echo '-->OK<br />';
	
	echo 'Wypełniam tabelę cmsUsers<br />';
	$pass= md5('Admin');
	$dmlMenu = "INSERT INTO cmsUsers(`LOGIN`, `PASS`, `ROOT`) Values ('Admin','$pass', 'T');";
	$DBInt->ExecQuery($dmlMenu);
	echo '-->OK<br />';
	
	
//	----------------- tworze obiekty Mgr
	echo 'Inicjalizacja instalatora...';
	$menuMgr = menuMgr :: getInstance();
	$moduleMgr = new modulesMgr();
	$pageMgr = new pagesMgr();
	$sectionMgr = new sectionsMgr();
	echo "-->Ok.<br/>";
//-----------------
//0. Strony
	$pageMgr->addPage('Strona konfiguracyjna', 'ConfigPage', 'T', 'T', 'T', 'Strona konfiguracyjna');
	$pageMgr->addPage('Lista języków', 'LanguagePage', 'T', 'T', 'T', 'Lista języków');
	$pageMgr->addPage('Administratorzy', 'AdminUsrPage', 'T','T', 'T', 'Administratorzy');
	$pageMgr->addPage('Uprawnineia admin', 'PrivilegeUsrPage', 'T','T', 'T', 'Uprawnienia admin'); 
	$pageMgr->addPage('Strony', 'PagesPage', 'T','T', 'T', 'Strony');
	$pageMgr->addPage('Sekcje', 'PageSectPage', 'T','T', 'T', 'Zarzadzanie sekcjami');
	$pageMgr->addPage('Lista Menu', 'MenuListPage', 'T','T', 'T', 'Zarzadzanie menu');
	$pageMgr->addPage('CmsInfo', 'CmsInfoPage', 'T','T', 'T', 'Ifnormacje o CMS');
	$pageMgr->addPage('CmsModules', 'CmsModulesPage', 'T','T', 'T', 'Moduły CMS');
	$pageMgr->addPage('Moduły i akcje', 'CmsModActnPage', 'T','T', 'T', 'Moduły i akcje CMS');
	$pageMgr->addPage('Języki', 'LanguagesPage', 'T','T', 'T', 'Dostępne języki tłumaczenia');
	$pageMgr->addPage('Szablony', 'Templates', 'T','T', 'T', 'Szablony stron');
	$pageMgr->addPage('CSS', 'CSS', 'T','T', 'T', 'CSS');

//1. ----------------Menu

	echo "Dodaję menu...";
	$menuMgr->addMenuItem('', 'Konfiguracja', 'Config', '', 1, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Config'), 'PL', 'Konfiguracja');
	//$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Config'), 'ENG', 'Conffigguration');
	$menuMgr->addMenuItem('Config', 'Języki', 'Lang', 'LanguagesPage', 1, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Lang'), 'PL', 'Języki');
	$menuMgr->addMenuItem('', 'Menu', 'Menu', '', 2, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Menu'), 'PL', 'Menu');
	$menuMgr->addMenuItem('', 'Strony', 'Strony', '', 3, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Strony'), 'PL', 'Strony');
	$menuMgr->addMenuItem('Strony', 'Szablony', 'Templates', '', 1, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Templates'), 'PL', 'Szablony SMARTY');
	$menuMgr->addMenuItem('Strony', 'CSS', 'CSS', '', 2, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('CSS'), 'PL', 'CSS');
	$menuMgr->addMenuItem('', 'Moduły', 'Moduly', '', 1000, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Moduly'), 'PL', 'Moduły');
	$menuMgr->addMenuItem('Moduly', 'Moduły i akcje', 'ModIActn', '', 1, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('ModIActn'), 'PL', 'Moduły i akcje');
	$menuMgr->addMenuItem('', 'Użytkownicy (CMS)', 'CmsUsers', '', 4, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('CmsUsers'), 'PL', 'Użytkownicy (CMS)');
	$menuMgr->addMenuItem('CmsUsers', 'Uprawnienia', 'CmsUsersPrivileges', '', 4, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('CmsUsersPrivileges'), 'PL', 'Uprawnienia');
	//$menuMgr->addMenuItem('', 'Logi administracyjne', 'Logs', '', 999, 'T', 'L');
	//$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Logs'), 'PL', 'Logi administracyjne');
	$menuMgr->addMenuItem('', 'CMSInfo', 'CmsInfo', 'CmsInfoPage', 0, 'T', 'L');
	$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('CmsInfo'), 'PL', 'CMSInfo');
	echo "-->Ok.<br/>";
//2. ----------------Modules

//-[1. Konfiguracja]-------------------------------
	echo "Moduł Konfiguracja...";
	$moduleMgr->addModule('Moduł konfiguracyjny', 'Config', 1, './Modules/Config/Config.php' , './Modules/Config/');
	$moduleMgr->addModuleAction('Wyświetl konfig.', 'printConfig', 'Config');
	$moduleMgr->addModuleAction('Wyświetl języki', 'printLangGrid', 'Config');
	$moduleMgr->addModuleAction('Pobierz tytul', 'getMainPageTitle', 'Config');
	$moduleMgr->addModuleAction('Usun jezyk', 'delLang', 'Config');
	$moduleMgr->addModuleAction('Usun jezyk', 'delLangDo', 'Config');
	$moduleMgr->addModuleAction('Edytuj jezyk', 'editLang', 'Config');//gdy id puste - to dodawnie
	$moduleMgr->addModuleAction('Zapisz jezyk', 'editLangDo', 'Config');
	$moduleMgr->addModuleAction('Wybór strony', 'choosePage', 'Config');
	
	$sectionMgr->addModuleSection('Sekcja konfig.', 'Config', 1, 'Config', 'printConfig');
	$sectionMgr->assignSectionToPage('Config', 'ConfigPage');
	$menuMgr->setMenuItemPage('Config', 'ConfigPage');
	
	$sectionMgr->addModuleSection('Sekcja językowa', 'LangConfig', 1, 'Config', 'printLangGrid');
	$sectionMgr->assignSectionToPage('LangConfig', 'LanguagesPage');
	$menuMgr->setMenuItemPage('Lang', 'LanguagesPage');
	echo "-->Ok.<br/>";
//-----------------------------------

//-[2. Administratorzy]----------------------------
	echo "Moduł administratorzy...";
	$moduleMgr->addModule('Moduł administratorzy', 'AdminUsr', 1, './Modules/AdminUsr/AdminUsr.php', './Modules/AdminUsr/');
	$moduleMgr->addModuleAction('Lista admin.', 'showAdmins', 'AdminUsr');
	$moduleMgr->addModuleAction('Dodaj admin.', 'adminAdd', 'AdminUsr');
	$moduleMgr->addModuleAction('Zapisz admin.', 'adminAddDo', 'AdminUsr');
	$moduleMgr->addModuleAction('Logowanie admin.', 'adminLogin', 'AdminUsr');
	$moduleMgr->addModuleAction('Wylogowanie admin.', 'adminLogout', 'AdminUsr');
	$moduleMgr->addModuleAction('Edycja admin.', 'adminEdit', 'AdminUsr');
	$moduleMgr->addModuleAction('Usuniecie admin.', 'adminDelete', 'AdminUsr');
	$moduleMgr->addModuleAction('Usuniecie admin.', 'adminDeleteDo', 'AdminUsr');
	$moduleMgr->addModuleAction('Lista uzytk. upr', 'showPrivilegesUsers', 'AdminUsr');
	$moduleMgr->addModuleAction('Lista modolow upr', 'showPrivilegesModules', 'AdminUsr');
	$moduleMgr->addModuleAction('Lista akcji upr', 'showPrivilegesActions', 'AdminUsr');
	$moduleMgr->addModuleAction('Modyfikacja upr', 'updatePrivileges', 'AdminUsr');
	$moduleMgr->addModuleAction('Sprawdzenie upr', 'chkPrivileges', 'AdminUsr');
	$moduleMgr->addModuleAction('Zmiana hasła', 'adminPassEdit', 'AdminUsr');
	$moduleMgr->addModuleAction('Pobierz Login dla ID', 'getUserLoginById', 'AdminUsr');
		
	$moduleMgr->addModuleAction('Pobieranie loginu', 'getLogin', 'AdminUsr');
	$moduleMgr->addModuleAction('Pobieranie imienia', 'getName', 'AdminUsr');
	$moduleMgr->addModuleAction('Pobiueranie nazwiska', 'getLastName', 'AdminUsr');
	$moduleMgr->addModuleAction('Pobieranie sesji', 'getSessionBeginTime', 'AdminUsr');
	
	$sectionMgr->addModuleSection('Sekcja administracyjna', 'AdminSect', 1, 'AdminUsr', 'showAdmins');
	$sectionMgr->addModuleSection('Sekcja uprawnien', 'PrivilegeSect', 1, 'AdminUsr', 'showPrivilegesUsers');
	
	$sectionMgr->assignSectionToPage('AdminSect', 'AdminUsrPage');
	$sectionMgr->assignSectionToPage('PrivilegeSect', 'PrivilegeUsrPage');
	
	$menuMgr->setMenuItemPage('CmsUsers', 'AdminUsrPage');
	$menuMgr->setMenuItemPage('CmsUsersPrivileges', 'PrivilegeUsrPage');
	echo "-->Ok.<br/>";
//-----------------------------------
//--[3 - Strony]-----------------------------------
	echo "Moduł PAGES...";
	$moduleMgr->addModule('Zarządz. stronami', 'Pages', 1, './Modules/Pages/Pages.php', './Modules/Pages/');
	$moduleMgr->addModuleAction('Lista stron wyb', 'showPagesChoose', 'Pages');
	$moduleMgr->addModuleAction('Lista stron', 'showPages', 'Pages');
	$moduleMgr->addModuleAction('Form. dodawanie strony', 'showAddPage', 'Pages');
	$moduleMgr->addModuleAction('Dodawanie strony - zapis', 'addPageSave', 'Pages');
	$moduleMgr->addModuleAction('Usuwanie strony pyt', 'delPage', 'Pages');
	$moduleMgr->addModuleAction('Usuwanie strony', 'delPageDo', 'Pages');
	$moduleMgr->addModuleAction('Form. edycja strony', 'showEditPage', 'Pages');
	$moduleMgr->addModuleAction('Edycja strony - zapis', 'editPageSave', 'Pages');
	$moduleMgr->addModuleAction('Lista szablonów', 'pagesTemplates', 'Pages');
	$moduleMgr->addModuleAction('Dodawanie szablonu', 'pagesTemplatesAdd', 'Pages');
	$moduleMgr->addModuleAction('Edycja szablonu', 'pagesTemplatesEdit', 'Pages');
	$moduleMgr->addModuleAction('Usuwanie szablonu', 'pagesTemplatesDelete', 'Pages');
	$moduleMgr->addModuleAction('Wybieranie szablonu', 'chooseTemplate', 'Pages');
	$moduleMgr->addModuleAction('Edycja CSS', 'cssEdit', 'Pages');
	$moduleMgr->addModuleAction('Gen. stron do menu', 'genPages', 'Pages');
	$sectionMgr->addModuleSection('Sekcja stron', 'PagesSect', 1, 'Pages', 'showPages');
	$sectionMgr->assignSectionToPage('PagesSect', 'PagesPage');
	
	$sectionMgr->addModuleSection('Sekcja szablonów', 'TemplatesSect', 1, 'Pages', 'pagesTemplates');
	$sectionMgr->assignSectionToPage('TemplatesSect', 'Templates');
	$sectionMgr->addModuleSection('Sekcja CSS', 'CssSect', 1, 'Pages', 'cssEdit');
	$sectionMgr->assignSectionToPage('CssSect', 'CSS');		
	
	$menuMgr->setMenuItemPage('Strony', 'PagesPage');
	$menuMgr->setMenuItemPage('Templates', 'Templates');
	$menuMgr->setMenuItemPage('CSS', 'CSS');
	echo "-->Ok.<br/>";
//-----------------------------------
//--[4 - Sections]---------------------------------
	echo "Moduł SECTIONS...";
	$moduleMgr->addModule('Zarządz. sekcjami', 'Sections', 1, './Modules/Sections/Sections.php', './Modules/Sections/');
	$moduleMgr->addModuleAction('Lista sek.- str.', 'showPageSections', 'Sections');
	$moduleMgr->addModuleAction('Lista sekcji', 'showSections', 'Sections');
	$moduleMgr->addModuleAction('Dodaj sekcje', 'addSection', 'Sections');
	$moduleMgr->addModuleAction('Edytuj sekcje', 'editSection', 'Sections');
	$moduleMgr->addModuleAction('Usuń sekcje', 'delSection', 'Sections');
	$moduleMgr->addModuleAction('Edytuj zawartosc', 'editSectionContent', 'Sections');
	$sectionMgr->addModuleSection('Zarz. sekc (pages)', 'pageSectionsSect', 1, 'Sections', 'showPageSections');
	$sectionMgr->addModuleSection('Zarz. sekc', 'sectionsSect', 1, 'Sections', 'showSections');
	$sectionMgr->assignSectionToPage('pageSectionsSect', 'PageSectPage');
	echo "-->Ok.<br/>";

//-----menuFrontEnd
	echo "Moduł frontEndMenu...";
	$moduleMgr->addModule('Zarządzanie menu strony', 'FrontendMenu', 1, './Modules/FrontendMenu/FrontendMenu.php', './Modules/FrontendMenu/');
	$moduleMgr->addModuleAction('Lista menu', 'showMenuList', 'FrontendMenu');
	$moduleMgr->addModuleAction('Ekran dodawania menu', 'showMenuItemAdd', 'FrontendMenu');
	$moduleMgr->addModuleAction('Edycja menu', 'showMenuItemEdit', 'FrontendMenu');
	$moduleMgr->addModuleAction('Dodawanie menu', 'addMenuItem', 'FrontendMenu');
	$moduleMgr->addModuleAction('Usuwnaie menu', 'delMenuItem', 'FrontendMenu');
	$moduleMgr->addModuleAction('Usuwnaie menu DO', 'delMenuItemDo', 'FrontendMenu');
	$moduleMgr->addModuleAction('Przypisywanie menu do strony', 'assignMenuToPage', 'FrontendMenu');
	$moduleMgr->addModuleAction('Ekran przypisywania menu do strony', 'showAssignMenuToPageForm', 'FrontendMenu');
	$moduleMgr->addModuleAction('Wybór nadmenu', 'showMenuListChoose', 'FrontendMenu');
	$moduleMgr->addModuleAction('Wybór strony', 'showMenuPagesChoose', 'FrontendMenu');
	$moduleMgr->addModuleAction('MenuUp', 'menuUp', 'FrontendMenu');
	$moduleMgr->addModuleAction('MenuDown', 'menuDown', 'FrontendMenu');
	$sectionMgr->addModuleSection('Sekcja listaMenu', 'MenuSect', 1, 'FrontendMenu', 'showMenuList');
	$sectionMgr->assignSectionToPage('MenuSect', 'MenuListPage');
	$menuMgr->setMenuItemPage('Menu', 'MenuListPage');
	echo "-->Ok.<br/>";
//--------------
//-----modul cmsModules
	echo "Moduł CmsModules...";
	$moduleMgr->addModule('Moduły CMS', 'CmsModules', 1, './Modules/Modules/modules.php', './Modules/Modules/');
	//akcje z menu
	$moduleMgr->addModuleAction('Lista modułów CMS', 'showModulesList', 'CmsModules');
	$moduleMgr->addModuleAction('Lista modułów/akcji', 'showModulesAndActionsList', 'CmsModules');
	//akcje pozostale
	$moduleMgr->addModuleAction('Edycja modulu', 'editModule', 'CmsModules');
	$moduleMgr->addModuleAction('Kasowanie modulu pyt', 'deleteModule', 'CmsModules');
	$moduleMgr->addModuleAction('Kasowanie modulu', 'deleteModuleDo', 'CmsModules');
	$moduleMgr->addModuleAction('Instalacja modulu', 'installModule', 'CmsModules');
	$moduleMgr->addModuleAction('Dodawnaie modulu', 'addModule', 'CmsModules');
	$moduleMgr->addModuleAction('Akcje modulu', 'showActions', 'CmsModules');
	$moduleMgr->addModuleAction('Dodawanie akcji', 'addAction', 'CmsModules');
	$moduleMgr->addModuleAction('Edycja akcji', 'editAction', 'CmsModules');
	$moduleMgr->addModuleAction('Kasowanie akcji pyt', 'delAction', 'CmsModules');
	$moduleMgr->addModuleAction('Kasowanie akcji', 'delActionDo', 'CmsModules');
	$moduleMgr->addModuleAction('Wybór akcji modułu', 'showModulesActionsChoose', 'CmsModules');
	
	
	$sectionMgr->addModuleSection('Sekcja CmsModules', 'CmsModulesSect', 1, 'CmsModules', 'showModulesList');
	$sectionMgr->addModuleSection('Sekcja CmsModActn', 'CmsModActnSect', 1, 'CmsModules', 'showModulesAndActionsList');
	$sectionMgr->assignSectionToPage('CmsModulesSect', 'CmsModulesPage');
	$sectionMgr->assignSectionToPage('CmsModActnSect', 'CmsModActnPage');
	$menuMgr->setMenuItemPage('Moduly', 'CmsModulesPage');
	$menuMgr->setMenuItemPage('ModIActn', 'CmsModActnPage');
	echo "-->Ok.<br/>";

//-----modul info
	echo "Moduł CmsInfo...";
	$moduleMgr->addModule('Informacja o CMS', 'CmsInfo', 1, './Modules/CmsInfo/CmsInfo.php', './Modules/CmsdInfo/');
	$moduleMgr->addModuleAction('Informacje CMS', 'showCmsInfo', 'CmsInfo');
	$moduleMgr->addModuleAction('Dodawanie zgłoszenia błędu', 'addBug', 'CmsInfo');
	$moduleMgr->addModuleAction('Edycja zgłoszenia błędu', 'editBug', 'CmsInfo');
	$sectionMgr->addModuleSection('Sekcja CmsInfo', 'CmsInfoSect', 1, 'CmsInfo', 'showCmsInfo');
	$sectionMgr->assignSectionToPage('CmsInfoSect', 'CmsInfoPage');
	//$menuMgr->setMenuItemPage('', 'MenuListPage');
	echo "-->Ok.<br/>";
//---------------
	
	echo 'Wypełniam tabelę cmsTemplates<br />';
	$DBInt->ExecQuery("INSERT INTO cmsTemplates(`Name`, `ShortName`, `Path`, `FileName`) 
						VALUES('Domyślny szablon', 'DefaultTemplate', './smartydirs/templates/', 'default.tpl')");
	
	$DBInt->ExecQuery("INSERT INTO cmsTemplates(`Name`, `ShortName`, `Path`, `FileName`) 
						VALUES('Menu górne', 'MenuTopTemplate', './smartydirs/templates/', 'menuTop.tpl')");

	$DBInt->ExecQuery("INSERT INTO cmsTemplates(`Name`, `ShortName`, `Path`, `FileName`) 
						VALUES('Menu lewe', 'MenuLeftTemplate', './smartydirs/templates/', 'menuLeft.tpl')");
	
	$DBInt->ExecQuery("INSERT INTO cmsTemplates(`Name`, `ShortName`, `Path`, `FileName`) 
						VALUES('Menu prawe', 'MenuRightTemplate', './smartydirs/templates/', 'menuRight.tpl')");
	
	$DBInt->ExecQuery("INSERT INTO cmsTemplates(`Name`, `ShortName`, `Path`, `FileName`) 
						VALUES('Menu dolne', 'MenuBottomTemplate', './smartydirs/templates/', 'menuBottom.tpl')");
	echo '-->OK<br />';

}
Catch(Exception $e)
{
	$exc = new ExceptionClass($e, 'installCms');
	$exc->writeException();   	   	
}
//-----------------------------------
?>