
CREATE SEQUENCE serial START 1001;

INSERT INTO puuhaluokka (puuhaluokanID, puuhaluokanNimi, puuhaluokanKuvaus) VALUES
    (nextval('serial'),'Korttipelit','Sisältää korttipelejä joita voi pelata tavallisilla pelikorteilla'),
    (nextval('serial'),'Ulkoleikit','Sisältää leikkejä joita voi pelata omalla pihalla'),
    (nextval('serial'),'Konsertit','Sisältää tietoja pidettävistä konserteista ympäri Suomea');

INSERT INTO henkilo (puuhaajaid, nimimerkki, sahkoposti,salasana,liittymispaiva,asema) VALUES
    (nextval('serial'),'Pelle Hermanni', 'pe.he@hehe.fi','kakku','2014-2-3','Puuhaaja'),
    (nextval('serial'),'Liisa Ihmemaassa','li.hi@hehe.fi','janis','2014-3-3','Puuhaaja'),
    (nextval('serial'),'Pekka Poika','pe-pe@hehe.fi','prssssa','2014-3-4','Puuhaaja');

