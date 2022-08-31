drop table if exists `article`;
drop table if exists `user`;
drop table if exists `comment`;

create table article
(
    id         int unsigned auto_increment
        primary key,
    created_at datetime     not null,
    image_url  varchar(255) not null,
    title      varchar(255) not null,
    author_id  int unsigned not null,
    text       text         not null
);

create table user
(
    id       int unsigned auto_increment
        primary key,
    username varchar(255) not null,
    password varchar(255) not null
);

insert into check24.article (id, created_at, image_url, title, author_id, text) values (1, '2022-08-31 15:22:44', 'https://via.placeholder.com/350x150', 'Title 1', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
insert into check24.user (id, username, password) values (1, 'Ascron', 'test_hashe');



create table comment
(
    id           int unsigned auto_increment
        primary key,
    author_id    int unsigned not null,
    author_name  varchar(255) not null,
    author_email varchar(255) not null,
    text         text not null
);

