/* Tworzenie bazy danych */
CREATE DATABASE IF NOT EXISTS czujniki;

/* Tworzenie tabel */
CREATE TABLE czujniki.rejestr_czujnikow (
  id_czujnika int NOT NULL AUTO_INCREMENT,
  nazwa varchar(32) COLLATE utf8_polish_ci NOT NULL,
  opis varchar(128) COLLATE utf8_polish_ci NOT NULL,
  szerokosc varchar(32) COLLATE utf8_polish_ci NOT NULL,
  dlugosc varchar(32) COLLATE utf8_polish_ci NOT NULL,
  wysokosc_npm float NOT NULL,
  PRIMARY KEY (id_czujnika)
);

CREATE TABLE czujniki.dane_dzienne (
  id_czujnika int NOT NULL,
  data datetime NOT NULL,
  pm2_5 float NOT NULL,
  pm10 float NOT NULL,
  wilgotnosc float NOT NULL,
  temperatura float NOT NULL,
  FOREIGN KEY (id_czujnika) REFERENCES czujniki.rejestr_czujnikow(id_czujnika)
);




/* -------------------------------------------------- */


/* Wstawianie przykładowych danych do tabeli rejestr_czujnikow */
INSERT INTO czujniki.rejestr_czujnikow (id_czujnika, nazwa, opis, szerokosc, dlugosc, wysokosc_npm) 
VALUES (NULL, 'Nazwa czujnika', 'Opis czujnika', 'szerokosc', 'dlugosc', '200');

/* Usuwanie z tabeli rejestr_czujnikow po id */
DELETE FROM czujniki.rejestr_czujnikow WHERE id_czujnika=1;


/* -------------------------------------------------- */


/* Wstawianie przykładowych danych do tabeli dane_dzienne */
INSERT INTO czujniki.dane_dzienne (id_czujnika, data, pm2_5, pm10, wilgotnosc, temperatura) 
VALUES ('1', '2021-05-19 17:31:51', '10.5', '20.5', '30.5', '25.0');

/* Usuwanie z tabeli dane_dzienne po id */
DELETE FROM czujniki.dane_dzienne WHERE id_czujnika=1;


/* -------------------------------------------------- */


/* Pobieranie pola nazwa z tabeli rejestr_czujnikow po jego id */
SELECT czujniki.rejestr_czujnikow.nazwa FROM czujniki.rejestr_czujnikow WHERE czujniki.rejestr_czujnikow.id_czujnika=1;

/* Pobieranie pola wilgotnosc z tabeli dane_dzienne po jego id */
SELECT czujniki.dane_dzienne.wilgotnosc FROM czujniki.dane_dzienne WHERE czujniki.dane_dzienne.id_czujnika=1;
