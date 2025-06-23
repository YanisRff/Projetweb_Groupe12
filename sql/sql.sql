CREATE TABLE Boat (
    MMSI   INT PRIMARY KEY,
    Name   VARCHAR(100) NOT NULL,
    Length FLOAT NOT NULL,
    Width  FLOAT NOT NULL,
    Draft  FLOAT NOT NULL
);

CREATE TABLE Position (
    id_pos     SERIAL PRIMARY KEY,
    horodatage TIMESTAMP NOT NULL,
    Sog        FLOAT NOT NULL,
    Cog        FLOAT NOT NULL,
    Heading    INT NOT NULL,
    Status     INT NOT NULL,
    Prediction BOOLEAN NOT NULL,
    MMSI       INT NOT NULL,
    CONSTRAINT Position_Boat_FK FOREIGN KEY (MMSI) REFERENCES Boat(MMSI)
);

