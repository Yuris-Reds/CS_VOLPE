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