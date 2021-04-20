DROP DATABASE IF EXISTS groupimac;

DROP TABLE IF EXISTS typeProjet;
DROP TABLE IF EXISTS PointFort;
DROP TABLE IF EXISTS Utilisateur;
DROP TABLE IF EXISTS Projet;
DROP TABLE IF EXISTS Commentaire;
DROP TABLE IF EXISTS EstDeType;
DROP TABLE IF EXISTS Participe;
DROP TABLE IF EXISTS Revendique;

CREATE DATABASE groupimac;

/* 
    NOTE : Si vous galérez à importer la table : 
        - créez une table "groupimac"
        - allez dans l'onglet SQL 
        - copiez-collez tout ce qu'il y a en dessous 
*/

CREATE TABLE Utilisateur(
    idUser INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    promo VARCHAR(6),                 /* IMAC1/2/3 */
    discord VARCHAR(100),
    presentation TEXT,
    
    PRIMARY KEY (idUser)
);

CREATE TABLE Projet(
    idProjet INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(30) NOT NULL,
    presentation TEXT,
    datePubli DATE,
    deadline DATE,
    cadre VARCHAR(50),             /* scolaire, pro, perso */
    nbreActuel SMALLINT,
    nbreMax SMALLINT NOT NULL,
    RefAuteurProjet INT,

    PRIMARY KEY (idProjet),
    
    CONSTRAINT fk_auteurProjet
        FOREIGN KEY(RefAuteurProjet)
        REFERENCES Utilisateur(idUser)
);

CREATE TABLE Participe(
    RefUser INT NOT NULL,
    RefProjet INT NOT NULL,

    PRIMARY KEY (RefUser, RefProjet),

    CONSTRAINT fk_user_projet
        FOREIGN KEY(RefUser)
        REFERENCES Utilisateur(idUser),

    CONSTRAINT fk_projet_user
        FOREIGN KEY(RefProjet)
        REFERENCES Projet(idProjet)
);

CREATE TABLE Commentaire(
    idComment INT NOT NULL AUTO_INCREMENT,
    message TEXT NOT NULL,
    dateComment DATETIME,
    RefUser INT,
    RefProjet INT,
    PRIMARY KEY (idComment),

    CONSTRAINT fk_auteurCommentaire
        FOREIGN KEY(RefUser)
        REFERENCES Utilisateur(idUser),

    CONSTRAINT fk_commentaire_du_projet
        FOREIGN KEY(RefProjet)
        REFERENCES Projet(idProjet)
);

CREATE TABLE PointFort(
    idPointFort INT NOT NULL AUTO_INCREMENT,
    presentation TEXT,

    PRIMARY KEY (idPointFort)
);

CREATE TABLE Revendique(
    RefUser INT NOT NULL, 
    RefPointFort INT NOT NULL,
    PRIMARY KEY(RefUser, RefPointFort),

    CONSTRAINT fk_user_pointFort
        FOREIGN KEY(RefUser)
        REFERENCES Utilisateur(idUser),

    CONSTRAINT fk_pointFort_user
        FOREIGN KEY(RefPointFort)
        REFERENCES PointFort(idPointFort)
);

CREATE TABLE typeProjet(
    idType INT NOT NULL AUTO_INCREMENT,
    presentation TEXT,

    PRIMARY KEY(idType)
);

CREATE TABLE estDeType(
    RefProjet INT NOT NULL,
    RefType INT NOT NULL,

    PRIMARY KEY (RefProjet, RefType),

    CONSTRAINT fk_projet_type
        FOREIGN KEY(RefProjet)
        REFERENCES Projet(idProjet),

    CONSTRAINT fk_type_projet
        FOREIGN KEY(RefType)
        REFERENCES typeProjet(idType)
);