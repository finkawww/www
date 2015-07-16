<?php
include '../Includes/application.inc.php';

error_reporting(E_ALL); 
ini_set('display_errors',1); 

$ddlKontakt = "
				CREATE TABLE `db2_tiksoft_h2_pl`.`Kontakt`
				(
					`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
					`SMTPServer` VARCHAR(125) NOT NULL,
					`PORT` INT(10) NOT NULL,
					`Login` VARCHAR(25) NOT NULL,
					`Pass` VARCHAR(100),
					`Do` VARCHAR(100),
					`Od` VARCHAR(100),
					`Tytul` VARCHAR(100),
					PRIMARY  KEY (`id`)  
				)
				ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_general_ci;";

$menuMgr = menuMgr :: getInstance();
$moduleMgr = new modulesMgr();
$pageMgr = new pagesMgr();
$sectionMgr = new sectionsMgr();
$DBInt = DBSingleton::getInstance();

$DBInt->ExecQuery($ddlKontakt);
echo "1";
$pageMgr->addPage('KontaktPage', 'KontaktPage', 'T','T', 'T', 'Kontakt');
echo "2";
$menuMgr->addMenuItem('Moduly', 'Kontakt', 'Kontakt', '', 2, 'T', 'L');
echo "3";
$menuMgr->setMenuCaption($menuMgr->getMenuIdByName('Kontakt'), 'PL', 'Kontakt');
echo "4";
$moduleMgr->addModule('Kontakt', 'Kontakt', 1, '../Modules/Kontakt/Kontakt.php', '../Modules/Kontakt/');
echo "5";
$moduleMgr->addModuleAction('Pokazanie formularza', 'Display', 'Kontakt', 'N', 'N');
echo "7";
$moduleMgr->addModuleAction('Konfiguracja formularza', 'Config', 'Kontakt', 'T', 'T');
echo "8";
$sectionMgr->addModuleSection('Sekcja Kontakt', 'KontaktSect', 1, 'Kontakt', 'Config');
echo "9";
$sectionMgr->assignSectionToPage('KontaktSect', 'KontaktPage');
echo "10";
$menuMgr->setMenuItemPage('Kontakt', 'KontaktPage');
echo "11";
?>