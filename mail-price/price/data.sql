CREATE DATABASE itruck;

 CREATE TABLE products (
    id INT(11) NOT NULL PRIMARY KEY,
    category1 VARCHAR(255) NOT NULL,
    category2 VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    height INT(11)  NOT NULL,
    width INT(11)  NOT NULL,
    diam VARCHAR(50)  NOT NULL,
    ind_n VARCHAR(50)  NOT NULL,
    ind_s VARCHAR(50)  NOT NULL,
   price_r INT(20)  NOT NULL,
   price_y INT(20)  NOT NULL,
  price_p INT(20)  NOT NULL);

SET NAMES latin1;

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (1,
 'Грузовые шины',
'Универсальная',
 'Шина универсальная БЕЛШИНА Бел-159 235/75 R17,5 130/128M TL',
'БЕЛШИНА',
'Бел-159',  
235,
75,
'17,5',
'130/128', 
'M',
12,
4650);


INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (2,
 'Грузовые шины',
'Ведущая',
 'Шина ведущая MICHELIN X Multi D 265/70 R19,5 140/138M',
'MICHELIN',
'X Multi D',  
265,
70,
'19,5',
'140/138', 
'M',
12,
9294);

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (3,
 'Сельскохозяйственные шины',
'Универсальная',
 'Шина сельскохозяйственная РОСАВА Ф-325 210/80 R16 96A8',
'РОСАВА',
'Ф-325',  
210,
80,
'16',
'96', 
'A8',
16,
1830);

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (4,
 'Сельскохозяйственные шины',
'Универсальная',
 'Шина сельскохозяйственная РОСАВА TR-103 600/65 R28 154A8/B',
'РОСАВА',
'TR-103',  
600,
65,
'28',
'154', 
'A8/B',
6,
18060);

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (5,
 'Грузовые шины',
'Рулевая',
 'Шина рулевая OTANI OH-101 Super 315/80 R22,5 156/150L',
'OTANI',
'OH-101 Super',  
315,
80,
'22,5',
'156/150', 
'L',
13,
8298);

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (6,
 'Грузовые шины',
'Прицепная',
 'Шина прицепная OTANI OH-102 385/65 R22,5 160K',
'OTANI',
'OH-102',  
385,
65,
'22,5',
'160', 
'K',
13,
8748);

INSERT INTO products
( id, category1, category2, name, brand, model, height, width, diam, ind_n, ind_s, nal, price) 
VALUES (7,
 'Грузовые шины',
'Универсальная',
 'Шина универсальная OTANI OH-115 235/75 R17,5 132/130M',
'OTANI',
'OH-115',  
235,
75,
'17,5',
'132/130', 
'M',
3,
4170);


