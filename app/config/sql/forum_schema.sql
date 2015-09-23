CREATE TABLE `user` (
    `user_id` int(10) NOT NULL AUTO_INCREMENT,
    `username` varchar(20) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `firstname` varchar(30) NOT NULL,
    `lastname` varchar(30) NOT NULL,
    `email` varchar(50) NOT NULL UNIQUE,
    `department` varchar(30) NOT NULL,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `thread` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `user_id` int(10) NOT NULL,
    `title` varchar(50) NOT NULL,
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category` enum('Random','Manga/Anime','Video Games','Funny','Animals') NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `comment` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `thread_id` int(10) NOT NULL,
    `user_id` int(10) NOT NULL,
    `body` TEXT NOT NULL,
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `likes` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `comment_id` int(10) NOT NULL,
    `user_id` int(10) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `bookmark` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `thread_id` int(10) NOT NULL,
    `user_id` int(10) NOT NULL,
    PRIMARY KEY (`id`)
);

ALTER TABLE `thread` ADD CONSTRAINT `thread_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`);

ALTER TABLE `comment` ADD CONSTRAINT `comment_fk0` FOREIGN KEY (`thread_id`) REFERENCES `thread`(`id`);

ALTER TABLE `comment` ADD CONSTRAINT `comment_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`);

ALTER TABLE `likes` ADD CONSTRAINT `likes_fk0` FOREIGN KEY (`comment_id`) REFERENCES `comment`(`id`);

ALTER TABLE `likes` ADD CONSTRAINT `likes_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`);

ALTER TABLE `bookmark` ADD CONSTRAINT `bookmark_fk0` FOREIGN KEY (`thread_id`) REFERENCES `thread`(`id`);

ALTER TABLE `bookmark` ADD CONSTRAINT `bookmark_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`);

