drop table if exists users;
create table users(
    id int auto_increment primary key,
    nombre varchar(40) not null,
    apellidos varchar(80) not null,
    email varchar(120) not null unique,
    perfil enum('Admin', 'Normal') default 'Admin'
);