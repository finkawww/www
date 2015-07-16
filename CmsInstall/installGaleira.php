<?php

include '../Includes/application.inc.php';

error_reporting(E_ALL); 
ini_set('display_errors',1); 

$DBInt = DBSingleton::getInstance();

$tabGal = 'CREATE TABLE `db1_murmur_h2_pl`.`GALERIE`(
	`id` int(10) Unsigned not null auto_incrememnt,
	`nazwa` varchar(25) not null,
	PRIMARY KEY (`id`)
	)';

$tabRealizacje = 'CREATE TABLE `db1_murmur_h2_pl`.`REALIZACJE`(
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`galeriaId` INT(10) UNSIGNED NOT NULL,
	`opis` TEXT(250) NULL,
	`kolejnosc` INT(10) NOT NULL AUTO_INCREMENT,
	`slowa_kluczowe` VARCHAR(100) NULL,
	`priorytet` INT(5) NOT NULL DEFAULT 0,
	PRIMARY KEY(`id`),
	CONSTRAINT `FK_galeriaId` FOREIGN KEY `FkGalId`(`galeriaId`) 
	REFERENCES `Galeria`(`id`)
	ON DELETE RESTRICT
	ON UPDATE CASCADE,
	)';	

$tabZdjecia = 'CREATE TABLE `db1_murmur_h2_pl`.`ZDJECIA`(
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`URL` VARCHAR(250) NOT NULL,
	`kolejnosc` INT(10) NOT NULL AUTO_INCREMENT,
	`realizacjaID` INT(10) UNSIGNED NOT NULL,
	`Miniatura` INT(1) UNSIGNED NOT NULL DEFAULT 0,
	`idMiniatury` INT(10) UNSIGNED,
	PRIMARY KEY (`id`),
	CONSTRAINT `FK_RealizacjeId` FOREIGN KEY `FkRealizacje`(`realizacjaId`) 
	REFERENCES `Realizacje`(`id`)
	ON DELETE RESTRICT
	ON UPDATE CASCADE,
	CONSTRAINT `FK_MiniaturaId` FOREIGN KEY `FkMiniatura`(`idMiniatury`) 
	REFERENCES `Zdjecia`(`id`)
	ON DELETE CASCADE
	ON UPDATE CASCADE	
	)';

//ALTER TABLE `db1_murmur_h2_pl`.`REALIZACJE` ADD FULLTEXT(slowa_kluczowe, opis);
//ALTER TABLE `db1_murmur_h2_pl`.`REALIZACJE` 


//$DBInt->ExecQuery($tabGal);
//$DBInt->ExecQuery($tabRealizacje);
echo '1';
$DBInt->ExecQuery($tabZdjecia);
echo '2';

	
?>