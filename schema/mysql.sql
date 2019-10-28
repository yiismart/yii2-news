create table if not exists `news`
(
    `id` int(10) not null auto_increment,
    `alias` varchar(200) not null,
    `active` tinyint(1) default 1,
    `title` varchar(100) not null,
    `date` date not null,
    `time` time default null,
    `image` varchar(200) default null,
    `description` text,
    `text` text,
    `modifyDate` datetime,
    `viewCount` integer default 0,
    primary key (`id`),
    unique key `alias` (`alias`)
) engine InnoDB;
