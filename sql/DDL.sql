CREATE TABLE Presidente(
    cf varchar(16) not null,
    nome varchar(25) not null,
    cognome varchar(25) not null,

    primary key(cf)
)ENGINE=InnoDB;

CREATE TABLE Societa(
    id integer unsigned auto_increment,
    nome varchar(30) not null,
    comune varchar(30) not null,
    provincia char(2) not null,
    indirizzo varchar(30) not null,

    primary key(id)
)ENGINE=InnoDB;

CREATE TABLE Allenatori(
    cf varchar(16) not null,
    nome varchar(25) not null,
    cognome varchar(25) not null,
    squadra varchar(30) not null,

    primary key(cf),
    foreign key(squadra) references Squadra(id),
)ENGINE=InnoDB;

CREATE TABLE Dirigenti(
    cf varchar(16) not null,
    nome varchar(25) not null,
    cognome varchar(25) not null,

    primary key(cf),
)ENGINE=InnoDB;

CREATE TABLE Squadra(
    id integer unsigned auto_increment,
    campionato varchar(40) not null,
    nome varchar(25) not null,

    primary key(id),
    foreign key(campionato) references Campionato(id),
)ENGINE=InnoDB;


CREATE TABLE Campionato(
    id integer unsigned auto_increment,
    nome varchar(40) not null,
    genere char(1) not null,
    anno integer not null,

    primary key(id),
)ENGINE=InnoDB;

CREATE TABLE Atleti(
    matricola integer unsigned auto_increment,
    nome varchar(25) not null,
    cognome varchar(25) not null,
    dataNascita date not null,

    primary key(matricola),
)ENGINE=InnoDB;