<?php
/* 
---------------------
System install module		  
Created:20.08.2007 			  
Mod: 20.08.2007  			  
Author: P. Brodzi�ski 
---------------------		 
*/ 

/* This module creates basic (bulit-in) db objects, menu and default records in tables. */

include '../Includes/application.inc.php';


//DDL:
//$ddlCreateSchema = "Create Schema WWW";

$ddlDBDrop= "DROP DATABASE IF EXISTS `www`";
$ddlDBCreate = "CREATE DATABASE WWW";


$ddlSectionsToPages = " 
						Create Table `www`.`cmsSectionsToPages`(
						`id` Int(10) Unsigned NOT NULL Auto_increment,
						`PK_PageId` Int(10) Unsigned Not Null,
						`PK_SectionId` Int(10) Unsigned Not Null,
						`Language` Varchar(2),
						PRIMARY KEY (`Id`, `PK_PageID`, `PK_SectionID`)
					   ) 
					   Engine=InnoDB
					   CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlSectionsTbl = " 
					Create Table `www`.`cmsSections`(
					`id` Int(10) Unsigned NOT NULL auto_increment,
					`Name` Varchar(25) Not Null,
					`ShortName` Varchar(10) Not Null Unique,
					`Priority` Int(10) Not Null,
					`ContentType` Int(10) Not Null,
					`FK_ModuleId` Int(10) Unsigned,
					`FK_ModuleAction` Int(10) Unsigned,
					`FK_PageId` Int(10) Unsigned,
					`Content` Text,
					PRIMARY KEY (`id`),
					CONSTRAINT `FK_ModuleId` FOREIGN KEY `FK_ModuleIdFk`(`FK_ModuleId`) 
						REFERENCES `cmsModules`(`id`)
						ON DELETE RESTRICT
						ON UPDATE RESTRICT,
					CONSTRAINT `FK_ModuleAction` FOREIGN KEY `FK_ModuleActionFk`(`FK_ModuleAction`)
						REFERENCES `cmsModulesActions`(`id`)
						ON DELETE RESTRICT
						ON UPDATE RESTRICT,
					CONSTRAINT `FK_PageId` FOREIGN KEY `FK_PageIdFk`(`FK_PageId`)
						REFERENCES `cmsPages`(`Id`)
						ON DELETE RESTRICT
						ON UPDATE RESTRICT	
				 )
				 Engine=InnoDB
				 CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlPagesTbl = "
				Create Table `www`.`cmsPages`(
					`id` Int(10) Unsigned NOT NULL auto_increment,
					`PageName` Varchar(25) NOT NULL,
					`ShortName` Varchar(20) NOT NULL UNIQUE,
					`Active` Varchar(1) DEFAULT  'T',
					`AuthorizedOnly` Varchar(1) DEFAULT 'T',
					`Desc` Text,
					PRIMARY  KEY (`id`)
				)
				Engine=InnoDB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlModulesTbl = "
					Create Table `www`.`cmsModules`(
					`Id` Int(10) Unsigned Not Null auto_increment,
					`ModuleName` Varchar(25) Not Null,
					`ModuleShortName` Varchar(20) Not Null,
					`ModuleVersion` Int(10),
					`ModulePath` Varchar(256) Not Null,
					`ModuleDirPath` Varchar(256) Not Null,
					PRIMARY KEY (`Id`)
				  )
				  Engine=InnoDB
				  CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlModulesActionsTbl = "
						 Create Table `www`.`cmsModulesActions` (
 							`Id` Int(10) Unsigned Not Null auto_increment,
							`ActionName` Varchar(25) Not Null,
							`ActionShortName` Varchar(15) Not Null,
							`FK_ModuleId` Int(10) Unsigned,
							PRIMARY KEY (`Id`),
							CONSTRAINT `FK_1` FOREIGN KEY `FK_ModuleIdFK`(`FK_ModuleId`)
								REFERENCES `cmsModules`(`id`)
								ON DELETE RESTRICT
								ON UPDATE RESTRICT							
						 )
						 Engine=InnoDB
					   	 CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlLangTbl = "
				Create Table `www`.`cmsLang`(
				`Id` Int(10) Unsigned Not Null Auto_Increment,
				`Name` Varchar(25) Not Null,
				`ShortName` Varchar(2) Not Null Unique,
				`Icon` MediumBlob,
				PRIMARY KEY (Id)
			   )
			   Engine=InnoDB
			   CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlMenuTbl = "
				Create Table `www`.`cmsMenu`(
				`id` Int(10) Unsigned Not Null auto_increment,
				`Name` Varchar(25) Not Null,
				`ShortName` Varchar(10) Not Null Unique,
				`FK_PageId` Int(10) Unsigned,
				
				`FK_ParentMenuItem` Int(10) Unsigned Default 0,
				`Index` Int(10) Not Null,
				`Position` Varchar(1) DEFAULT 'L' Not Null,
				`AdminMenu` Varchar(1) DEFAULT 'N' Not Null,
				`Active` Varchar(1) DEFAULT 'T' Not Null,
				PRIMARY KEY (`id`),
				CONSTRAINT `cmsMenuFK1` FOREIGN KEY `Fk_PageIdFk`(`FK_PageId`)
				  REFERENCES `cmsPages`(`id`)
				  ON DELETE CASCADE
				  ON UPDATE RESTRICT
			   )
			   Engine=InnoDB
			   CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlUsersTbl = "
				Create Table `www`.`cmsUsers`(
					`Id` Int(10) Unsigned Not Null Auto_Increment,
					`Name` Varchar(25),
					`LastName` Varchar(25),
					`Login` Varchar(10) Not Null Unique,
					`Pass` Varchar(255) Not Null,
					`Active` Varchar(1) DEFAULT 'T',
					`Root` Varchar(1) DEFAULT 'N',
					`LastLogin` Varchar(50),
					PRIMARY KEY (`Id`)
				)
				Engine=InnoDB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

//Obiekt klasy DB, wykonuje powyzsze DDL:
//$ddlDBDrop= "DROP DATABASE IF EXISTS `www`";
//$ddlDBCreate = "CREATE DATABASE WWW";

$DBInt = DBSingleton::getInstance();
echo 'Tworze DB<br />';
//$DBInt->ExecQuery($ddlDBDrop);
//$DBInt->ExecQuery($ddlDBCreate);
echo '-->OK<br />';

echo 'Tworze tabele cmsSectionsToPages <br />';
$DBInt->ExecQuery($ddlSectionsToPages);
echo '-->OK<br />';


echo 'Tworze tabele cmsPages <br />';
$DBInt->ExecQuery($ddlPagesTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsModules <br />';
$DBInt->ExecQuery($ddlModulesTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsModulesActions <br />';
$DBInt->ExecQuery($ddlModulesActionsTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsSections <br />';
$DBInt->ExecQuery($ddlSectionsTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsLang <br />';
$DBInt->ExecQuery($ddlLangTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsMenu <br />';
$DBInt->ExecQuery($ddlMenuTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsUsers <br />';
$DBInt->ExecQuery($ddlUsersTbl);
echo '-->OK<br />';

//- tworze menu dla cms - konfiguracja, strony, moduly(tu tylko "zainstaluj nowy modul" z prioryttem 1000), !!!!,
echo 'Dodaje wpisy domyslne do tabeli cmsMenus<br />';
$DBInt->ExecQuery('Start transaction;');
$DBInt->ExecQuery('Delete From cmsMenu;');

$dmlMenu = "INSERT INTO cmsMenu(`Name`, `ShortName`, `Index`, `AdminMenu`) Values ('Menu', 'Menu', 2, 'T');";
$DBInt->ExecQuery($dmlMenu);

$dmlMenu = "INSERT INTO cmsMenu(`Name`, `ShortName`, `Index`, `AdminMenu`) Values ('Strony', 'Strony',3, 'T');";
$DBInt->ExecQuery($dmlMenu);


$dmlMenu = "INSERT INTO cmsMenu(`Name`, `ShortName`, `Index`, `AdminMenu`) Values ('Moduły', 'Moduly', 4, 'T');";
$DBInt->ExecQuery($dmlMenu);

$result = $DBInt->ExecQuery("Select `id` From `cmsMenu` Where `Name` = 'Moduły'");
$parentMenu = $result->fetchRow(DB_FETCHMODE_ASSOC);
$id = $parentMenu['id'];
$dmlMenu = "INSERT INTO cmsMenu(`Name`,`ShortName`, `Index`, `AdminMenu`, `FK_ParentMenuItem`) Values 
			('Nowy moduł', 'NewModule', 1000, 'T', $id);";
$DBInt->ExecQuery($dmlMenu);

echo '-->OK<br />';
			
//- wypelniam tabele wartosciami domyslnymi - Languages, cmsUsers (login Admin, haslo Admin)
echo 'Wype�niam tabel� cmsLang<br />';
$dmlMenu = "INSERT INTO cmsLang(`Name`, `ShortName`) Values ('Polski', 'PL');";
$DBInt->ExecQuery($dmlMenu);
echo '-->OK<br />';

echo 'Wype�niam tabel� cmsUsers<br />';
$pass= md5('Admin');
$dmlMenu = "INSERT INTO cmsUsers(`LOGIN`, `PASS`, `ROOT`) Values ('Admin','$pass', 'T');";
$DBInt->ExecQuery($dmlMenu);
echo '-->OK<br />';

$DBInt->ExecQuery('Commit;');

/*
-------------------------
Instaluje moduly domyslne
-------------------------
*/
//Modul Config:
//1.*************************** dodaje modul
$ddlModuleAddToCmsModules = "Insert Into cmsModules (`ModuleName`, `ModuleShortName`, `ModuleVersion`, `ModulePath`, `ModuleDirPath`) Values
						('Moduł konfiguracyjny', 'Config', '1.0', '../Modules/Config/Config.php' , '../Modules/Config/' )";
$DBInt->ExecQuery($ddlModuleAddToCmsModules);

//2.**************************** dodaje strone
$ddlPageAdd = "Insert Into cmsPages (`PageName`, `ShortName`, `Active`, `AuthorizedOnly`, `Desc`) Values
									('Strona konfiguracyjna', 'ConfigPage', 'T', 'N', 'Strona konfiguracyjna')";
$DBInt->ExecQuery($ddlPageAdd);

//3.*************************** dodaje wpis do cmsModulesActions
$sqlGetModuleId = "Select id From cmsModules Where ModuleShortName = 'Config'";
$result = $DBInt->ExecQuery($sqlGetModuleId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$moduleId = $data['id'];

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Wyświetl konfiguracje', 'printConfig', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);
//4.*************************** dodaje sekcje
$sqlGetActionId = "Select id From cmsModulesActions Where FK_ModuleId = $moduleId";
$result = $DBInt->ExecQuery($sqlGetActionId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$moduleActionId = $data['id'];
//pobieram PageId

$sqlGetPageId = "Select id From cmsPages Where ShortName = 'ConfigPage'";
$result = $DBInt->ExecQuery($sqlGetPageId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$pageId = $data['id'];


$ddlSectionAdd = "Insert Into cmsSections (`Name`, `ShortName`, `Priority`, `ContentType`, `FK_ModuleId`, `FK_ModuleAction`, `FK_PageId`) Values
						('Sekcja konfiguracyjna', 'Config', 1, 1, $moduleId, $moduleActionId, $pageId)";
$DBInt->ExecQuery($ddlSectionAdd);

//5. ****************************  dodaje wopis do tabeli cmsSectionsToPages
//pobieram SectionId
$sqlGetSectionId = "Select id From cmsSections Where Name = 'Sekcja konfiguracyjna'";
$result = $DBInt->ExecQuery($sqlGetSectionId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$sectionId = $data['id'];


$ddlSectionsToPagesAdd = "Insert Into cmsSectionsToPages (`PK_PageId`, `PK_SectionId`)
						Values ($pageId, $sectionId)";
$DBInt->ExecQuery($ddlSectionsToPagesAdd);

//6. tworze menu
$dmlMenu = "INSERT INTO cmsMenu(`Name`,`ShortName`, `FK_PageId`, `Index`, `AdminMenu`) Values ('Konfiguracja','Config', $pageId, 1, 'T');";
$DBInt->ExecQuery($dmlMenu);
//*************************************************************************************


//-----------------------ADMNISTRATORZY-------------------------


//*************modul administratorzy
//1.*************************** dodaje modul
$ddlModuleAddToCmsModules = "Insert Into cmsModules (`ModuleName`, `ModuleShortName`, `ModuleVersion`, `ModulePath`, `ModuleDirPath`) Values
						('Moduł administratorzy', 'AdminUsr', '1.0', '../Modules/AdminUsr/AdminUsr.php', '../Modules/AdminUsr/')";
$DBInt->ExecQuery($ddlModuleAddToCmsModules);

//2.**************************** dodaje strone
$ddlPageAdd = "Insert Into cmsPages (`PageName`, `ShortName`, `Active`, `AuthorizedOnly`, `Desc`) Values
									('Administratorzy', 'AdminUsrPage', 'T', 'N', 'Administratorzy')";
$DBInt->ExecQuery($ddlPageAdd);

//3.*************************** dodaje wpis do cmsModulesActions

$sqlGetModuleId = "Select id From cmsModules Where ModuleShortName = 'AdminUsr'";
$result = $DBInt->ExecQuery($sqlGetModuleId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$moduleId = $data['id'];

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Lista administratorów', 'showAdmins', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Dodaj administratora', 'adminAdd', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Zapis danych admin', 'adminAddDo', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Logowanie admin', 'adminLogin', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Wylogowanie admin', 'adminLogout', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Edycja danych admin', 'adminEdit', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);

$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `FK_ModuleId`)
							values ('Usuniecie admina', 'adminDelete', $moduleId)";
$DBInt->ExecQuery($ddlActionAdd);


//4.*************************** dodaje sekcje
$sqlGetActionId = "Select id From cmsModulesActions Where FK_ModuleId = $moduleId and ActionShortName='".'showAdmins'."'";
$result = $DBInt->ExecQuery($sqlGetActionId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$moduleActionId = $data['id'];
//pobieram PageId

$sqlGetPageId = "Select id From cmsPages Where ShortName = 'AdminUsrPage'";
$result = $DBInt->ExecQuery($sqlGetPageId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$pageId = $data['id'];


$ddlSectionAdd = "Insert Into cmsSections (`Name`, `ShortName`, `Priority`, `ContentType`, `FK_ModuleId`, `FK_ModuleAction`, `FK_PageId`) Values
						('Sekcja administratorzy', 'AdminSect', 1, 1, $moduleId, $moduleActionId, $pageId)";
$DBInt->ExecQuery($ddlSectionAdd);

//5. ****************************  dodaje wopis do tabeli cmsSectionsToPages
//pobieram SectionId
$sqlGetSectionId = "Select id From cmsSections Where Name = 'Sekcja administratorzy'";
$result = $DBInt->ExecQuery($sqlGetSectionId);
$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
$sectionId = $data['id'];


$ddlSectionsToPagesAdd = "Insert Into cmsSectionsToPages (`PK_PageId`, `PK_SectionId`)
						Values ($pageId, $sectionId)";
$DBInt->ExecQuery($ddlSectionsToPagesAdd);

//6. tworze menu

$dmlMenu = "INSERT INTO cmsMenu(`Name`, `ShortName`,`FK_PageId`, `FK_ParentMenuItem`, `Index`, `AdminMenu`) Values 
	('Użytkownicy (CMS)', 'CmsUsers', $pageId, 3, 1, 'T');";
$DBInt->ExecQuery($dmlMenu);
//*************************************************************************************

?>