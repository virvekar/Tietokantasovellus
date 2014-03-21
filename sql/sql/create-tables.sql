CREATE TABLE puuhaluokka (
    puuhaluokanid serial,
    puuhaluokanNimi varchar(20) NOT NULL,
    puuhaluokanKuvaus varchar(1000),
    PRIMARY KEY (puuhaluokanid)
);
CREATE TABLE henkilo (
    puuhaajaid serial,
    nimimerkki varchar(20),
    sahkoposti varchar(50),
    salasana varchar(20),
    liittymispaiva date,
    asema varchar(20),
    PRIMARY KEY (puuhaajaid)
);

CREATE TABLE puuhat (
    puuhanid serial,
    puuhaluokanid serial,
    puuhanNimi varchar(20),
    puuhanKuvaus varchar(1000),
    puuhanKesto decimal(5,3),
    henkilomaara integer,
    paikka varchar(100),
    ajankohta timestamp,
    puuhanLisaysPaiva date,
    puuhaajaID serial,
    PRIMARY KEY (puuhanid),
    FOREIGN KEY (puuhaluokanid) references puuhaluokka(puuhaluokanid),
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
);

CREATE TABLE taidot (
    taidonid serial,
    taidonNimi varchar(20),
    taidonKuvaus varchar(1000),
    taidonLisaysPaiva date,
    puuhaajaid serial,
    PRIMARY KEY (taidonid),
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
);

CREATE TABLE suosikit (
    puuhanid serial,
    puuhaajaid serial,
    suositusid serial,
    PRIMARY KEY (suositusid),
    FOREIGN KEY (puuhanid) references puuhat(puuhanid),
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
);

CREATE TABLE suositukset (
    puuhanid serial,
    puuhaajaid serial,
    suositusTeksti varchar(1000),
    PRIMARY KEY (puuhanid, puuhaajaid),
    FOREIGN KEY (puuhanid) references puuhat(puuhanid),
    FOREIGN KEY (puuhaajaid) references henkilo(Puuhaajaid)
);

CREATE TABLE omatTaidot (
    taidonid serial,
    puuhaajaid serial,
    PRIMARY KEY (taidonid, puuhaajaid),
    FOREIGN KEY (taidonid) references taidot(taidonid),
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
);

CREATE TABLE puuhataidot(
    taidonid serial,
    puuhanid serial,
    PRIMARY KEY (taidonid, puuhanid),
    FOREIGN KEY (taidonid) references taidot(taidonid),
    FOREIGN KEY (puuhanid) references puuhat(puuhanid)
);