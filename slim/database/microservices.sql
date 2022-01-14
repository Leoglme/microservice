-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 04 jan. 2022 à 00:54
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `microservices`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(4, NULL, '', '2021-12-12 02:04:22', '2021-12-12 02:04:22'),
(5, 'malouk', 'dog', '2021-12-12 02:06:00', '2021-12-12 02:06:00'),
(6, 'oliver', 'dog', '2021-12-12 02:06:47', '2021-12-12 02:06:47');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receiver` int(11) DEFAULT 0,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `created_at`, `updated_at`, `receiver`, `content`) VALUES
(2, 2, '2021-12-14 12:58:11', '2021-12-16 13:09:45', 1, 'coucouede'),
(3, 4, '2021-12-14 12:58:31', '2021-12-14 12:58:31', 3, 'ceci est un message new'),
(5, 3, '2021-12-14 14:07:51', '2021-12-14 14:07:51', 4, 'coucou');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `firstname`, `lastname`, `email`, `password`) VALUES
(3, '2021-12-13 11:01:48', '2021-12-16 13:05:58', 'lea', 'bidule', 'toto@gmail.com', 'machin'),
(4, '2021-12-14 11:56:59', '2021-12-14 11:56:59', 'toto', 'bidule', 'toto@gmail.com', 'bidudeddede'),
(5, '2021-12-14 14:33:06', '2021-12-14 14:33:06', 'leo', 'glme', 'toto@gmail.com', 'b1ea4f650d14e2479ac3388d888f33000dc99611'),
(6, '2021-12-14 14:33:42', '2021-12-14 14:33:42', 'leo', 'glme', 'toto@gmail.com', '28b159dfed02e29bb8e817e470d929e78c6814c3'),
(7, '2021-12-14 14:33:49', '2021-12-14 14:33:49', 'leo', 'glme', 'toto@gmail.com', 'b1ea4f650d14e2479ac3388d888f33000dc99611'),
(8, '2021-12-16 09:05:32', '2021-12-16 09:05:32', 'léo', 'glme', 'toto@gmail.com', 'b1ea4f650d14e2479ac3388d888f33000dc99611'),
(9, '2021-12-16 11:36:23', '2021-12-16 11:36:23', 'léo', 'glme', 'toto@gmail.com', '5464dbe76b4d930ed017b8715917999f6b750d796cdac336828361185566eec66b6a12ed53030c221725822d1af1ff9de2bd7f6ee49aff79a26663156daf7033'),
(10, '2021-12-16 12:17:43', '2021-12-16 13:06:30', 'lea', 'bidule', 'toto@gmail.com', 'f1cda972ab4292986800537da1926de3598ef8e21daf5f632d1877d043b9008d5415750b9e5f236eac44947bb2a8bd317e936060a6935590c72d5023675a5450');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
