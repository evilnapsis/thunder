/**
@author evilnapsis
**/
create database thunder;
use thunder;

create table user(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	lastname varchar(50) not null,
	username varchar(50),
	email varchar(255) not null,
	password varchar(60) not null,
	image varchar(255),
	is_active boolean not null default 1,
	is_admin boolean not null default 0,
	is_mesero boolean not null default 0,
	is_cajero boolean not null default 0,
	created_at datetime not null
);

insert into user(name,lastname,email,password,is_admin,created_at) value ("Administrador", "","admin","90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",1,NOW());

create table category(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	is_active boolean not null default 1
);

insert into category (name) value ("Tacos");
insert into category (name) value ("Caldos");

/* tabla para almacenar las mesas del restaurant*/
create table item(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	capacity int
);

insert into item (name,capacity) values ("1",6),("2",6),("3",6),("4",6),("5",6),("6",6),("7",6),("8",6),("9",6),("10",6);

create table product(
	id int not null auto_increment primary key,
	code varchar(50) not null,
	name varchar(50) not null,
	description varchar(50) not null,
	preparation varchar(50) not null,
	price_in float not null,
	price_out float,
	unit varchar(255) not null,
	presentation varchar(255) not null,
	duration int, /* tiempo de preparacion en minutos */
	use_ingredient boolean not null default 1,
	is_active boolean not null default 1,
	user_id int not null,
	category_id int,
	foreign key (user_id) references user(id),
	foreign key (category_id) references category(id)
);

create table ingredient(
	id int not null auto_increment primary key,
	code varchar(50) not null,
	name varchar(50) not null,
	price_in float not null,
	price_out float,
	unit varchar(255) not null,
	is_active boolean not null default 1,
	user_id int not null,
	foreign key (user_id) references user(id)
);

create table product_ingredient(
	id int not null auto_increment primary key,
	product_id int not null,
	ingredient_id int not null,
	q float,
	is_required boolean not null,
	foreign key (product_id) references product(id),
	foreign key (ingredient_id) references ingredient(id)
);


create table operation_type(
	id int not null auto_increment primary key,
	name varchar(50) not null
);

insert into operation_type (name) value ("entrada");
insert into operation_type (name) value ("salida");

create table sell(
	id int not null auto_increment primary key,
	item_id int, /* mesa */
	q int, /* cantidad de personas en la mesa */
	is_applied boolean not null default 0,
	mesero_id int,
	cajero_id int,
	foreign key (mesero_id) references user(id),	
	foreign key (cajero_id) references user(id),	
	created_at datetime not null
);

create table operation(
	id int not null auto_increment primary key,
	product_id int not null,
	q float not null,
	operation_type_id int not null,
	sell_id int,
	is_oficial boolean not null default 0,
	created_at datetime not null,
	foreign key (product_id) references product(id),
	foreign key (operation_type_id) references operation_type(id),
	foreign key (sell_id) references sell(id)
);
/* para gestionar el inventario de ingredientes */
create table sell2(
	id int not null auto_increment primary key,
	user_id int ,
	operation_type_id int default 2,
	foreign key (operation_type_id) references operation_type(id),
	foreign key (user_id) references user(id),
	created_at datetime not null
);

create table operation2(
	id int not null auto_increment primary key,
	ingredient_id int not null,
	q float not null,
	operation_type_id int not null,
	sell_id int,
	is_oficial boolean not null default 0,
	created_at datetime not null,
	foreign key (ingredient_id) references ingredient(id),
	foreign key (operation_type_id) references operation_type(id),
	foreign key (sell_id) references sell2(id)
);


/* no se usa actualmente */
create table spent(
	id int not null auto_increment primary key,
	q int not null,
	concept varchar(255) not null,
	unit varchar(255) not null,
	price float not null,
	category_id int not null,
	created_at datetime not null,
	foreign key (category_id) references category(id)
);
