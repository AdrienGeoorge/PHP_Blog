-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 09 sep. 2021 à 19:25
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données : `php_adverts`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
                              `id` int(11) NOT NULL,
                              `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(6, 'Technology'),
(7, 'News');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
                            `id` int(11) NOT NULL,
                            `comment` text NOT NULL,
                            `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `post` int(11) NOT NULL,
                            `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `date`, `post`, `user`) VALUES
(1, 'Citius victoriis cuiusquam potuisse nec potentissimorumque libenter lustratae omnis nec vero lustratae proeliorum posse potentissimorumque.', '2021-09-09 19:15:24', 2, 1),
(2, 'Calamitatum quam istum reque qui amicitiae istum invenias Quamquam honoribus ubi honoribus quam verae Quid versantur suo amici quam qui plerisque recte Haec est descendant enim enim videntur quas Haec.', '2021-09-09 19:15:26', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
                          `id` int(11) NOT NULL,
                          `post_id` int(11) NOT NULL,
                          `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `post_id`, `image`) VALUES
(1, 1, 'public/posts/613a3c5adca99613a3c5adca9d.jpeg'),
(2, 2, 'public/posts/613a3db685c34613a3db685c3a.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
                         `id` int(11) NOT NULL,
                         `title` varchar(255) NOT NULL,
                         `content` longtext NOT NULL,
                         `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                         `user` int(11) NOT NULL,
                         `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `date`, `user`, `category`) VALUES
(1, 'Iamque acie serpens cognitis', 'Quam quidem partem accusationis admiratus sum et moleste\r\ntuli potissimum esse Atratino datam. Neque enim decebat\r\nneque aetas illa postulabat neque, id quod animadvertere\r\npoteratis, pudor patiebatur optimi adulescentis in tali illum\r\noratione versari. Vellem aliquis ex vobis robustioribus hunc\r\nmale dicendi locum suscepisset; aliquanto liberius et fortius\r\net magis more nostro refutaremus istam male dicendi licentiam.\r\nTecum, Atratine, agam lenius, quod et pudor tuus moderatur\r\norationi meae et meum erga te parentemque tuum beneficium\r\ntueri debeo.\r\n<br><br>\r\nProinde die funestis interrogationibus praestituto imaginarius\r\niudex equitum resedit magister adhibitis aliis iam quae essent\r\nagenda praedoctis, et adsistebant hinc inde notarii, quid\r\nquaesitum esset, quidve responsum, cursim ad Caesarem\r\nperferentes, cuius imperio truci, stimulis reginae exsertantis\r\naurem subinde per aulaeum, nec diluere obiecta permissi nec\r\ndefensi periere conplures.\r\n<br><br>\r\nQuam ob rem vita quidem talis fuit vel fortuna vel gloria, ut nihil\r\nposset accedere, moriendi autem sensum celeritas abstulit; quo\r\nde genere mortis difficile dictu est; quid homines suspicentur,\r\nvidetis; hoc vere tamen licet dicere, P. Scipioni ex multis diebus,\r\nquos in vita celeberrimos laetissimosque viderit, illum diem\r\nclarissimum fuisse, cum senatu dimisso domum reductus ad\r\nvesperum est a patribus conscriptis, populo Romano, sociis\r\net Latinis, pridie quam excessit e vita, ut ex tam alto dignitatis\r\ngradu ad superos videatur deos potius quam ad inferos\r\npervenisse.', '2021-09-09 16:59:44', 1, 6),
(2, 'Ex ipsa angustum res societate', 'Sed tamen haec cum ita tutius observentur, quidam vigore\r\nartuum inminuto rogati ad nuptias ubi aurum dextris manibus\r\ncavatis offertur, inpigre vel usque Spoletium pergunt. haec\r\nnobilium sunt instituta.\r\n<br><br>\r\nMontius nos tumore inusitato quodam et novo ut rebellis et\r\nmaiestati recalcitrantes Augustae per haec quae strepit\r\nincusat iratus nimirum quod contumacem praefectum, quid\r\nrerum ordo postulat ignorare dissimulantem formidine tenus\r\niusserim custodiri.', '2021-09-08 22:00:00', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `login` varchar(50) NOT NULL,
                         `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'Adrien', '$2y$10$VTKZITitQttkclSUzbkm.ufKnvlOFmNEPw0mJ.G6ee5rps5gGYQK6');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_posts` (`post`),
  ADD KEY `fk_comment_users` (`user`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_image` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_user` (`user`),
  ADD KEY `fk_post_categories` (`category`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
    ADD CONSTRAINT `fk_comment_posts` FOREIGN KEY (`post`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_comment_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
    ADD CONSTRAINT `fk_post_image` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
    ADD CONSTRAINT `fk_post_categories` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
