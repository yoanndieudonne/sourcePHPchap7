CREATE DATABASE IF NOT EXISTS cours_php CHARACTER SET utf8;
USE cours_php;

CREATE TABLE livres (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    titre  VARCHAR(100) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    annee  INT
);

INSERT INTO livres (titre, auteur, annee) VALUES
('1984', 'George Orwell', 1949),
('Le Petit Prince', 'Antoine de Saint-Exupery', 1943),
('La Peste', 'Albert Camus', 1947);
