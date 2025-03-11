
--Presidenti:
INSERT INTO Presidenti(cf, nome, cognome)
VALUES("DLRRLA49E24H501B", 'Aurelio', 'De Laurentiis');

INSERT INTO Presidenti(cf, nome, cognome)
VALUES("GNLNDR75T06L219C", 'Andrea', 'Agnelli');

--Societa':
INSERT INTO Societa(nome, comune, provincia, cf_presidente)
VALUES('SSC Napoli', 'Napoli', 'NA', 'DLRRLA49E24H501B');

INSERT INTO Societa(nome, comune, provincia, cf_presidente)
VALUES('Juventus FC', 'Torino', 'TO', 'GNLNDR75T06L219C');

--Dirigenti:
INSERT INTO Dirigenti(cf, nome, cognome, id_societa)    
VALUES('GNTMNL06M01G633L', 'Emanuele', 'Gentile', '1');

INSERT INTO Dirigenti(cf, nome, cognome, id_societa)
VALUES('RSSYRU06B12E512W', 'Yuri', 'Rossi', '2');

--Campionati:
INSERT INTO Campionati(nome, genere, anno)
VALUES('Serie A Enilive', 'M', '2024-2025');

INSERT INTO Campionati(nome, genere, anno)
VALUES('Serie BKT', 'M', '2024-2025');

--Squadre:
INSERT INTO Squadre(nome, id_campionato, id_societa)
VALUES('Juventus FC ', '2', '2');

INSERT INTO Squadre(nome, id_campionato, id_societa)
VALUES('SSC Napoli ', '1', '1');

--Atleti:
INSERT INTO Atleti(nome, Cognome, dataNascita, id_squadra)
VALUES('Federico', 'Bernardeschi', '1994-02-16', '2');

INSERT INTO Atleti(nome, Cognome, dataNascita, id_squadra)
VALUES('Lorenzo', 'Insigne', '1991-06-04', '1');

INSERT INTO Atleti(nome, Cognome, dataNascita, id_squadra)
VALUES('Kvicha', 'Kvaratskhelia', '2001-02-12', '1');

INSERT INTO Atleti(nome, Cognome, dataNascita, id_squadra)
VALUES('Carlo', 'Pinsoglio', '1990-03-16', '2');

--Allenatori:
INSERT INTO Allenatori(cf, nome, Cognome, id_squadra)
VALUES('AAAAAAAAAAAAAAA2', 'Antonio', 'Conte', '2');

INSERT INTO Allenatori(cf, nome, Cognome, id_squadra)
VALUES('AAAAAAAAAAAAAAA1', 'Maurizio', 'Sarri', '1');

--Admin
INSERT INTO Admin(username, password)
VALUES('admin1@00', MD5("qwerty1"));

INSERT INTO Admin(username, password)
VALUES('yuri.rossi@galilei', MD5("carlitostevez2015"));