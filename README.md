![](assets/banner.jpg)

## Introduction

Le but de ce projet est de consigner le nombre de connexions par utilisateur enregistré et connecté sachant qu’il est possible de requêter leurs services à raison de 10 appels par fenêtre de 10 minutes.

## Fonctionnement

Un base de données *phpMyAdmin* gère le stockage des utilisateurs tandis qu'un client *Redis* va s'occuper de gérer le nombre d'appels (ici de connexions) par utilisateur et par tranche de 10 minutes. Enfin, une page *HTML* contenant un formulaire de connexion va faire le lien l'utilisateur et *phpMyAdmin*. Si les données de connexion rentrés par l'utilisateur sont les mêmes que ceux dans la base de données, alors un script *Python* permettant de gérer la session *Redis* va s'éxécuter : si le nombre de connexion pout cet utilisateur est inférieur à 10 dans la fenêtre de 10 minutes alors il peut accéder au reste du site, sinon, il doit attendre la réinitialisation de la fenêtre de temps. 

## Installation 

Installation & Démarage de *Redis* :
```bash
brew install redis
brew services start redis
```

Création de la Table *User* dans la base de données *phpMyAdmin* :
```sql
-- Hôte : localhost:8889
-- Version du Serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`idUser`, `nom`, `prenom`, `email`, `passwd`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997');

ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
```

La connexion à a base de données avec *PHP* se fait dans le fichier **connection.php**.

## Fonctionnalités

* Gestion d'Utilisateurs
* Connexion
* Cache de Connexion
* Vérification pour ne pa dépasser le *RateLimit* de 10 appels.
