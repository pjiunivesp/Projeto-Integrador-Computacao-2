drop table responsavel;
drop table animal;

CREATE SCHEMA adestra;
USE adestra;

create table responsavel(
id_resp INT PRIMARY KEY AUTO_INCREMENT,
Nome varchar (80), 
Email varchar (50), 
Endereco varchar (200),
Telefone int (9),
unique (Email)
);

create table animal(
id_animal INT PRIMARY KEY AUTO_INCREMENT,
Nome varchar (100),
Raca varchar (50),
foto MEDIUMBLOB,
Data_nascimento date,
idade int (2),
Sexo ENUM('Macho', 'Femea'),
Castrado ENUM('Sim', 'Não'),
Hist_comportamento varchar (500),
Autoriza_imagem ENUM('Sim', 'Não'),
id_resp_animal int not null,
FOREIGN KEY (id_resp_animal) REFERENCES responsavel (id_resp));



INSERT INTO responsavel
VALUES (01,'João', 'oaomanuel@gmail.com', 'Rua teste tes testes', 1192354698); 
INSERT INTO responsavel
VALUES (02,'Maria', 'maria_aparecida@gmail.com', 'Rua teste tes testes', 1195248953);
INSERT INTO responsavel
VALUES (03,'Teresa', 'teresinha_jesus@gmail.com', 'Rua teste tes testes', 1196248953);
INSERT INTO responsavel
VALUES (04,'Carlos', 'carlossilveiro@gmail.com', 'Rua teste tes testes', 1196248953);   


Alter table responsavel
modify column Telefone varchar(11);

select *from responsavel;

select *from animal;


INSERT INTO animal
VALUES (02, 'Sasha', 'vira lata', '$image', '2020-02-15', 4, 'femea', 'Sim', '
The most difficult part when working with dates is to be sure that the format of the date you are trying to insert, matches the format of the date column in the database.
As long as your data contains only the date portion, your queries will work as expected. However, if a 
time portion is involved, it gets more complicated.', 'Não', 01); 

INSERT INTO animal
VALUES (03, 'teste', 'vira lata', '$image', '2020-02-15', 4, 'macho', 'nao', '
The most difficult part when working with dates is to be sure that the format of the date you are trying to insert, matches the format of the date column in the database.
As long as your data contains only the date portion, your queries will work as expected. However, if a 
time portion is involved, it gets more complicated.', 'Não', 02); 

INSERT INTO animal
VALUES (04, 'Ralf', 'pitbul', '$image', '2021-09-05', 4, 'macho', 'sim', '
The most difficult part when working with dates is to be sure that the format of the date you are trying to insert, matches the format of the date column in the database.
', 'sim', 03);

INSERT INTO animal
VALUES (05, 'Princesa', 'Dalmatas', '$image', '2021-09-05', 4, 'femea', 'sim', '
The most difficult part when working with dates is to be sure that the format of the date you are trying to insert, matches the format of the date column in the database.
', 'sim', 03);

INSERT INTO animal
VALUES (06, 'Hana', 'Pintcher', '$image', '2021-09-05', 4, 'femea', 'sim', '
The most difficult part when working with dates is to be sure that the format of the date you are trying to insert, matches the format of the date column in the database.
', 'sim', 03);

create table agenda(
id_agenda INT PRIMARY KEY AUTO_INCREMENT,
Agenda DATETIME,
id_agen_resp int not null,
id_agen_anil int not null,
FOREIGN KEY (id_agen_anil) REFERENCES animal (id_animal),
FOREIGN KEY (id_agen_resp) REFERENCES responsavel (id_resp));

INSERT INTO agenda
VALUES (01,'2004-10-11 10:00:00', 01, 02);
INSERT INTO agenda
VALUES (02,'2004-10-12 10:00:00', 01, 02);
INSERT INTO agenda
VALUES (03,'2004-10-13 10:00:00', 01, 02);
INSERT INTO agenda
VALUES (04,'2004-10-13 10:00:00', 03, 06);
INSERT INTO agenda
VALUES (05,'2004-10-13 11:00:00', 03, 05);
INSERT INTO agenda
VALUES (06,'2004-10-13 10:00:00', 03, 04);

select * from agenda;
select responsavel.Nome, responsavel.Email, responsavel.Telefone, agenda.Agenda, animal.Nome, animal.idade, animal.Sexo, animal.foto from agenda
inner join responsavel on agenda.id_agen_resp=responsavel.id_resp
inner join animal on agenda.id_agen_anil=animal.id_animal;

