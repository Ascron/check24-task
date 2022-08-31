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

create table comment
(
    id           int unsigned auto_increment
        primary key,
    author_id    int unsigned not null,
    author_name  varchar(255) not null,
    author_email varchar(255) not null,
    text         text not null
);

