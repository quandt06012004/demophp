create database tt_con_nguoi;

use tt_con_nguoi;

create table province 
(
    id int primary key auto_increment,
    name varchar(100) not null
);

create table human
(
    id int primary key auto_increment,
    name varchar(100) not null,
    email varchar(100) not null unique,
    phone varchar(12) not null unique,
    gender tinyint(1) not null default 0,
    birthday date not null,
    avatar varchar(150) not null,
    province_id int not null,
    description text not null,
    foreign key (province_id) references province(id)
);


insert into province (name) values
('hà nội'),
('hà nam'),
('nghệ an');
