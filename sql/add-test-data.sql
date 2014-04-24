
ALTER SEQUENCE serial RESTART WITH 1001;

INSERT INTO puuhaluokka (puuhaluokanID, puuhaluokanNimi, puuhaluokanKuvaus) VALUES
    (nextval('serial'),'Korttipelit','Sisältää korttipelejä joita voi pelata tavallisilla pelikorteilla'),
    (nextval('serial'),'Ulkoleikit','Sisältää leikkejä joita voi pelata omalla pihalla'),
    (nextval('serial'),'Konsertit','Sisältää tietoja pidettävistä konserteista ympäri Suomea');

INSERT INTO henkilo (puuhaajaid, nimimerkki, sahkoposti,salasana,liittymispaiva,asema) VALUES
    (nextval('serial'),'Pelle Hermanni', 'pe.he@hehe.fi','20108ccf1be2a52a89a','2014-2-3','Puuhaaja'),
    (nextval('serial'),'Julia','ju@hehe.fi','faa9c9402d4b950dd6d','2014-2-1','Yllapitaja');

INSERT INTO puuhat (puuhanid,puuhaluokanid,puuhanNimi,puuhanKuvaus,puuhanKesto,henkilomaara,paikka,puuhanLisaysPaiva,puuhaajaid) VALUES
    (nextval('serial'),1001,'Marjapussi','Jännä peli',0.5,4,'Mikä tahansa','2014-2-4',1004),
    (nextval('serial'),1001,'Sika','tosi Jännä peli',0.5,4,'Mikä tahansa','2014-3-4',1004),
    (nextval('serial'),1001,'Casino','tosi tosi Jännä peli',0.5,4,'Mikä tahansa','2014-3-6',1004);

INSERT INTO taidot (taidonid,taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid) VALUES
    (nextval('serial'),'Laskupää','Osaa laskea peruslaskutoimituksia alle viidessä sekunnissa','2014-3-1',1004),
    (nextval('serial'),'Rautahermot','Ei hermostu suurenkaan paineen alla','2014-3-4',1004),
    (nextval('serial'),'Auton ajaminen','Omistaa B-ajokortin','2014-2-1',1004);
