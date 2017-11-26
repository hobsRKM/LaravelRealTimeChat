
ALTER TABLE  `users` ADD  `gender` VARCHAR( 50 ) NOT NULL ,
ADD  `birthday` VARCHAR( 50 ) NOT NULL ,
ADD  `summary` TEXT NOT NULL

ALTER TABLE  `users` CHANGE  `contact`  `contact` VARCHAR( 20 ) NULL DEFAULT NULL

CREATE TABLE `fusionmate`.`team_conversations_read_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `team_channel_id` INT NULL,
  `message_id` INT NULL,
  `user_id` INT NULL,
  `read_status` INT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));
  
  
  CREATE TABLE `fusionmate`.`project` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_name` VARCHAR(255) NULL,
  `author_id` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));

  
  CREATE TABLE `fusionmate`.`tracker` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));

  CREATE TABLE `fusionmate`.`tracker_status_names` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));

  INSERT INTO `fusionmate`.`tracker` (`name`) VALUES ('Task');
INSERT INTO `fusionmate`.`tracker` (`name`) VALUES ('Feature');
INSERT INTO `fusionmate`.`tracker` (`name`) VALUES ('Backlog');
INSERT INTO `fusionmate`.`tracker` (`name`) VALUES ('Bug');

INSERT INTO `fusionmate`.`tracker_status_names` (`name`) VALUES ('New');
INSERT INTO `fusionmate`.`tracker_status_names` (`name`) VALUES ('In Progress');
INSERT INTO `fusionmate`.`tracker_status_names` (`name`) VALUES ('Resolved');
INSERT INTO `fusionmate`.`tracker_status_names` (`name`) VALUES ('Feedback');
INSERT INTO `fusionmate`.`tracker_status_names` (`name`) VALUES ('Closed');

CREATE TABLE `fusionmate`.`tracker_priority` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));

  INSERT INTO `fusionmate`.`tracker_priority` (`name`) VALUES ('Low');
INSERT INTO `fusionmate`.`tracker_priority` (`name`) VALUES ('Normal');
INSERT INTO `fusionmate`.`tracker_priority` (`name`) VALUES ('High');
INSERT INTO `fusionmate`.`tracker_priority` (`name`) VALUES ('Urgent');
INSERT INTO `fusionmate`.`tracker_priority` (`name`) VALUES ('Immideate');


CREATE TABLE `fusionmate`.`team_heads` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_id` INT NULL,
  `team_id` INT NULL,
  `user_id` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  `updated_at` TIMESTAMP NULL DEFAULT NOW(),
  PRIMARY KEY (`id`));

  ALTER TABLE `fusionmate`.`project` 
RENAME TO  `fusionmate`.`projects` ;


ALTER TABLE `fusionmate`.`team_heads` 
ADD COLUMN `author_id` INT NULL AFTER `team_id`;
