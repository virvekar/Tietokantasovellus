CREATE TABLE Puuhaluokka (
    PuuhaluokanID       serial,
    PuuhaluokanNimi     varchar(20) NOT NULL,
    PuuhaluokanKuvaus   varchar(1000),
    PRIMARY KEY (PuuhaluokanID)
);

CREATE TABLE Puuhat (
    PuuhanID            serial,
    PuuhaluokanID       serial,
    PuuhanNimi          varchar(20),
    PuuhanKuvaus        varchar(1000),
    PuuhanKesto         decimal(5,3),
    Henkilomaara        integer,
    Paikka              varchar(100),
    Ajankohta           timestamp,
    PuuhanLisaysPaiva   date,
    PuuhaajaID          serial,
    PRIMARY KEY (PuuhanID),
    FOREIGN KEY (PuuhaluokanID) references Puuhaluokka(PuuhaluokanID),
    FOREIGN KEY (PuuhaajaID) references Henkilo(PuuhaajaID)
);
CREATE TABLE HENKILO (

);
