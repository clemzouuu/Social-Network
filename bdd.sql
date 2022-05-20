CREATE DATABASE IF NOT EXISTS `twitter_db`  
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;  

use twitter_db;

CREATE TABLE `twitter_id` (   
    `id`  INT NOT NULL auto_increment,
    `login` TEXT,   
    `password` TEXT, 
    `city` TEXT,
    `school` TEXT,
    `speciality` TEXT,
    `age` TINYINT,
    `profile_picture` TEXT,
    `seconde_picture` TEXT,
    `actif` INT,
    CONSTRAINT pk_twitter PRIMARY KEY (`id`)  
    ) ENGINE=InnoDB ;

CREATE TABLE if not EXISTS `all_twits`(
    `twit_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `profil_picture` TEXT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `answer` TEXT,
    `answering_person` TEXT,
    PRIMARY KEY (`twit_id`),
    FOREIGN KEY (`id`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `groupe`(
    `group_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `profile_picture` TEXT,
    `seconde_picture` TEXT,
    `admin` TEXT,
    `number` INT,
    CONSTRAINT pk_groupe PRIMARY KEY (`group_id`)
);

CREATE TABLE if not EXISTS `admin` (
`user` INT,
`group_id` INT,
CONSTRAINT pk_admin PRIMARY KEY (`user`, `group_id`),
FOREIGN KEY (`user`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
FOREIGN KEY (`group_id`) REFERENCES `groupe`(`group_id`) ON DELETE CASCADE
);


CREATE TABLE if not EXISTS `tweet_answers`(
    `id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `tweet_id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`tweet_id`) REFERENCES `all_twits`(`twit_id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `tweet_answers_groupe`(
    `id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `tweet_id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`tweet_id`) REFERENCES `all_tweets_groupe`(`tweet_id`) ON DELETE CASCADE
);


CREATE TABLE if not EXISTS `tweet_answers_groupe_prive`(
    `id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `tweet_id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`tweet_id`) REFERENCES `all_tweets_groupe_prive`(`tweet_id`) ON DELETE CASCADE
);


CREATE TABLE if not EXISTS `message`(
    `id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id_destinataire` INT,
    `id_auteur` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    CONSTRAINT pk_message PRIMARY KEY (`id`)
);

CREATE TABLE if not EXISTS `groupe_2`(
    `group_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `admin` TEXT,
    `profile_picture` TEXT,
    `seconde_picture` TEXT,
    CONSTRAINT pk_groupe PRIMARY KEY (`group_id`)
);

CREATE TABLE if not EXISTS `groupe_prive`(
    `group_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `admin` TEXT,
    `profile_picture` TEXT,
    `seconde_picture` TEXT,
    CONSTRAINT pk_groupe PRIMARY KEY (`group_id`)
);

CREATE TABLE if not EXISTS `admin_groupe` (
`user` INT,
`group_id` INT,
CONSTRAINT pk_admin PRIMARY KEY (`user`, `group_id`),
FOREIGN KEY (`user`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
FOREIGN KEY (`group_id`) REFERENCES `groupe_2`(`group_id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `admin_groupe_prive` (
`user` INT,
`group_id` INT,
`membre` INT,
CONSTRAINT pk_admin PRIMARY KEY (`user`, `group_id`),
FOREIGN KEY (`user`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
FOREIGN KEY (`group_id`) REFERENCES `groupe_prive`(`group_id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `membre_groupe_prive` (
`user` INT,
`group_id` INT,
`membre` INT,
CONSTRAINT pk_admin PRIMARY KEY (`user`, `group_id`),
FOREIGN KEY (`user`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
FOREIGN KEY (`group_id`) REFERENCES `groupe_prive`(`group_id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `all_tweets_groupe`(
    `tweet_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `group_id` INT,
    `profil_picture` TEXT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `answer` TEXT,
    `answering_person` TEXT,
    PRIMARY KEY (`tweet_id`),
    FOREIGN KEY (`id`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`group_id`) REFERENCES `groupe_2`(`group_id`) ON DELETE CASCADE
);

CREATE TABLE if not EXISTS `all_tweets_groupe_prive`(
    `tweet_id` INT NOT NULL auto_increment,
    `name` VARCHAR(255),
    `id` INT,
    `group_id` INT,
    `profil_picture` TEXT,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT,
    `answer` TEXT,
    `answering_person` TEXT,
    PRIMARY KEY (`tweet_id`),
    FOREIGN KEY (`id`) REFERENCES `twitter_id`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`group_id`) REFERENCES `groupe_prive`(`group_id`) ON DELETE CASCADE
    
);