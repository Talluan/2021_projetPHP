DROP database IF EXISTS cours;
CREATE database cours;
USE cours;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `role`;
create table `role` (
    `roleid` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `label` varchar(20),
    `auth_level` int(5) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
create table user (
    `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(40),
    `passwd` varchar(256),
    `roleid` int(5) DEFAULT 1,
    FOREIGN KEY (roleid) REFERENCES role(roleid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text,
  `url` text,
  `tarif` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  item_id int(11) DEFAULT NULL,
  message text DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (item_id) REFERENCES item(id),
  FOREIGN KEY (user_id) REFERENCES user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `liste`;
CREATE TABLE `liste` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `public` boolean DEFAULT FALSE,
  `tokenEdition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tokenPartage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tokenSurprise` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cookieUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`no`),
  FOREIGN KEY (`user_id`) REFERENCES user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`(
  `message_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `pseudo_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  FOREIGN KEY (`pseudo_id`) REFERENCES user(id),
  FOREIGN KEY (`liste_id`) REFERENCES liste(no)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- INSERTION

INSERT INTO `role` (`label`, `auth_level`) VALUES ('visiteur', 1);
INSERT INTO `role` (`label`, `auth_level`) VALUES ('utilisateur', 11);
INSERT INTO `role` (`label`, `auth_level`) VALUES ('admin', 101);


INSERT INTO `user` (`pseudo`, `passwd`, `roleid`) VALUES ('ADMIN', '$2y$10$0U1VIQu93m0ywthonDzsr.DygthikzwSReh0Tu.BsMZ9UqvEgmcI2', 3);
INSERT INTO `user` (`pseudo`, `passwd`, `roleid`) VALUES ('CR??ATEUR', '$2y$10$eMJ9PSW/CEkcJwFz417pgOGdxgqjgRIsP.XX5D3QtqsYMPAmPKvym', 2);
INSERT INTO `user` (`pseudo`, `passwd`, `roleid`) VALUES ('PARTICIPANT1', '$2y$10$/6D.xnMiEt4lZ.RlfL8Fau9L6cZ3/.6AMOfbj/LDxxg8L7Z714e2K', 2);
INSERT INTO `user` (`pseudo`, `passwd`, `roleid`) VALUES ('PARTICIPANT2', '$2y$10$lOcme4kE/RJVfJyNamfyKOslpLb8vH1CDPunyQxplp63uPFo1XfEq', 2);


INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`) VALUES
(1,	2,	'Champagne',	'Bouteille de champagne + flutes + jeux ?? gratter',	'champagne.jpg',	'',	20.00),
(2,	2,	'Musique',	'Partitions de piano ?? 4 mains',	'musique.jpg',	'',	25.00),
(3,	2,	'Exposition',	'Visite guid??e de l???exposition ???REGARDER??? ?? la galerie Poirel',	'poirelregarder.jpg',	'',	14.00),
(4,	3,	'Go??ter',	'Go??ter au FIFNL',	'gouter.jpg',	'',	20.00),
(5,	3,	'Projection',	'Projection courts-m??trages au FIFNL',	'film.jpg',	'',	10.00),
(6,	2,	'Bouquet',	'Bouquet de roses et Mots de Marion Renaud',	'rose.jpg',	'',	16.00),
(7,	2,	'Diner Stanislas',	'Diner ?? La Table du Bon Roi Stanislas (Ap??ritif /Entr??e / Plat / Vin / Dessert / Caf?? / Digestif)',	'bonroi.jpg',	'',	60.00),
(8,	3,	'Origami',	'Baguettes magiques en Origami en buvant un th??',	'origami.jpg',	'',	12.00),
(9,	3,	'Livres',	'Livre bricolage avec petits-enfants + Roman',	'bricolage.jpg',	'',	24.00),
(10,	2,	'Diner  Grand Rue ',	'Diner au Grand???Ru(e) (Ap??ritif / Entr??e / Plat / Vin / Dessert / Caf??)',	'grandrue.jpg',	'',	59.00),
(11,	0,	'Visite guid??e',	'Visite guid??e personnalis??e de Saint-Epvre jusqu????? Stanislas',	'place.jpg',	'',	11.00),
(12,	2,	'Bijoux',	'Bijoux de manteau + Sous-verre pochette de disque + Lait apr??s-soleil',	'bijoux.jpg',	'',	29.00),
(19,	0,	'Jeu contacts',	'Jeu pour ??change de contacts',	'contact.png',	'',	5.00),
(22,	0,	'Concert',	'Un concert ?? Nancy',	'concert.jpg',	'',	17.00),
(23,	1,	'Appart Hotel',	'Appart???h??tel Coeur de Ville, en plein centre-ville',	'apparthotel.jpg',	'',	56.00),
(24,	2,	'H??tel d\'Haussonville',	'H??tel d\'Haussonville, au coeur de la Vieille ville ?? deux pas de la place Stanislas',	'hotel_haussonville_logo.jpg',	'',	169.00),
(25,	1,	'Boite de nuit',	'Discoth??que, Bo??te tendance avec des soir??es ?? th??me & DJ invit??s',	'boitedenuit.jpg',	'',	32.00),
(26,	1,	'Plan??tes Laser',	'Laser game : Gilet ??lectronique et pistolet laser comme mat??riel, vous voil?? ??quip??.',	'laser.jpg',	'',	15.00),
(27,	1,	'Fort Aventure',	'D??couvrez Fort Aventure ?? Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut ?? l\'??lastique invers??, Toboggan g??ant... et bien plus encore.',	'fort.jpg',	'',	25.00);


INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`,`public`, `tokenEdition`, `tokenPartage`, `tokenSurprise`) VALUES
(1,	2,	'Pour f??ter le bac !',	'Pour un week-end ?? Nancy qui nous fera oublier les ??preuves. ',	'2018-06-27',TRUE, 10001, 10004, 10007),
(2,	2,	'Liste de mariage d\'Alice et Bob',	'Nous souhaitons passer un week-end royal ?? Nancy pour notre lune de miel :)',	'2018-06-30',TRUE, 10002, 10005, 10008),
(3,	2,	'C\'est l\'anniversaire de Charlie',	'Pour lui pr??parer une f??te dont il se souviendra :)',	'2017-12-12',FALSE,	10003, 10006, 10009);

INSERT INTO `reservation` (`id`,`user_id`,`item_id`,`message`) VALUES
(1,4,1,'C\'est pour moi'),
(2,4,2,'Bon cadeaux'),
(3,3,3,'tu me le remboursera plus tard');

