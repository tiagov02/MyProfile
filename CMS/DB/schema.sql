create table if not exists aboutme
(
    text       varchar(1000)          null,
    imagepath  varchar(700)           null,
    id         int auto_increment
    primary key,
    updated_on date default curdate() not null,
    constraint aboutme_id_uindex
    unique (id)
    );

create table if not exists acess
(
    id         int auto_increment
    primary key,
    deviceType varchar(10)            not null,
    ip_adress  varchar(100)           not null,
    date       date default curtime() null,
    constraint acess_id_uindex
    unique (id)
    );

create table if not exists contacts
(
    id   int auto_increment
    primary key,
    name varchar(10) null,
    link varchar(50) null,
    constraint contacts_id_uindex
    unique (id)
    );

create table if not exists education
(
    id          int auto_increment
    primary key,
    place       varchar(100)  not null,
    description varchar(1000) not null,
    year_ini    int           not null,
    year_end    int           null,
    constraint education_id_uindex
    unique (id)
    );

create table if not exists languages
(
    id    int auto_increment
    primary key,
    name  varchar(100) null,
    level varchar(100) null,
    constraint languages_id_uindex
    unique (id),
    constraint languages_name_uindex
    unique (name)
    );

create table if not exists skills
(
    id          int auto_increment
    primary key,
    description int null,
    constraint skills_description_uindex
    unique (description),
    constraint skills_id_uindex
    unique (id)
    );

create table if not exists technologies
(
    id          int auto_increment
    primary key,
    name        varchar(100) not null,
    description varchar(500) null,
    constraint technologies_id_uindex
    unique (id),
    constraint technologies_name_uindex
    unique (name)
    );

create table if not exists users
(
    id       int auto_increment
    primary key,
    username varchar(50)  not null,
    password varchar(255) not null,
    constraint users_username_uindex
    unique (username)
    );

create table if not exists user_roles
(
    id_user int         not null
    primary key,
    role    varchar(50) null,
    constraint user_roles_users_id_fk
    foreign key (id_user) references users (id)
    );


