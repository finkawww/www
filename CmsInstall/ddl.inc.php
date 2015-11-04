<?php

//Nieuzywane
$ddlDBDrop= "DROP DATABASE IF EXISTS ``";
$ddlDBCreate = "CREATE DATABASE WWW";

//FIXME Zamienić Language na FK do cmsLanguages
//FIXME w cmsSectionsToPages dodać KONIECZNIE w pierwszej wersji CONSTRAINT z ON DELETE CASCADE
$ddlSectionsToPages = "	
					CREATE TABLE `db1_galeria_h2_pl`.`cmsSectionsToPages`
					(
						`id` Int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`PK_PageId` INT(10) UNSIGNED NOT NULL,
						`PK_SectionId` INT(10) UNSIGNED NOT NULL,
						`Language` CHAR(3),
					PRIMARY KEY (`Id`, `PK_PageID`, `PK_SectionID`)
					) 
					ENGINE = INNODB
					CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlSectionsTbl = " 
					CREATE TABLE `db1_galeria_h2_pl`.`cmsSections`
					(
						`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`Name` VARCHAR(25) NOT NULL,
						`ShortName` VARCHAR(25) NOT NULL UNIQUE,
						`Priority` INT(10) NOT NULL,
						`ContentType` INT(10) NOT NULL,
						`FK_ModuleId` INT(10) UNSIGNED,
						`FK_ModuleAction` INT(10) UNSIGNED,
						`Content` TEXT,
					PRIMARY KEY (`id`),
					CONSTRAINT `FK_ModuleId` FOREIGN KEY `FK_ModuleIdFk`(`FK_ModuleId`) 
						REFERENCES `cmsModules`(`id`)
						ON DELETE SET NULL
						ON UPDATE CASCADE,
					CONSTRAINT `FK_ModuleAction` FOREIGN KEY `FK_ModuleActionFk`(`FK_ModuleAction`)
						REFERENCES `cmsModulesActions`(`id`)
						ON DELETE SET NULL
						ON UPDATE CASCADE
				 	)
				 	ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlTemplatesTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsTemplates`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Name` VARCHAR(25) NOT NULL,
					`ShortName` VARCHAR(25) NOT NULL,
					`Icon` VARCHAR(100),
					`Path` VARCHAR(100) NOT NULL,
					`FileName` VARCHAR(100) NOT NULL,
					`Main` CHAR(1) NOT NULL DEFAULT 'T',
					PRIMARY  KEY (`id`)  
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlUpdatesTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsUpdates`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Version` VARCHAR(10) NOT NULL,
					`Date` Date NOT NULL,
					`Description` VARCHAR(250),
					PRIMARY  KEY (`id`)  
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlBugsTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsBugs`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Version` VARCHAR(10) NOT NULL,
					`Date` Date NOT NULL,
					`Status` INT(10) NOT NULL DEFAULT 0,
					`User` VARCHAR(25) NOT NULL,
					`Description` VARCHAR(250),
					PRIMARY  KEY (`id`)  
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";


$ddlPagesTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsPages`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`PageName` VARCHAR(25) NOT NULL,
					`ShortName` VARCHAR(25) NOT NULL UNIQUE,
					`Active` CHAR(1) DEFAULT  'T',
					`Admin` CHAR(1) DEFAULT 'N',
					`AuthorizedOnly` CHAR(1) DEFAULT 'T',
					`MenuTop` CHAR(1) DEFAULT 'T',
					`MenuLeft` CHAR(1) DEFAULT 'T',
					`MenuRight` CHAR(1) DEFAULT 'N',
					`MenuBottom` CHAR(1) DEFAULT 'T',
					`Desc` TEXT,
					`TemplateId` INT(10) UNSIGNED NULL,
				PRIMARY  KEY (`id`),
				CONSTRAINT `FK_Templates` FOREIGN KEY `TemplateId`(`TemplateId`)
						REFERENCES `cmsTemplates`(`id`)
						ON DELETE SET NULL
						ON UPDATE CASCADE,
				CHECK (`Active` IN ('T', 'N'))
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlModulesTbl = "
					CREATE TABLE `db1_galeria_h2_pl`.`cmsModules`
					(
						`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`ModuleName` VARCHAR(25) NOT NULL,
						`ModuleShortName` VARCHAR(25) NOT NULL UNIQUE,
						`ModuleVersion` INT(10),
						`ModulePath` VARCHAR(256) NOT NULL,
						`ModuleDirPath` VARCHAR(256) NOT NULL,
					PRIMARY KEY (`Id`)
				  	)
				  	ENGINE = INNODB
				  	CHARACTER SET utf8 COLLATE utf8_general_ci;";

//FIXME Dodać indeksy na poszczególnych modułach
$ddlModulesActionsTbl = "
						CREATE TABLE `db1_galeria_h2_pl`.`cmsModulesActions` 
						(
 							`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
							`ActionName` VARCHAR(50) NOT NULL,
							`ActionShortName` VARCHAR(25) NOT NULL UNIQUE,
							`Admin` CHAR(1) NOT NULL DEFAULT 'T',
							`Authorization` CHAR(1) NOT NULL DEFAULT 'N',
							`Active` CHAR(1) NOT NULL DEFAULT 'T',
							`FK_ModuleId` INT(10) UNSIGNED,
						PRIMARY KEY (`Id`),
						CONSTRAINT `FK_1` FOREIGN KEY `FK_ModuleIdFK`(`FK_ModuleId`)
							REFERENCES `cmsModules`(`id`)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
						CHECK (`Active` IN ('T', 'N')),
						CHECK (`Admin` IN ('T', 'N')),
						CHECK (`Authorization` IN ('T', 'N')),
						CHECK (
								(`Admin` = 'T' And `Authorization` = 'N') 
								OR (`Admin` = 'N' And 'Authorization' = 'T') 
								OR (`Admin`='N' And `Authorization` = 'N') 
							   )							
						)
						ENGINE=INNODB
					   	CHARACTER SET utf8 COLLATE utf8_general_ci;";
$ddlModulesActionsTrigger = "
					CREATE TRIGGER `db1_galeria_h2_pl`.`ActionsAfterIns` AFTER INSERT ON `db1_galeria_h2_pl`.`cmsModulesActions` FOR EACH ROW
					BEGIN
						SET @actionId = NEW.id;
						INSERT INTO `db1_galeria_h2_pl`.`cmsPrivileges`(`ModulesActionFk`, `UsersFk`) VALUES (@actionId, 1);
					END;
					";

$ddlLangTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsLang`
				(
					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Name` VARCHAR(25) NOT NULL,
					`ShortName` CHAR(3) NOT NULL UNIQUE,
					`Icon` VARCHAR(255),
					`Active` CHAR(1) DEFAULT  'T',
				CONSTRAINT pk_cmsLang PRIMARY KEY (Id),
				CONSTRAINT dd CHECK (`Active` IN ('T', 'N'))
			   	)
			   	ENGINE = INNODB
			   	CHARACTER SET utf8 COLLATE utf8_general_ci;";

// usuwanie podmenu wraz z nadmenu
$ddlMenuTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsMenu`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Name` VARCHAR(50) NOT NULL,
					`ShortName` VARCHAR(20) NOT NULL UNIQUE,
					`FK_PageId` INT(10) UNSIGNED,
					`FK_ParentMenuItem` INT(10) UNSIGNED,
					`Index` INT(10) NOT NULL,
					`Position` CHAR(1) DEFAULT 'L' NOT NULL,
					`AdminMenu` CHAR(1) DEFAULT 'N' NOT NULL,
					`Active` CHAR(1) DEFAULT 'T' NOT NULL,
				PRIMARY KEY (`id`),
				CONSTRAINT `cmsMenuFK1` FOREIGN KEY `Fk_PageIdFk`(`FK_PageId`)
					REFERENCES `cmsPages`(`id`)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
				CONSTRAINT `cmsParentMenuFK1` FOREIGN KEY `Fk_ParentMenuFk`(`FK_ParentMenuItem`)
					REFERENCES `cmsMenu`(`id`)
					ON DELETE CASCADE
					ON UPDATE CASCADE,
				CHECK (`Active` IN ('T', 'N')),
				CHECK (`Position` IN ('L', 'R', 'T', 'B')),
				CHECK ( ( (`FK_ParentMenuItem` IS NULL)AND(`Position` IN ('T', 'B')) ) OR
						( (`FK_ParentMenuItem` IS NOT NULL)AND(`Position` IN ('L', 'R')) ) 
					  ),
				CHECK (`FK_ParentMenuItem` <> `id`)
				)
			   	ENGINE = INNODB
			   	CHARACTER SET utf8 COLLATE utf8_general_ci;";

$ddlMenuItemsCaption = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsMenuItemsCaptions`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`FkLang` INT(10) UNSIGNED NOT NULL,
					`FkMenu` INT(10) UNSIGNED NOT NULL,
					`Caption` VARCHAR(50),
					CONSTRAINT `langFK` FOREIGN KEY `FkLangFK`(`FkLang`)
					REFERENCES `cmsLang`(`id`)
						ON DELETE RESTRICT
						ON UPDATE CASCADE,
					CONSTRAINT `menuFk` FOREIGN KEY `FkMenuFK`(`FkMenu`)
					REFERENCES `cmsMenu`(`id`)
						ON DELETE CASCADE
						ON UPDATE CASCADE
				)
				ENGINE = INNODB
			   	CHARACTER SET utf8 COLLATE utf8_general_ci;";				
				;

$ddlMenuView = "
				CREATE VIEW `db1_galeria_h2_pl`.`cmsMenuView` AS
					SELECT
						id, Name, ShortName, FK_PageId, 
						CASE 
							WHEN FK_ParentMenuItem IS NULL THEN 0
							ELSE FK_ParentMenuItem
						END AS FK_ParentMenuItem, 
						`Index`, `Position`, AdminMenu, Active
					FROM
						`db1_galeria_h2_pl`.`cmsMenu`;
			";

$ddlUsersTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsUsers`
				(
					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Name` VARCHAR(25),
					`LastName` VARCHAR(25),
					`Login` VARCHAR(15) NOT NULL UNIQUE,
					`Pass` VARCHAR(100) NOT NULL,
					`Active` CHAR(1) DEFAULT 'T',
					`Root` CHAR(1) DEFAULT 'N',
					`LastLogin` VARCHAR(50),
				PRIMARY KEY (`Id`),
				CHECK (`Active` IN ('T', 'N')),
				CHECK (`Root` IN ('T', 'N'))
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";



//tabela trymajaca konfiguracje strony
$ddlConfigTbl = "
				CREATE TABLE `db1_galeria_h2_pl`.`cmsConfig`
				(
					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`Title` VARCHAR(50) NULL,
					`DefaultPageFk` INT(10) UNSIGNED,
					`DefaultLanguageFk` INT(10) UNSIGNED,
					`KeyWords` TEXT,
					`PageDescription` TEXT,
					`PageAuthor` VARCHAR(50),
					`Copyrights` VARCHAR(50),
					`Cache` CHAR(25),
					`Robots` CHAR(25),
				CONSTRAINT `cmsConfigPk` PRIMARY KEY (`id`),
				CONSTRAINT `Fk1` FOREIGN KEY `Fk_DefaultPageFk`(`DefaultPageFk`)
					REFERENCES `cmsPages`(`id`)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
				CONSTRAINT `Fk2` FOREIGN KEY `Fk_DefaultLanguageFk`(`DefaultLanguageFk`)
					REFERENCES `cmsLang`(`id`)
					ON UPDATE CASCADE
					ON DELETE SET NULL
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

 $ddlPrivileges = "
 				CREATE TABLE `db1_galeria_h2_pl`.`cmsPrivileges`(
					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`ModulesActionFk` INT(10) UNSIGNED,
					`UsersFk` INT(10) UNSIGNED,
				CONSTRAINT `cmsPrivilegePk` PRIMARY KEY (`id`),
				CONSTRAINT `PrivilegesFk1` FOREIGN KEY `Fk_ModulesActionsFk`(`ModulesActionFk`)
					REFERENCES `cmsModulesActions`(`id`)
					ON DELETE CASCADE
					ON UPDATE CASCADE,
				CONSTRAINT `PrivilegesFk2` FOREIGN KEY `Fk_UsersFk`(`UsersFk`)
					REFERENCES `cmsUsers`(`id`)
					ON DELETE CASCADE
					ON UPDATE CASCADE
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";
 
  $ddlCmsInfo = "
  				CREATE TABLE `db1_galeria_h2_pl`.`cmsInfo`(
  					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  					`message` VARCHAR(80),
  					`senderFK` INT(10) UNSIGNED NOT NULL,
  					`mode` VARCHAR(10) NOT NULL,
  				CONSTRAINT `cmsInfoPk` PRIMARY KEY (`Id`),
				CONSTRAINT `InfoUsersFk` FOREIGN KEY `Fk_senderFk`(`senderFK`)
					REFERENCES `cmsUsers`(`id`)
					ON UPDATE CASCADE
					ON DELETE RESTRICT
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

  //intersection
  $ddlCmsInfo2Users = "
  				CREATE TABLE `db1_galeria_h2_pl`.`cmsInfo2Users`
  				(
  					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  					`messageFK` INT(10) UNSIGNED NOT NULL,
  					`reciverFK` INT(10) UNSIGNED NOT NULL,
  				CONSTRAINT `cmsInfo2UsersPk` PRIMARY KEY (`id`),
				CONSTRAINT `FKReciverFk` FOREIGN KEY `Fk_reciverFk`(`reciverFk`)
					REFERENCES `cmsUsers`(`id`)
					ON DELETE CASCADE
					ON UPDATE CASCADE,
				CONSTRAINT `FKmessageFk` FOREIGN KEY `Fk_messageFk`(`messageFk`)
					REFERENCES `cmsInfo`(`id`)
					ON UPDATE CASCADE
					ON DELETE RESTRICT
					)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";
$ddlLogs = "
  				CREATE TABLE `db1_galeria_h2_pl`.`cmsLogs`(
  					`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  					`message` TEXT,
  					`userId` INT(10) UNSIGNED NOT NULL,
  					`data` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	
  				CONSTRAINT `cmsInfoPk` PRIMARY KEY (`Id`)
				
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";
  
  $ddlAddMessageProc = "
CREATE PROCEDURE `db1_galeria_h2_pl`.`addMessage`(IN senderID INT, IN reciverID INT, IN msg VARCHAR(12), IN vmode VARCHAR(10))
BEGIN
  DECLARE a INT;
  INSERT INTO `db1_galeria_h2_pl`.`cmsInfo`(`message`,`senderFK`,`mode`)VALUES(msg,senderID,vmode);
  SELECT LAST_INSERT_ID() INTO a;
  INSERT INTO `db1_galeria_h2_pl`.`cmsInfo2Users`(`messageFK`,`reciverFK`)VALUES(a,reciverID);
END";
  
  //indeksy
  $idx1 = 'CREATE INDEX `sn_sections_index` USING BTREE ON `cmsSections`(`ShortName`)';
  $idx2 = 'CREATE INDEX `sn_pages_index` USING BTREE ON `cmsPages`(`ShortName`)';
  $idx3 = 'CREATE INDEX `sn_module_index` USING BTREE ON `cmsModules`(`ModuleShortName`)';
  $idx4 = 'CREATE INDEX `sn_modules_actions_index` USING BTREE ON `cmsModulesActions`(`ActionShortName`)';
  $idx5 = 'CREATE INDEX `sn_lang_index` USING BTREE ON `cmsLang`(`ShortName`)';
  $idx6 = 'CREATE INDEX `sn_menu_index` USING BTREE ON `cmsMenu`(`ShortName`)';
 					
$DBInt = DBSingleton::getInstance();
echo 'Tworze DB<br />';
//$DBInt->ExecQuery($ddlDBDrop);
//$DBInt->ExecQuery($ddlDBCreate);
echo '-->OK<br />';

echo 'Tworze tabele cmsSectionsToPages <br />';
$DBInt->ExecQuery($ddlSectionsToPages);
echo '-->OK<br />';

echo 'Tworze tabele cmsTemplates <br />';
$DBInt->ExecQuery($ddlTemplatesTbl);
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
$DBInt->ExecQuery($ddlMenuItemsCaption);
$DBInt->ExecQuery($ddlMenuView);
echo '-->OK<br />';

echo 'Tworze tabele cmsUsers <br />';
$DBInt->ExecQuery($ddlUsersTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsPrivileges <br />';
$DBInt->ExecQuery($ddlPrivileges);
echo '-->OK<br />';

echo 'Tworze tabele cmsUpdates <br />';
$DBInt->ExecQuery($ddlUpdatesTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsBugs <br />';
$DBInt->ExecQuery($ddlBugsTbl);
echo '-->OK<br />';

echo 'Tworze tabele cmsLogs <br />';
$DBInt->ExecQuery($ddlLogs);
echo '-->OK<br />';

echo 'Tworze tabele cmsConfig <br />';
$DBInt->ExecQuery($ddlConfigTbl);
$DBInt->ExecQuery('INSERT INTO cmsConfig(`Title`) values("")');
echo '-->OK<br />';


echo 'Tworze tabele cmsInfo <br />';
$DBInt->ExecQuery($ddlCmsInfo);
echo '-->OK<br />';
$DBInt->ExecQuery($ddlCmsInfo2Users);
echo '-->OK<br />';
$DBInt->ExecQuery($ddlAddMessageProc);
echo '-->OK<br />';

echo 'Tworze Triggery <br/>';
//$DBInt->ExecQuery($ddlModulesActionsTrigger);
echo '-->OK<br/>';

echo 'Tworze dodatkowe indeksy <br />';
$DBInt->ExecQuery($idx1);
$DBInt->ExecQuery($idx2);
$DBInt->ExecQuery($idx3);
$DBInt->ExecQuery($idx4);
$DBInt->ExecQuery($idx5);
$DBInt->ExecQuery($idx6);
echo '-->OK <br />';
?>