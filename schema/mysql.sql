create table if not exists `news`
(
    `id` int(10) not null auto_increment,
    `url` varchar(200) not null,
    `active` tinyint(1) default 1,
    `title` varchar(100) not null,
    `date` date not null,
    `image` varchar(200) default null,
    `description` text,
    `text` text,
    `modifyDate` datetime,
    primary key (`id`),
    unique key `url` (`url`)
) engine InnoDB;
