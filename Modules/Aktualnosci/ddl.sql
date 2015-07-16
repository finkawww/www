CREATE TABLE `tiksoft_db`.`Aktualnosci`
					(
						`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`Data` DATE NOT NULL,
						`Tytul` VARCHAR(50) NOT NULL,
						`Tresc` TEXT NOT NULL,
						 PRIMARY KEY (`id`)
				 	)
				 	ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_general_ci;"

CREATE TABLE `tiksoft_db`.`AktualnosciLang`(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` VARCHAR(3) NULL,
  `tytul` VARCHAR(50) NOT NULL,
  `tresc` TEXT NOT NULL,
  `FkAktualnosci` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_Aktual2`
    FOREIGN KEY (`FkAktualnosci`)
    REFERENCES `Aktualnosci` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


DROP TRIGGER IF EXISTS `ai_Aktualnosci`;

CREATE TRIGGER `ai_Aktualnosci` AFTER INSERT ON `Aktualnosci`
 FOR EACH ROW BEGIN
DECLARE lang VARCHAR(3);
DECLARE done INT DEFAULT 0;
DECLARE langCursor CURSOR FOR SELECT `ShortName` FROM `cmsLang` WHERE `ShortName` <> 'PL';
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

OPEN langCursor;

read_loop:LOOP
   FETCH langCursor INTO lang;
   
   IF done THEN 
        LEAVE read_loop;
    END IF;
   
   INSERT INTO `AktualnosciLang` (`tytul`, `tresc`,   `lang`, `FkAktualnosci`)
   VALUES (NEW.`tytul`, NEW.`opis`, lang, NEW.`id`);
END LOOP;  
CLOSE langCursor;
end
