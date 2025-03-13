CREATE TABLE Presidenti(
    cf char(16) not null,
    nome varchar(25) not null,
    cognome varchar(25) not null,

    primary key(cf)
)ENGINE=InnoDB;

CREATE TABLE Societa(
    id integer unsigned auto_increment not null,
    nome varchar(20) not null,
    comune varchar(20) not null,
    provincia char(2) not null,
    cf_presidente char(16) not null,

    primary key(id),
    foreign key(cf_presidente) references Presidenti(cf)
)ENGINE=InnoDB;

CREATE TABLE Allenatori(
    cf char(16) not null,
    nome varchar(20) not null,
    cognome varchar(20) not null,
    id_squadra integer unsigned,

    primary key(cf),
    foreign key(id_squadra) references Squadre(id)
)ENGINE=InnoDB;

--Un dirigente appartiene solo a una societa':
CREATE TABLE Dirigenti(
    cf char(16) not null,
    nome varchar(20) not null,
    cognome varchar(20) not null,
    id_societa integer unsigned,
    
    primary key(cf),
    foreign key(id_societa) references Societa(id)
)ENGINE=InnoDB;

--Una societa' partecipa ad un solo campionato ed e' posseduta da una sola societa':
CREATE TABLE Squadre(
    id integer unsigned auto_increment not null,
    nome varchar(20) not null,
    id_campionato integer unsigned,
    id_societa integer unsigned not null,

    primary key(id),
    foreign key(id_campionato) references Campionati(id),
    foreign key(id_societa) references Societa(id)
)ENGINE=InnoDB;

CREATE TABLE Campionati(
    id integer unsigned auto_increment not null,
    nome varchar(30) not null,
    genere char(1) not null,
    anno char(9) not null,
 
    primary key(id)
)ENGINE=InnoDB;

CREATE TABLE Atleti(
    matricola integer unsigned auto_increment,
    nome varchar(20) not null,
    cognome varchar(20) not null,
    dataNascita date not null,
    id_squadra integer unsigned,

    primary key(matricola),
    foreign key(id_squadra) references Squadre(id)
)ENGINE=InnoDB;

CREATE TABLE Admin(
    id integer unsigned auto_increment,
    username varchar(25) not null,
    password char(32) not null,

    primary key(id)
)ENGINE=InnoDB;
