CREATE TABLE NewsletterMessages
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    title VARCHAR(250) NOT NULL    
    
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DELIMITER $$
CREATE TRIGGER trgNewsletterMessageAI AFTER INSERT ON NewsletterMessages
FOR EACH ROW
BEGIN
    INSERT INTO Newsletters SET messageId=NEW.id;
END$$
DELIMITER ;
---------------------------------------------------------


CREATE TABLE Newsletters
(
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    messageId int(10) UNSIGNED UNIQUE NOT NULL ,
    xmlLog TEXT NULL,
    send_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
               ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT messageFk FOREIGN KEY(messageId) REFERENCES NewsletterMessages(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

--------------------------------------------------------


CREATE TABLE NewsletterUsers
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE NewsletterConfig
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    test char NOT NULL DEFAULT 'N',    
    smtp VARCHAR(200) NOT NULL,
    port int NOT NULL,
    user VARCHAR(50) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    `from` VARCHAR(50) NOT NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;




