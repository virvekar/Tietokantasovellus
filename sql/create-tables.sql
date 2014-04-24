CREATE TABLE puuhaluokka (
    puuhaluokanid serial,
    puuhaluokanNimi varchar(50) NOT NULL,
    puuhaluokanKuvaus varchar(1000),
    PRIMARY KEY (puuhaluokanid)
);
CREATE TABLE henkilo (
    puuhaajaid serial,
    nimimerkki varchar(50),
    sahkoposti varchar(50),
    salasana varchar(20),
    liittymispaiva date,
    asema varchar(20),
    PRIMARY KEY (puuhaajaid)
);

CREATE TABLE puuhat (
    puuhanid serial,
    puuhaluokanid serial,
    puuhanNimi varchar(50),
    puuhanKuvaus varchar(1000),
    puuhanKesto decimal(10,3),
    henkilomaara integer,
    paikka varchar(100),
    ajankohta timestamp,
    puuhanLisaysPaiva date,
    puuhaajaID serial,
    PRIMARY KEY (puuhanid),
    FOREIGN KEY (puuhaluokanid) references puuhaluokka(puuhaluokanid) ON DELETE CASCADE,
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
    ON DELETE CASCADE
);

CREATE TABLE taidot (
    taidonid serial,
    taidonNimi varchar(50),
    taidonKuvaus varchar(1000),
    taidonLisaysPaiva date,
    puuhaajaid serial,
    PRIMARY KEY (taidonid),
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
    ON DELETE CASCADE
);

CREATE TABLE suosikit (
    puuhanid serial,
    puuhaajaid serial,
    PRIMARY KEY (puuhanid, puuhaajaid),
    FOREIGN KEY (puuhanid) references puuhat(puuhanid) ON DELETE CASCADE,
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
    ON DELETE CASCADE
);

CREATE TABLE suositukset (
    puuhanid serial,
    puuhaajaid serial,
    suositusid serial,
    suositusTeksti varchar(1000),
    PRIMARY KEY (suositusid),
    FOREIGN KEY (puuhanid) references puuhat(puuhanid) ON DELETE CASCADE,
    FOREIGN KEY (puuhaajaid) references henkilo(Puuhaajaid)
    ON DELETE CASCADE
);

CREATE TABLE omatTaidot (
    taidonid serial,
    puuhaajaid serial,
    PRIMARY KEY (taidonid, puuhaajaid),
    FOREIGN KEY (taidonid) references taidot(taidonid) ON DELETE CASCADE,
    FOREIGN KEY (puuhaajaid) references henkilo(puuhaajaid)
    ON DELETE CASCADE
);

CREATE TABLE puuhataidot(
    taidonid serial,
    puuhanid serial,
    PRIMARY KEY (taidonid, puuhanid),
    FOREIGN KEY (taidonid) references taidot(taidonid) ON DELETE CASCADE,
    FOREIGN KEY (puuhanid) references puuhat(puuhanid)
    ON DELETE CASCADE
);