-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2017 a las 13:23:28
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nirvana`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `module` varchar(100) DEFAULT '',
  `object_model` varchar(100) DEFAULT '',
  `object_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_entry`
--

DROP TABLE IF EXISTS `calendar_entry`;
CREATE TABLE `calendar_entry` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `all_day` tinyint(4) NOT NULL,
  `participation_mode` tinyint(4) NOT NULL,
  `recur` tinyint(4) DEFAULT NULL,
  `recur_type` tinyint(4) DEFAULT NULL,
  `recur_interval` tinyint(4) DEFAULT NULL,
  `recur_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_entry_participant`
--

DROP TABLE IF EXISTS `calendar_entry_participant`;
CREATE TABLE `calendar_entry_participant` (
  `id` int(11) NOT NULL,
  `calendar_entry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `participation_state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `card_end_date` datetime NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `card_type_id` int(11) NOT NULL,
  `icon` varchar(17) COLLATE utf8_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text COLLATE utf8_general_ci,
  `card_parent_id` int(11) DEFAULT NULL,
  `related_card` int(11) DEFAULT NULL,
  `card_order` int(11) NOT NULL,
  `content_required` tinyint(1) NOT NULL DEFAULT '0',
  `card_mandatory` tinyint(1) NOT NULL DEFAULT '0',
  `card_child_related` int(11) DEFAULT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `card_skip` int(11) NOT NULL,
  `folded` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cards`
--

INSERT INTO `cards` (`id`, `step_id`, `workflow_id`, `card_type_id`, `icon`, `title`, `description`, `card_parent_id`, `related_card`, `card_order`, `content_required`, `card_mandatory`, `card_child_related`, `hide`, `card_skip`, `folded`) VALUES
(21, 1, 1, 2, 'fa-male', 'Participants', 'You can start by inviting participants into the Partner Search Room (PSR)', NULL, NULL, 0, 0, 1, 0, 0, 0, 0),
(22, 2, 1, 1, 'fa-comments-o', 'Preliminar meeting', 'You can schedule a meeting with your innovator or start a poll to fix a date. If you want to skip the step, just dismiss it.', NULL, NULL, 1, 0, 0, 0, 0, 0, 0),
(23, 2, 1, 3, 'fa-tasks', 'Create a poll to schedule a date', 'You can propose several dates to be agreed upon', 22, NULL, 0, 0, 0, 0, 0, 0, 0),
(24, 2, 1, 5, 'fa-tasks', 'Create a meeting', 'You can fix the meeting date on the calendar', 22, NULL, 1, 0, 0, 0, 0, 0, 0),
(37, 2, 1, 7, 'fa-tasks', 'Submit meeting summary', 'Upload a file with the meeting summary', 22, NULL, 2, 0, 0, 0, 0, 0, 0),
(25, 6, 1, 6, 'fa-calendar', 'Advice on your company profile', 'We should have a preliminar meeting to start working on your company profile', NULL, 24, 1, 1, 1, 0, 0, 0, 0),
(38, 6, 1, 7, 'fa-info-circle', 'Meeting summary', 'File with the meeting summary', NULL, 37, 2, 1, 0, 0, 0, 1, 0),
(28, 2, 1, 5, 'fa-info-circle', 'EEN event', 'Would you like to create or recommend an event?', NULL, NULL, 4, 0, 0, 0, 0, 0, 0),
(29, 6, 1, 6, 'fa-star-o', 'I recommend you the following event', NULL, NULL, 28, 4, 1, 1, 0, 0, 0, 0),
(30, 6, 1, 4, 'fa-tasks', 'Choose a date', 'Please choose the date that fits you best.', NULL, 23, 0, 1, 1, 0, 0, 0, 0),
(31, 2, 1, 1, 'fa-file-o', 'Create and submit a Partnership Profile', 'Create  and edit a profile together with your innovator by using EasyPP and then submit the profile to EEN’s Partnership Opportunity Database (POD) for review.', NULL, NULL, 2, 0, 1, 0, 0, 0, 0),
(32, 2, 1, 7, 'fa-file-text', 'Send profile sample', 'I you don\'t attach anything, a sample file will be automatically added. (Note: available in next version)', 31, NULL, 0, 0, 0, 35, 0, 0, 0),
(33, 2, 1, 7, 'fa-file-text', 'Send EasyPP help documentation', 'I you don\'t attach anything, a sample help file will be automatically added. (Note: available in next version)', 31, NULL, 1, 0, 0, 35, 0, 0, 0),
(34, 2, 1, 8, 'fa-file-text', 'Share EasyPP link, edit and submit profile', 'Launch EasyPP and share a link to the company profile. Then, edit the profile collaboratively. Finally, submit it and the card will be automatically marked as completed.', 31, NULL, 2, 0, 1, 0, 0, 0, 0),
(35, 6, 1, 31, 'fa-file-text', 'Create a Partnership Profile', 'Use the link below to open and edit your draft profile. When completed, save it and your innovation adviser will be notified to review it. You will be notified if the profile needs further editing or has been submitted. For more details, see attached supporting documents.', NULL, 34, 2, 0, 1, NULL, 0, 0, 0),
(41, 6, 1, 30, 'fa-info-circle', 'Status of your profile', 'You can see here the status of your profile.', NULL, NULL, 3, 0, 0, 0, 0, 1, 2),
(42, 7, 1, 30, 'fa-info-circle', 'Status of your profile', 'You can see here the status of your profile.', NULL, NULL, 0, 0, 0, 0, 0, 1, 2),
(36, 3, 1, 9, 'fa-share-alt', 'Share Expression of Interest', 'You can share EoIs received through the EEN portal or from any other source by completing the form below. Mark the card as completed when you are done.', NULL, NULL, 6, 0, 1, NULL, 0, 0, 0),
(39, 3, 1, 10, 'fa-share-alt', 'Expressions of Interest already shared', 'Below you will find the potential partners you have added. To share them with your client click on Share. Once your client decides to accept or reject them, their status will be updated. To go to the next step click on Done.', 36, NULL, 7, 0, 1, NULL, 0, 0, 0),
(40, 7, 1, 11, 'fa-file-o', 'Potential partners proposed by your advisor', 'The following companies have been proposed by your advisor. If you decide to start collaboration with them your can create a private Networking Innovation Room (NIR) or add them to an existing NIR with other participants. Once you have finished with this step, mark the task as completed.', NULL, 36, 1, 0, 1, NULL, 0, 0, 0),
(45, 4, 1, 12, 'fa-info-circle', 'Created NIRs', 'Your innovator has created the NIRs listed below. Click on any of them to go to the NIR.', NULL, NULL, 0, 0, 0, NULL, 0, 1, 2),
(46, 8, 1, 12, 'fa-info-circle', 'Created NIRs', 'Your have created the NIRs listed below. Click on any of them to go to the NIR.', NULL, NULL, 0, 0, 0, NULL, 0, 1, 2),
(47, 7, 1, 12, 'fa-info-circle', 'Created NIRs', 'Your have created the NIRs listed below. Click on any of them to go to the NIR.', NULL, NULL, 2, 0, 0, NULL, 0, 1, 2),
(48, 4, 1, 13, 'fa-warning', 'Close Partner Search Room', 'Once you finish your Partner Search Room (PSR) with your innovator, you can close and archive it. You will still be able to access the AR in the projects archive section.', NULL, NULL, 1, 0, 1, NULL, 0, 0, 0),
(49, 8, 1, 14, 'fa-warning', 'Close Partner Search Room', 'Once you finish your Partner Search Room (PSR) with your advisor, you can close and archive it). You will still be able to access the AR in the projects archive section.', NULL, NULL, 1, 0, 1, NULL, 0, 0, 0),
(51, 9, 2, 19, 'fa-users', 'Advisor role in the NIR', 'You can decide the Innovation Advisor role in the NIR. If you choose "Participant", the advisor will see everything you comment or share in the NIR. If you select "Observer", the advisor will only be informed about your progress in the NIR but will have no access to comments and contents.', NULL, NULL, 0, 0, 0, NULL, 0, 0, 0),
(52, 9, 2, 2, 'fa-users', 'NIR participants', 'You can invite additional participants, either from your company or external, into the NIR.', NULL, NULL, 0, 0, 0, NULL, 0, 0, 0),
(58, 3, 1, 15, 'fa-search', 'Check profile status', 'You can consult the EEN portal to see the progress of the profile validation and publication. Once the profile is online, click on "Done" and the innovator will be notified about this fact.', NULL, NULL, 3, 0, 0, 0, 0, 0, 0),
(59, 3, 1, 16, 'fa-search', 'Search potential partners', 'You can search potential partners using the EEN portal', NULL, NULL, 5, 0, 0, 0, 0, 1, 2),
(62, 2, 1, 16, 'fa-search', 'Search potential partners', 'You can search potential partners using the EEN portal', NULL, NULL, 5, 0, 0, 0, 0, 1, 2),
(63, 4, 1, 16, 'fa-search', 'Search potential partners', 'You can search potential partners using the EEN portal', NULL, NULL, 5, 0, 0, 0, 0, 1, 2),
(60, 3, 1, 17, 'fa-search', 'Check Expressions of Interest', 'You can consult and manage EoIs from the EEN portal', NULL, NULL, 5, 0, 0, 0, 0, 0, 0),
(81, 10, 2, 20, 'fa-shield', 'NDA signature', 'Is the NDA signature mandatory in your NIR?\r\nIf so, all participants will be required to sign the NDA before being able to participate in the NIR. \r\nIf not, no one will be required to sign the NDA.', NULL, NULL, 0, 0, 1, NULL, 0, 0, 0),
(82, 10, 2, 21, 'fa-shield', 'Choose NDA model', 'Please choose the NDA model that will govern your NIR. Any participant will be required to sign it before being able to participate and accessing any content.', NULL, NULL, 1, 0, 1, NULL, 1, 0, 0),
(83, 10, 2, 22, 'fa-commenting-o', 'NDA model discussion', 'Please report any addition or objection to the proposed NDA model.', NULL, NULL, 2, 0, 0, NULL, 1, 0, 0),
(84, 10, 2, 23, 'fa-check', 'Confirm NDA model', 'Please confirm if you agree to use the proposed NDA model.', NULL, NULL, 3, 0, 1, NULL, 1, 0, 0),
(85, 10, 2, 24, 'fa-check-square-o', 'Sign NDA model', 'Click to accept and implicitly sign the NDA model.', NULL, NULL, 4, 0, 1, 86, 1, 0, 0),
(86, 10, 2, 25, 'fa-info-circle', 'NDA status', 'Below you will see the current status of the NDA signature process.', NULL, NULL, 4, 0, 1, NULL, 1, 0, 1),
(50, 14, 2, 18, 'fa-info-circle', 'Your role in the NIR', 'Below you can see the role you have been assigned in the NIR. If you are "participant" you will be able to see any content being shared and participate in conversations. If you are "observer" you can only see the progress but you will not be able to access any information being shared.', NULL, NULL, 0, 0, 0, NULL, 0, 1, 2),
(90, 14, 2, 25, 'fa-info-circle', 'NDA Status', 'Below you will see the current status of the NDA signature process.', NULL, 86, 3, 0, 1, NULL, 1, 0, 1),
(61, 18, 2, 18, 'fa-info-circle', 'Your role in the NIR', 'Below you can see the role you have been assigned in the NIR. If you are "participant" you will be able to see any content being shared and participate in conversations. If you are "observer" you can only see the progress but you will not be able to access any information being shared.', NULL, NULL, 0, 0, 0, NULL, 0, 1, 2),
(91, 18, 2, 26, 'fa-search', 'Proposed NDA model', 'Below you can see the NDA model proposed by the NIR leader. You will be able to provide any concern in a subsequent step.', NULL, NULL, 0, 0, 0, NULL, 1, 0, 0),
(92, 18, 2, 22, 'fa-commenting-o', 'NDA Model discussion', 'Please report any addition or objection to the proposed NDA model.', NULL, 83, 1, 0, 0, NULL, 1, 0, 0),
(93, 18, 2, 24, 'fa-check-square-o', 'Sign NDA model', 'Click to accept and implicitly sign the NDA model.', NULL, 85, 2, 0, 1, NULL, 1, 0, 0),
(94, 18, 2, 25, 'fa-info-circle', 'NDA status', 'Below you will see the current status of the NDA signature process.', NULL, 86, 3, 0, 1, NULL, 1, 0, 1),
(95, 2, 1, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(96, 2, 1, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(97, 1, 1, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(98, 1, 1, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(99, 3, 1, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(100, 3, 1, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(101, 10, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(102, 10, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(103, 14, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(104, 14, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(105, 18, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(106, 18, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(107, 22, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(108, 22, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(109, 11, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(110, 11, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(111, 15, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(112, 15, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(113, 19, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(114, 19, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(115, 23, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(116, 23, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(117, 9, 2, 27, 'fa-lightbulb-o', 'Linknovate', 'For tech seekers: Search across millions of data points (sources), Draw insights with advanced visualization tools, Save topics to stay posted on the lastest, Connect with those with the answers.\r\n\r\nFor tech providers: Market your capabilities, Connect with new clients and partners, Access grants and business opportunities.', NULL, NULL, 7, 0, 1, NULL, 0, 1, 2),
(118, 9, 2, 28, 'fa-lightbulb-o', 'IPlytics', 'Monitor industry trends, Value patent portfolios, Quantify competition, Spot market players, Track your competitors, Locate markets', NULL, NULL, 8, 0, 0, NULL, 0, 1, 2),
(132, 9, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(133, 23, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(134, 19, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(135, 15, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(136, 11, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(137, 22, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(138, 18, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(139, 14, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(140, 10, 2, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(141, 3, 1, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(142, 2, 1, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(143, 1, 1, 29, 'fa-lightbulb-o', 'IPIB', 'IP Industry Base', NULL, NULL, 9, 0, 0, NULL, 0, 1, 2),
(53,22,2,1,'fa-info-circle','Advisor role in the NIR','Below you can see the role the Innovation Advisor has been assigned in the NIR. If the IA is "participant" they will be able to see any content being shared and participate in conversations. If the IA is "observer" they can only see the progress but they will not be able to access any information being shared.',NULL,NULL,0,0,0,NULL,0,1,0),
(125,22,2,26,'fa-search', 'Proposed NDA model', 'Below you can see the NDA model proposed by the NIR leader. You will be able to provide any concern in a subsequent step.', NULL, NULL, 0,0,0, NULL,1,0,0),
(126,22,2,22,'fa-commenting-o', 'NDA model discussion', 'Please report any addition or objection to the proposed NDA model.', NULL,83,1,0,0, NULL,1,0,0),
(127,22,2,24,'fa-check-square-o', 'Sign NDA model', 'Click to accept and implicitly sign the NDA model.', NULL,85,2,0,1, NULL,1,0,0),
(128,22,2,25,'fa-info-circle', 'NDA status', 'Below you will see the current status of the NDA signature process.', NULL,86,3,0,1, NULL,1,1,1);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card_content`
--

DROP TABLE IF EXISTS `card_content`;
CREATE TABLE `card_content` (
  `id` int(11) UNSIGNED NOT NULL,
  `card_id` int(11) NOT NULL,
  `content_related_id` int(11) NOT NULL,
  `tag` varchar(100) CHARACTER SET utf8 NOT NULL,
  `order` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card_restriction`
--

DROP TABLE IF EXISTS `card_restriction`;
CREATE TABLE `card_restriction` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `card_restriction_id` int(11) NOT NULL,
  `card_restriction_completed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `card_restriction`
--

INSERT INTO `card_restriction` (`id`, `card_id`, `card_restriction_id`, `card_restriction_completed_id`) VALUES
(10, 82, 81, 81),
(11, 83, 82, 81),
(12, 84, 82, 81),
(13, 85, 84, 81),
(14, 86, 84, 81),
(18, 90, 84, 81),
(19, 91, 82, 81),
(20, 92, 82, 81),
(21, 93, 84, 81),
(22, 94, 84, 81),
(23, 126, 82, 81),
(24, 125, 82, 81);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card_type`
--

DROP TABLE IF EXISTS `card_type`;
CREATE TABLE `card_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `card_type`
--

INSERT INTO `card_type` (`id`, `name`) VALUES
(1, 'Simple'),
(2, 'Invite'),
(3, 'Poll'),
(4, 'Poll Innovator'),
(5, 'Meeting'),
(6, 'Meeting Innovator'),
(7, 'File Upload'),
(8, 'Link Share'),
(9, 'Company Form'),
(10, 'Company Info Advisor'),
(11, 'Company Info Innovator'),
(12, 'Created Nirs'),
(13, 'Close Pre Nir Advisor'),
(14, 'Close Pre Nir Innovator'),
(15, 'Company Profile Status'),
(16, 'Search Business Offers'),
(17, 'Expressions of Interest'),
(18, 'Type Advisor'),
(19, 'Choose Type Advisor'),
(20, 'NDA signature obligatory?'),
(21, 'Choose a NDA model'),
(22, 'NDA Model discusion'),
(23, 'Confirm NDA Model'),
(24, 'Sign NDA Model'),
(25, 'NDA Agreement'),
(26, 'See a NDA model'),
(27, 'Expert Finder'),
(28, 'iplytics'),
(29, 'IPIB'),
(30, 'Profile Status'),
(31, 'EasyPP Profile');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cfiles_file`
--

DROP TABLE IF EXISTS `cfiles_file`;
CREATE TABLE `cfiles_file` (
  `id` int(11) NOT NULL,
  `parent_folder_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cfiles_folder`
--

DROP TABLE IF EXISTS `cfiles_folder`;
CREATE TABLE `cfiles_folder` (
  `id` int(11) NOT NULL,
  `parent_folder_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `message` text,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_linkedin` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_linkedin` text NOT NULL,
  `cooperation_looking_for` text NOT NULL,
  `missing_info` text NOT NULL,
  `company_details` text NOT NULL,
  `advisor_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_card`
--

DROP TABLE IF EXISTS `company_card`;
CREATE TABLE `company_card` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_contact`
--

DROP TABLE IF EXISTS `company_contact`;
CREATE TABLE `company_contact` (
  `id` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_linkedin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_extra`
--

DROP TABLE IF EXISTS `company_extra`;
CREATE TABLE `company_extra` (
  `id` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `cooperation_looking_for` text,
  `missing_info` text,
  `company_details` text,
  `advisor_remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_space`
--

DROP TABLE IF EXISTS `company_space`;
CREATE TABLE `company_space` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `submitted` tinyint(1) NOT NULL DEFAULT '0',
  `reason` VARCHAR(254) NULL DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `guid` varchar(45) NOT NULL,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `visibility` tinyint(4) DEFAULT NULL,
  `sticked` tinyint(4) DEFAULT NULL,
  `archived` tinytext,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `contentcontainer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contentcontainer`
--

DROP TABLE IF EXISTS `contentcontainer`;
CREATE TABLE `contentcontainer` (
  `id` int(11) NOT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `pk` int(11) DEFAULT NULL,
  `owner_user_id` int(11) DEFAULT NULL,
  `wall_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contentcontainer`
--

INSERT INTO `contentcontainer` (`id`, `guid`, `class`, `pk`, `owner_user_id`, `wall_id`) VALUES
(152, '97b730d9-fdcc-4a7d-9a45-6f20aa7bba29', 'humhub\\modules\\user\\models\\User', 48, 48, 152),
(153, 'd26e5522-f586-41fb-b03c-765285f45dba', 'humhub\\modules\\user\\models\\User', 49, 49, 153);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contentcontainer_permission`
--

DROP TABLE IF EXISTS `contentcontainer_permission`;
CREATE TABLE `contentcontainer_permission` (
  `permission_id` varchar(150) NOT NULL,
  `contentcontainer_id` int(11) NOT NULL DEFAULT '0',
  `group_id` varchar(50) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contentcontainer_setting`
--

DROP TABLE IF EXISTS `contentcontainer_setting`;
CREATE TABLE `contentcontainer_setting` (
  `id` int(11) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  `contentcontainer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_container_page`
--

DROP TABLE IF EXISTS `custom_pages_container_page`;
CREATE TABLE `custom_pages_container_page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `page_content` text,
  `type` smallint(6) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `in_new_window` tinyint(1) DEFAULT '0',
  `admin_only` tinyint(1) DEFAULT '0',
  `cssClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_container_snippet`
--

DROP TABLE IF EXISTS `custom_pages_container_snippet`;
CREATE TABLE `custom_pages_container_snippet` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `page_content` text,
  `type` smallint(6) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `admin_only` tinyint(1) DEFAULT '0',
  `cssClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_page`
--

DROP TABLE IF EXISTS `custom_pages_page`;
CREATE TABLE `custom_pages_page` (
  `id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `content` mediumtext,
  `sort_order` int(11) DEFAULT NULL,
  `navigation_class` varchar(255) NOT NULL,
  `admin_only` tinyint(1) DEFAULT '0',
  `in_new_window` tinyint(1) DEFAULT '0',
  `cssClass` varchar(255) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_snippet`
--

DROP TABLE IF EXISTS `custom_pages_snippet`;
CREATE TABLE `custom_pages_snippet` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `content` text,
  `type` smallint(6) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `sidebar` varchar(255) NOT NULL,
  `admin_only` tinyint(1) DEFAULT '0',
  `cssClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template`
--

DROP TABLE IF EXISTS `custom_pages_template`;
CREATE TABLE `custom_pages_template` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `engine` varchar(100) NOT NULL,
  `description` text,
  `source` text,
  `allow_for_spaces` tinyint(1) DEFAULT '0',
  `type` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template`
--

INSERT INTO `custom_pages_template` (`id`, `name`, `engine`, `description`, `source`, `allow_for_spaces`, `type`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'system_two_column_layout', 'twig', 'Simple two column layout.', '<div class="row">\n	<div class="col-md-8">\n		<div class="panel panel-default">\n			<div class="panel-body">\n				{{ content }}\n			</div>\n		</div>\n	</div>\n	<div class="col-md-4">\n		<div class="panel panel-default">\n			<div class="panel-body">\n				{{ sidebar_container }}\n			</div>\n		</div>	\n	</div>\n</div>', 0, 'layout', '2016-11-07 14:11:34', NULL, NULL, NULL),
(2, 'system_one_column_layout', 'twig', 'Simple one column layout.', '<div class="row">\n	<div class="col-md-12">\n            <div class="panel panel-default">\n			<div class="panel-body">\n                            {{ content }}\n                        </div>\n            </div>\n	</div>\n</div>', 0, 'layout', '2016-11-07 14:11:35', NULL, NULL, NULL),
(3, 'system_headline_container', 'twig', 'Simple headline row with background image.', '{% if background.empty %}\n    {% set bg = assets[\'bgImage2.jpg\']  %}\n{% else %}\n    {% set bg =  background %}\n{% endif %}\n\n<div style="height:218px;overflow:hidden;color:#fff;background-image: url(\'{{ bg }}\');background-position:50% 50%;text-align:center;">\n	<div style="padding-top:40px;">\n		<h1 style="color:#fff;font-size:36px;margin:20px 0 10px;">{{ heading }}</h1>\n		<hr style="max-width:100px;border-width:3px;">\n		 <span>{{ subheading }}</span>\n  	 </div>\n</div>', 0, 'container', '2016-11-07 14:11:35', NULL, NULL, NULL),
(4, 'system_article_container', 'twig', 'Simple richtext article.', '<div style="margin-top:15px;">\n	<div style="padding:0 15px;">\n		{{ content }}\n	</div>\n</div>', 0, 'container', '2016-11-07 14:11:36', NULL, NULL, NULL),
(5, 'system_simple_snippet_layout', 'twig', 'Simple snippet layout with head container and richtext.', '<div>\n        {{ heading }}\n</div>\n<div style="margin-top:15px;">\n	{{ content }}\n</div>', 0, 'snipped-layout', '2016-11-07 14:11:36', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_container`
--

DROP TABLE IF EXISTS `custom_pages_template_container`;
CREATE TABLE `custom_pages_template_container` (
  `id` int(11) NOT NULL,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_container_content`
--

DROP TABLE IF EXISTS `custom_pages_template_container_content`;
CREATE TABLE `custom_pages_template_container_content` (
  `id` int(11) NOT NULL,
  `definition_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_container_content`
--

INSERT INTO `custom_pages_template_container_content` (`id`, `definition_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_container_content_definition`
--

DROP TABLE IF EXISTS `custom_pages_template_container_content_definition`;
CREATE TABLE `custom_pages_template_container_content_definition` (
  `id` int(11) NOT NULL,
  `allow_multiple` tinyint(1) DEFAULT '0',
  `is_inline` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_container_content_definition`
--

INSERT INTO `custom_pages_template_container_content_definition` (`id`, `allow_multiple`, `is_inline`, `is_default`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 1),
(3, 1, 0, 1),
(4, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_container_content_item`
--

DROP TABLE IF EXISTS `custom_pages_template_container_content_item`;
CREATE TABLE `custom_pages_template_container_content_item` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `container_content_id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT '100',
  `title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_container_content_template`
--

DROP TABLE IF EXISTS `custom_pages_template_container_content_template`;
CREATE TABLE `custom_pages_template_container_content_template` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `definition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_container_content_template`
--

INSERT INTO `custom_pages_template_container_content_template` (`id`, `template_id`, `definition_id`) VALUES
(1, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_element`
--

DROP TABLE IF EXISTS `custom_pages_template_element`;
CREATE TABLE `custom_pages_template_element` (
  `id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `content_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_element`
--

INSERT INTO `custom_pages_template_element` (`id`, `template_id`, `name`, `content_type`) VALUES
(1, 1, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent'),
(2, 1, 'sidebar_container', 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent'),
(3, 2, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent'),
(4, 3, 'heading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\TextContent'),
(5, 3, 'subheading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\TextContent'),
(6, 3, 'background', 'humhub\\modules\\custom_pages\\modules\\template\\models\\FileContent'),
(7, 4, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\RichtextContent'),
(8, 5, 'heading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent'),
(9, 5, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\RichtextContent');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_file_content`
--

DROP TABLE IF EXISTS `custom_pages_template_file_content`;
CREATE TABLE `custom_pages_template_file_content` (
  `id` int(11) NOT NULL,
  `file_guid` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_image_content`
--

DROP TABLE IF EXISTS `custom_pages_template_image_content`;
CREATE TABLE `custom_pages_template_image_content` (
  `id` int(11) NOT NULL,
  `file_guid` varchar(45) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `definition_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_image_content_definition`
--

DROP TABLE IF EXISTS `custom_pages_template_image_content_definition`;
CREATE TABLE `custom_pages_template_image_content_definition` (
  `id` int(11) NOT NULL,
  `height` int(10) DEFAULT NULL,
  `width` int(10) DEFAULT NULL,
  `style` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_owner_content`
--

DROP TABLE IF EXISTS `custom_pages_template_owner_content`;
CREATE TABLE `custom_pages_template_owner_content` (
  `id` int(11) NOT NULL,
  `element_name` varchar(100) NOT NULL,
  `owner_model` varchar(100) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `content_type` varchar(100) NOT NULL,
  `content_id` int(11) NOT NULL,
  `use_default` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_owner_content`
--

INSERT INTO `custom_pages_template_owner_content` (`id`, `element_name`, `owner_model`, `owner_id`, `content_type`, `content_id`, `use_default`) VALUES
(1, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 1, 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent', 1, 0),
(2, 'sidebar_container', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 1, 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent', 2, 0),
(3, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 2, 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent', 3, 0),
(4, 'heading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 3, 'humhub\\modules\\custom_pages\\modules\\template\\models\\TextContent', 1, 0),
(5, 'subheading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 3, 'humhub\\modules\\custom_pages\\modules\\template\\models\\TextContent', 2, 0),
(6, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 4, 'humhub\\modules\\custom_pages\\modules\\template\\models\\RichtextContent', 1, 0),
(7, 'heading', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 5, 'humhub\\modules\\custom_pages\\modules\\template\\models\\ContainerContent', 4, 0),
(8, 'content', 'humhub\\modules\\custom_pages\\modules\\template\\models\\Template', 5, 'humhub\\modules\\custom_pages\\modules\\template\\models\\RichtextContent', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_richtext_content`
--

DROP TABLE IF EXISTS `custom_pages_template_richtext_content`;
CREATE TABLE `custom_pages_template_richtext_content` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_richtext_content`
--

INSERT INTO `custom_pages_template_richtext_content` (`id`, `content`) VALUES
(1, '<h1>This is a&nbsp;simple article!</h1>\n\n<hr />\n<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\n'),
(2, '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_pages_template_text_content`
--

DROP TABLE IF EXISTS `custom_pages_template_text_content`;
CREATE TABLE `custom_pages_template_text_content` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `custom_pages_template_text_content`
--

INSERT INTO `custom_pages_template_text_content` (`id`, `content`) VALUES
(1, 'My Headline'),
(2, 'My Subheadline');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enterprise_ldap_group`
--

DROP TABLE IF EXISTS `enterprise_ldap_group`;
CREATE TABLE `enterprise_ldap_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `dn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enterprise_ldap_space`
--

DROP TABLE IF EXISTS `enterprise_ldap_space`;
CREATE TABLE `enterprise_ldap_space` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `dn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extra_data_user`
--

DROP TABLE IF EXISTS `extra_data_user`;
CREATE TABLE `extra_data_user` (
  `id` int(11) NOT NULL,
  `username` varchar(80) DEFAULT NULL,
  `password` text,
  `source_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dismissed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `guid` varchar(45) DEFAULT NULL,
  `object_model` varchar(100) DEFAULT '',
  `object_id` varchar(100) DEFAULT '',
  `file_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mime_type` varchar(150) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `space_id` int(10) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `ldap_dn` varchar(255) DEFAULT NULL,
  `is_admin_group` tinyint(1) NOT NULL DEFAULT '0',
  `show_at_registration` tinyint(1) NOT NULL DEFAULT '1',
  `show_at_directory` tinyint(1) NOT NULL DEFAULT '1',
  `enterprise_email_map` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `group`
--

INSERT INTO `group` (`id`, `space_id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `ldap_dn`, `is_admin_group`, `show_at_registration`, `show_at_directory`, `enterprise_email_map`) VALUES
(1, NULL, 'Administrator', 'Administrator Group', '2016-11-07 12:31:39', NULL, NULL, NULL, NULL, 1, 0, 0, NULL),
(2, NULL, 'Users', 'Example Group by Installer', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL),
(3, NULL, 'Innovation Advisor', '', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL),
(4, NULL, 'Innovator', '', NULL, NULL, NULL, NULL, NULL, 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_permission`
--

DROP TABLE IF EXISTS `group_permission`;
CREATE TABLE `group_permission` (
  `permission_id` varchar(150) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `module_id` varchar(50) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_user`
--

DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `is_group_manager` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `added_by_ldap` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `group_user`
--

INSERT INTO `group_user` (`id`, `user_id`, `group_id`, `is_group_manager`, `created_at`, `created_by`, `updated_at`, `updated_by`, `added_by_ldap`) VALUES
(1, 1, 1, 0, '2016-11-07 12:33:44', NULL, '2016-11-07 12:33:44', NULL, 0),
(44, 48, 3, 0, '2017-01-16 14:11:15', 1, '2017-01-16 14:11:15', 1, 0),
(45, 49, 4, 0, '2017-01-16 14:12:04', 1, '2017-01-16 14:12:04', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `like`
--

DROP TABLE IF EXISTS `like`;
CREATE TABLE `like` (
  `id` int(11) NOT NULL,
  `target_user_id` int(11) DEFAULT NULL,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linklist_category`
--

DROP TABLE IF EXISTS `linklist_category`;
CREATE TABLE `linklist_category` (
  `id` int(11) NOT NULL,
  `title` text,
  `description` text,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linklist_link`
--

DROP TABLE IF EXISTS `linklist_link`;
CREATE TABLE `linklist_link` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `href` text,
  `title` text,
  `description` text,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` bigint(20) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_entry`
--

DROP TABLE IF EXISTS `message_entry`;
CREATE TABLE `message_entry` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1478518251),
('m131023_164513_initial', 1478518254),
('m131023_165214_initial', 1478524423),
('m131023_165411_initial', 1478518254),
('m131023_165507_initial', 1478524323),
('m131023_165625_initial', 1478518254),
('m131023_165755_initial', 1478518255),
('m131023_165835_initial', 1478518255),
('m131023_165921_initial', 1478524429),
('m131023_170033_initial', 1478518255),
('m131023_170135_initial', 1478518255),
('m131023_170159_initial', 1478518256),
('m131023_170253_initial', 1478518256),
('m131023_170339_initial', 1478518256),
('m131030_122743_longer_questions', 1478524429),
('m131203_110444_oembed', 1478518257),
('m131213_165552_user_optimize', 1478518258),
('m140226_111945_ldap', 1478518259),
('m140303_125031_password', 1478518260),
('m140304_142711_memberautoadd', 1478518260),
('m140321_000917_content', 1478518262),
('m140324_170617_membership', 1478518262),
('m140507_150421_create_settings_table', 1478518263),
('m140507_171527_create_settings_table', 1478518263),
('m140512_141414_i18n_profilefields', 1478518264),
('m140513_180317_createlogging', 1478518264),
('m140701_000611_profile_genderfield', 1478518264),
('m140701_074404_protect_default_profilefields', 1478518264),
('m140702_143912_notify_notification_unify', 1478518264),
('m140703_104527_profile_birthdayfield', 1478518264),
('m140704_080659_installationid', 1478518265),
('m140705_065525_emailing_settings', 1478518265),
('m140706_135210_lastlogin', 1478518266),
('m140708_155237_initial', 1478524314),
('m140729_223509_initial', 1478524281),
('m140812_093445_rename_deadline_column', 1478524423),
('m140829_122906_delete', 1478518266),
('m140830_145504_following', 1478518266),
('m140901_080147_indizies', 1478518267),
('m140901_080432_indices', 1478518267),
('m140901_112246_addState', 1478518268),
('m140901_153403_addState', 1478518269),
('m140901_170329_group_create_space', 1478518269),
('m140902_091234_session_key_length', 1478518269),
('m140907_140822_zip_field_to_text', 1478518269),
('m140930_045035_initial', 1478524288),
('m140930_205511_fix_default', 1478518270),
('m140930_205859_fix_default', 1478518270),
('m140930_210142_fix_default', 1478518271),
('m140930_210635_fix_default', 1478518272),
('m140930_212528_fix_default', 1478518272),
('m141002_084750_fix_default', 1478524424),
('m141002_092800_fix_deadline', 1478524424),
('m141002_093710_fix_default', 1478524430),
('m141004_022835_initial', 1478524435),
('m141015_173305_follow_notifications', 1478518273),
('m141019_093319_mentioning', 1478518274),
('m141020_162639_fix_default', 1478518275),
('m141020_193920_rm_alsocreated', 1478518275),
('m141020_193931_rm_alsoliked', 1478518275),
('m141021_162639_oembed_setting', 1478518275),
('m141022_094635_addDefaults', 1478518275),
('m141026_135537_adminOnly', 1478524288),
('m141106_185632_log_init', 1478518276),
('m150204_103433_html5_notified', 1478518277),
('m150210_190006_user_invite_lang', 1478518277),
('m150302_114347_add_visibility', 1478518277),
('m150322_194403_remove_type_field', 1478518278),
('m150322_195619_allowedExt2Text', 1478518278),
('m150429_190600_indexes', 1478524324),
('m150429_223856_optimize', 1478518278),
('m150510_102900_update', 1478518278),
('m150629_220311_change', 1478518280),
('m150703_012735_typelength', 1478518280),
('m150703_024635_activityTypes', 1478518280),
('m150703_033650_namespace', 1478518280),
('m150703_130157_migrate', 1478518280),
('m150704_005338_namespace', 1478518281),
('m150704_005418_namespace', 1478518281),
('m150704_005434_namespace', 1478518281),
('m150704_005452_namespace', 1478518281),
('m150704_005504_namespace', 1478518281),
('m150705_081309_namespace', 1478524435),
('m150706_193118_renamefield', 1478524282),
('m150707_134615_update', 1478524282),
('m150709_050451_namespace', 1478524325),
('m150709_151858_namespace', 1478524430),
('m150710_055123_namespace', 1478524424),
('m150713_054441_timezone', 1478518281),
('m150714_093525_activity', 1478518282),
('m150714_100355_cleanup', 1478518284),
('m150720_174011_initial', 1478524285),
('m150727_085041_namespace', 1478524314),
('m150831_061628_notifications', 1478518284),
('m150910_223305_fix_user_follow', 1478518284),
('m150916_131805_container', 1478524289),
('m150917_104409_add_new_windows', 1478524289),
('m150924_133344_update_notification_fix', 1478518285),
('m150924_154635_user_invite_add_first_lastname', 1478518285),
('m150924_191858_space_type', 1478518286),
('m150927_190830_create_contentcontainer', 1478518287),
('m150928_103711_permissions', 1478518288),
('m150928_134934_groups', 1478518289),
('m150928_140718_setColorVariables', 1478518289),
('m151010_124437_group_permissions', 1478518290),
('m151010_175000_default_visibility', 1478518291),
('m151013_223814_include_dashboard', 1478518291),
('m151022_131128_module_fix', 1478518291),
('m151106_090948_addColor', 1478518291),
('m151117_085104_ldap', 1478518292),
('m151223_171310_fix_notifications', 1478518292),
('m151224_162440_fix_module_id_notifications', 1478524424),
('m151226_164234_authclient', 1478518292),
('m160125_053702_stored_filename', 1478518292),
('m160216_160119_initial', 1478518293),
('m160217_161220_addCanLeaveFlag', 1478518294),
('m160218_132531_close_and_anonymous_poll', 1478524430),
('m160220_013525_contentcontainer_id', 1478518297),
('m160221_222312_public_permission_change', 1478518297),
('m160225_180229_remove_website', 1478518297),
('m160227_073020_birthday_date', 1478518297),
('m160229_162959_multiusergroups', 1478518300),
('m160309_141222_longerUserName', 1478518301),
('m160408_100725_rename_groupadmin_to_manager', 1478518302),
('m160501_220850_activity_pk_int', 1478518302),
('m160507_202611_settings', 1478518303),
('m160508_005740_settings_cleanup', 1478518308),
('m160509_214811_spaceurl', 1478518309),
('m160517_132535_group', 1478518310),
('m160523_105732_profile_searchable', 1478518310),
('m160712_080910_ldap_group', 1478518311),
('m160712_091704_fks', 1478518311),
('m160714_142827_remove_space_id', 1478518312),
('m160719_131212_init_templates', 1478524293),
('m160808_124800_text_content', 1478524293),
('m160817_130334_page_content_medium_text', 1478524294),
('m160831_133950_snippets', 1478524294),
('m160907_122454_file_content', 1478524294),
('m160907_175706_default_templates', 1478524297),
('m160908_084038_admin_only_other_pagetypes', 1478524297),
('m160914_101123_ldap_space', 1478518312),
('m160922_092100_page_class', 1478524298),
('m160922_115053_page_url', 1478524298),
('m160922_143514_page_url_index', 1478524299),
('m161012_064752_email_mapping', 1478524029),
('m161129_124641_create_user_invite_group_table', 1480945013);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_enabled`
--

DROP TABLE IF EXISTS `module_enabled`;
CREATE TABLE `module_enabled` (
  `module_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `module_enabled`
--

INSERT INTO `module_enabled` (`module_id`) VALUES
('calendar'),
('cards'),
('cfiles'),
('companies'),
('custom_pages'),
('enterprise'),
('linklist'),
('loginUsers'),
('mail'),
('nda'),
('polls'),
('tasks'),
('wiki'),
('help');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nda_agreement`
--

DROP TABLE IF EXISTS `nda_agreement`;
CREATE TABLE `nda_agreement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nda_model_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nda_model`
--

DROP TABLE IF EXISTS `nda_model`;
CREATE TABLE `nda_model` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nda_model`
--

INSERT INTO `nda_model` (`id`, `name`, `pdf`) VALUES
(1, 'Model 1', 'model1.pdf'),
(2, 'Model 2', 'model2.pdf'),
(3, 'Model 3', 'model3.pdf'),
(4, 'Model 4', 'model4.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nda_model_chose`
--

DROP TABLE IF EXISTS `nda_model_chose`;
CREATE TABLE `nda_model_chose` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `nda_model_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nda_model_obligatory`
--

DROP TABLE IF EXISTS `nda_model_obligatory`;
CREATE TABLE `nda_model_obligatory` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nir_related`
--

DROP TABLE IF EXISTS `nir_related`;
CREATE TABLE `nir_related` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_space_pre_nir` int(10) NOT NULL,
  `id_space_nir` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seen` tinyint(4) DEFAULT NULL,
  `source_class` varchar(100) DEFAULT NULL,
  `source_pk` int(11) DEFAULT NULL,
  `space_id` int(11) DEFAULT NULL,
  `emailed` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `desktop_notified` tinyint(1) DEFAULT '0',
  `originator_user_id` int(11) DEFAULT NULL,
  `module` varchar(100) DEFAULT '',
  `group_key` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poll`
--

DROP TABLE IF EXISTS `poll`;
CREATE TABLE `poll` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `allow_multiple` smallint(6) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_random` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `anonymous` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poll_answer`
--

DROP TABLE IF EXISTS `poll_answer`;
CREATE TABLE `poll_answer` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poll_answer_user`
--

DROP TABLE IF EXISTS `poll_answer_user`;
CREATE TABLE `poll_answer_user` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `poll_answer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `message_2trash` text,
  `message` text,
  `url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `birthday_hide_year` int(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `about` text,
  `phone_private` varchar(255) DEFAULT NULL,
  `phone_work` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `im_skype` varchar(255) DEFAULT NULL,
  `im_msn` varchar(255) DEFAULT NULL,
  `im_xmpp` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_facebook` varchar(255) DEFAULT NULL,
  `url_linkedin` varchar(255) DEFAULT NULL,
  `url_xing` varchar(255) DEFAULT NULL,
  `url_youtube` varchar(255) DEFAULT NULL,
  `url_vimeo` varchar(255) DEFAULT NULL,
  `url_flickr` varchar(255) DEFAULT NULL,
  `url_myspace` varchar(255) DEFAULT NULL,
  `url_googleplus` varchar(255) DEFAULT NULL,
  `url_twitter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`user_id`, `firstname`, `lastname`, `title`, `gender`, `street`, `zip`, `city`, `country`, `state`, `birthday_hide_year`, `birthday`, `about`, `phone_private`, `phone_work`, `mobile`, `fax`, `im_skype`, `im_msn`, `im_xmpp`, `url`, `url_facebook`, `url_linkedin`, `url_xing`, `url_youtube`, `url_vimeo`, `url_flickr`, `url_myspace`, `url_googleplus`, `url_twitter`) VALUES
(1, 'Admin', 'Admin', 'System Administration', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Innovation', 'Advisor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Innovator', 'Innovator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile_field`
--

DROP TABLE IF EXISTS `profile_field`;
CREATE TABLE `profile_field` (
  `id` int(11) NOT NULL,
  `profile_field_category_id` int(11) NOT NULL,
  `module_id` varchar(255) DEFAULT NULL,
  `field_type_class` varchar(255) NOT NULL,
  `field_type_config` text,
  `internal_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `sort_order` int(11) NOT NULL DEFAULT '100',
  `required` tinyint(4) DEFAULT NULL,
  `show_at_registration` tinyint(4) DEFAULT NULL,
  `editable` tinyint(4) NOT NULL DEFAULT '1',
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `ldap_attribute` varchar(255) DEFAULT NULL,
  `translation_category` varchar(255) DEFAULT NULL,
  `is_system` int(1) DEFAULT NULL,
  `searchable` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profile_field`
--

INSERT INTO `profile_field` (`id`, `profile_field_category_id`, `module_id`, `field_type_class`, `field_type_config`, `internal_name`, `title`, `description`, `sort_order`, `required`, `show_at_registration`, `editable`, `visible`, `created_at`, `created_by`, `updated_at`, `updated_by`, `ldap_attribute`, `translation_category`, `is_system`, `searchable`) VALUES
(1, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":20,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'firstname', 'First name', NULL, 100, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 'givenName', NULL, 1, 1),
(2, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":30,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'lastname', 'Last name', NULL, 200, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 'sn', NULL, 1, 1),
(3, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":50,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'title', 'Title', NULL, 300, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 'title', NULL, 1, 1),
(4, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{"options":"male=>Male\\nfemale=>Female\\ncustom=>Custom","fieldTypes":[]}', 'gender', 'Gender', NULL, 300, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(5, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":150,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'street', 'Street', NULL, 400, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(6, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":10,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'zip', 'Zip', NULL, 500, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(7, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'city', 'City', NULL, 600, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(8, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\CountrySelect', '{"options":null,"fieldTypes":[]}', 'country', 'Country', NULL, 700, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(9, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'state', 'State', NULL, 800, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(10, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Birthday', '{"defaultHideAge":false,"fieldTypes":[]}', 'birthday', 'Birthday', NULL, 900, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(11, 1, NULL, 'humhub\\modules\\user\\models\\fieldtype\\TextArea', '{"fieldTypes":[]}', 'about', 'About', NULL, 900, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(12, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'phone_private', 'Phone Private', NULL, 100, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(13, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'phone_work', 'Phone Work', NULL, 200, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(14, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'mobile', 'Mobile', NULL, 300, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(15, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'fax', 'Fax', NULL, 400, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(16, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'im_skype', 'Skype Nickname', NULL, 500, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(17, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":100,"validator":null,"default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'im_msn', 'MSN', NULL, 600, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(18, 2, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"email","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'im_xmpp', 'XMPP Jabber Address', NULL, 800, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(19, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url', 'Url', NULL, 100, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(20, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_facebook', 'Facebook URL', NULL, 200, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(21, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_linkedin', 'LinkedIn URL', NULL, 300, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(22, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_xing', 'Xing URL', NULL, 400, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(23, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_youtube', 'Youtube URL', NULL, 500, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(24, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_vimeo', 'Vimeo URL', NULL, 600, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(25, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_flickr', 'Flickr URL', NULL, 700, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(26, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_myspace', 'MySpace URL', NULL, 800, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(27, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_googleplus', 'Google+ URL', NULL, 900, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(28, 3, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Text', '{"minLength":null,"maxLength":255,"validator":"url","default":null,"regexp":null,"regexpErrorMessage":null,"fieldTypes":[]}', 'url_twitter', 'Twitter URL', NULL, 1000, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile_field_category`
--

DROP TABLE IF EXISTS `profile_field_category`;
CREATE TABLE `profile_field_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '100',
  `module_id` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `translation_category` varchar(255) DEFAULT NULL,
  `is_system` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profile_field_category`
--

INSERT INTO `profile_field_category` (`id`, `title`, `description`, `sort_order`, `module_id`, `visibility`, `created_at`, `created_by`, `updated_at`, `updated_by`, `translation_category`, `is_system`) VALUES
(1, 'General', '', 100, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Communication', '', 200, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Social bookmarks', '', 300, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text,
  `module_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`, `module_id`) VALUES
(1, 'oembedProviders', '{"vimeo.com":"http:\\/\\/vimeo.com\\/api\\/oembed.json?scheme=https&url=%url%&format=json&maxwidth=450","youtube.com":"http:\\/\\/www.youtube.com\\/oembed?scheme=https&url=%url%&format=json&maxwidth=450","youtu.be":"http:\\/\\/www.youtube.com\\/oembed?scheme=https&url=%url%&format=json&maxwidth=450","soundcloud.com":"https:\\/\\/soundcloud.com\\/oembed?url=%url%&format=json&maxwidth=450","slideshare.net":"https:\\/\\/www.slideshare.net\\/api\\/oembed\\/2?url=%url%&format=json&maxwidth=450"}', 'base'),
(2, 'defaultVisibility', '0', 'space'),
(3, 'defaultJoinPolicy', '0', 'space'),
(4, 'colorDefault', '#ededed', 'base'),
(5, 'colorPrimary', '#2d3340', 'base'),
(6, 'colorInfo', '#6fdbe8', 'base'),
(7, 'colorSuccess', '#97d271', 'base'),
(8, 'colorWarning', '#fdd198', 'base'),
(9, 'colorDanger', '#fc4a64', 'base'),
(10, 'name', 'nirvana', 'base'),
(11, 'baseUrl', 'http://nirvana.easyinnova.com', 'base'),
(12, 'paginationSize', '10', 'base'),
(13, 'displayNameFormat', '{profile.firstname} {profile.lastname}', 'base'),
(14, 'horImageScrollOnMobile', '1', 'base'),
(15, 'auth.ldap.refreshUsers', '1', 'user'),
(16, 'auth.needApproval', '0', 'user'),
(17, 'auth.anonymousRegistration', '1', 'user'),
(18, 'auth.internalUsersCanInvite', '1', 'user'),
(19, 'mailer.transportType', 'smtp', 'base'),
(20, 'mailer.systemEmailAddress', 'social@example.com', 'base'),
(21, 'mailer.systemEmailName', 'nirvana', 'base'),
(22, 'receive_email_activities', '1', 'activity'),
(23, 'receive_email_notifications', '2', 'notification'),
(24, 'maxFileSize', '5242880', 'file'),
(25, 'maxPreviewImageWidth', '200', 'file'),
(26, 'maxPreviewImageHeight', '200', 'file'),
(27, 'hideImageFileInfo', '0', 'file'),
(28, 'cache.class', 'yii\\caching\\FileCache', 'base'),
(29, 'cache.expireTime', '3600', 'base'),
(30, 'installationId', '6f8ad2eef3c45a14a714ca5071b31c8f', 'admin'),
(31, 'theme', 'enterprise', 'base'),
(32, 'spaceOrder', '0', 'space'),
(33, 'enable', '0', 'tour'),
(34, 'defaultLanguage', 'en', 'base'),
(35, 'enable_html5_desktop_notifications', '0', 'notification'),
(36, 'licence', '', 'enterprise'),
(37, 'last_check', '1478518351', 'enterprise'),
(38, 'licence_valid', '0', 'enterprise'),
(39, 'useCase', 'other', 'base'),
(40, 'sampleData', '1', 'installer'),
(41, 'secret', '7aedbc27-6194-4ed2-9945-5e803c126528', 'base'),
(42, 'timeZone', 'Europe/Madrid', 'base'),
(43, 'trial_start', '1478518486', 'enterprise'),
(44, 'defaultDateInputFormat', '', 'admin'),
(45, 'defaultContentVisibility', '0', 'space'),
(46, 'auth.defaultUserGroup', '', 'user'),
(47, 'auth.defaultUserIdleTimeoutSec', '', 'user'),
(48, 'auth.allowGuestAccess', '1', 'user'),
(49, 'auth.defaultUserProfileVisibility', '1', 'user'),
(50, 'showProfilePostForm', '0', 'dashboard'),
(51, 'enable', '0', 'friendship'),
(52, 'stream.defaultSort', 'c', 'content'),
(53, 'mailer.hostname', 'smtp.gmail.com', 'base'),
(54, 'mailer.username', 'blueroominnovation@gmail.com', 'base'),
(55, 'mailer.password', 'BlueVision2015', 'base'),
(56, 'mailer.port', '587', 'base'),
(57, 'mailer.encryption', 'tls', 'base'),
(58, 'mailer.allowSelfSignedCerts', '0', 'base');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `source_type`
--

DROP TABLE IF EXISTS `source_type`;
CREATE TABLE `source_type` (
  `id` int(11) NOT NULL,
  `source_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `source_type`
--

INSERT INTO `source_type` (`id`, `source_name`) VALUES
(1, 'EEN'),
(2, 'EASYPP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space`
--

DROP TABLE IF EXISTS `space`;
CREATE TABLE `space` (
  `id` int(11) NOT NULL,
  `guid` varchar(45) DEFAULT NULL,
  `wall_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `description` text,
  `join_policy` tinyint(4) DEFAULT NULL,
  `visibility` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `tags` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `ldap_dn` varchar(255) DEFAULT NULL,
  `auto_add_new_members` int(4) DEFAULT NULL,
  `space_type_id` bigint(20) DEFAULT NULL,
  `contentcontainer_id` int(11) DEFAULT NULL,
  `default_content_visibility` tinyint(1) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `members_can_leave` int(11) DEFAULT '1',
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space_membership`
--

DROP TABLE IF EXISTS `space_membership`;
CREATE TABLE `space_membership` (
  `space_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `originator_user_id` varchar(45) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `request_message` text,
  `last_visit` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT 'member',
  `show_at_dashboard` tinyint(1) DEFAULT '0',
  `can_cancel_membership` int(11) DEFAULT '1',
  `added_by_ldap` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space_module`
--

DROP TABLE IF EXISTS `space_module`;
CREATE TABLE `space_module` (
  `id` int(11) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `space_id` int(11) NOT NULL,
  `state` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `space_module`
--

INSERT INTO `space_module` (`id`, `module_id`, `space_id`, `state`) VALUES
(1, 'calendar', 0, 2),
(2, 'cfiles', 0, 2),
(3, 'companies', 0, 2),
(4, 'linklist', 0, 2),
(5, 'nda', 0, 2),
(6, 'polls', 0, 2),
(7, 'tasks', 0, 2),
(8, 'wiki', 0, 2),
(9, 'help', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space_type`
--

DROP TABLE IF EXISTS `space_type`;
CREATE TABLE `space_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `sort_key` int(11) NOT NULL DEFAULT '100',
  `show_in_directory` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `space_type`
--

INSERT INTO `space_type` (`id`, `title`, `item_title`, `sort_key`, `show_in_directory`) VALUES
(2, 'PSR Business offers', 'PSR Business offers', 1, 1),
(3, 'PSR Business requests', 'PSR Business requests', 2, 0),
(4, 'PSR Technology offers', 'PSR Technology offers', 3, 1),
(5, 'PSR Technology requests', 'PSR Technology requests', 4, 1),
(6, 'PSR Research & Development', 'PSR Research & Development', 5, 1),
(7, 'NIR Business offers', 'NIR Business offers', 50, 1),
(8, 'NIR Business requests', 'NIR Business requests', 51, 1),
(9, 'NIR Technology offers', 'NIR Technology offers', 52, 1),
(10, 'NIR Technology requests', 'NIR Technology requests', 53, 1),
(11, 'Projects archive', 'Projects archive', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space_type_relationship`
--

DROP TABLE IF EXISTS `space_type_relationship`;
CREATE TABLE `space_type_relationship` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `category_related` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `space_type_relationship`
--

INSERT INTO `space_type_relationship` (`id`, `category_id`, `category_name`, `category_related`) VALUES
(1, 2, 'PSR Business offers', '7'),
(2, 3, 'PSR Business requests', '8'),
(3, 4, 'PSR Technology offers', '9'),
(4, 5, 'PSR Technology requests', '10'),
(5, 6, 'PSR Research & Development', '11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `space_user_role`
--

DROP TABLE IF EXISTS `space_user_role`;
CREATE TABLE `space_user_role` (
  `space_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `step`
--

DROP TABLE IF EXISTS `step`;
CREATE TABLE `step` (
  `id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `step_name` varchar(255) NOT NULL DEFAULT '',
  `step_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `step`
--

INSERT INTO `step` (`id`, `workflow_id`, `user_role_id`, `step_name`, `step_order`) VALUES
(1, 1, 1, 'Invite User', 0),
(2, 1, 1, 'Enter EEN Profile', 1),
(3, 1, 1, 'Selection Process', 2),
(4, 1, 1, 'NIR Created', 3),
(6, 1, 2, 'Company Profile', 0),
(7, 1, 2, 'Selection process', 1),
(8, 1, 2, 'NIR Created', 2),
(9, 2, 2, 'NIR Created', 0),
(10, 2, 2, 'NDA signature', 1),
(11, 2, 2, 'Ongoing Collaboration', 2),
(12, 2, 2, 'Agreement Achieved', 3),
(14, 2, 3, 'NDA signature', 0),
(15, 2, 3, 'Ongoing Collaboration', 1),
(16, 2, 3, 'Agreement Achieved', 2),
(18, 2, 4, 'NDA signature', 0),
(19, 2, 4, 'Ongoing Collaboration', 1),
(20, 2, 4, 'Agreement Achieved', 2),
(22, 2, 5, 'NDA signature', 0),
(23, 2, 5, 'Ongoing Collaboration', 1),
(24, 2, 5, 'Agreement Achieved', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `step_user_space`
--

DROP TABLE IF EXISTS `step_user_space`;
CREATE TABLE `step_user_space` (
  `id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'hold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `max_users` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `percent` smallint(6) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_user`
--

DROP TABLE IF EXISTS `task_user`;
CREATE TABLE `task_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `url_oembed`
--

DROP TABLE IF EXISTS `url_oembed`;
CREATE TABLE `url_oembed` (
  `url` varchar(255) NOT NULL,
  `preview` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `guid` varchar(45) DEFAULT NULL,
  `wall_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `auth_mode` varchar(10) NOT NULL,
  `tags` text,
  `language` varchar(5) DEFAULT NULL,
  `last_activity_email` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `visibility` int(1) DEFAULT '1',
  `time_zone` varchar(100) DEFAULT NULL,
  `contentcontainer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `guid`, `wall_id`, `status`, `username`, `email`, `auth_mode`, `tags`, `language`, `last_activity_email`, `created_at`, `created_by`, `updated_at`, `updated_by`, `last_login`, `visibility`, `time_zone`, `contentcontainer_id`) VALUES
(1, 'bb169071-faf7-42aa-aa0f-f9217bdbccaa', 1, 1, 'admin@easyinnova.com', 'admin@easyinnova.com', 'local', 'Administration, Support, HumHub', '', '2016-11-07 12:33:42', '2016-11-07 12:33:42', NULL, '2016-11-07 12:33:42', NULL, '2017-01-16 14:21:53', 1, NULL, 1),
(48, '97b730d9-fdcc-4a7d-9a45-6f20aa7bba29', 152, 1, 'advisor', 'advisor@advisor.com', 'local', NULL, 'en-US', '2017-01-16 14:11:15', '2017-01-16 14:11:15', 1, '2017-01-16 14:11:15', 1, NULL, 1, 'Europe/Madrid', 152),
(49, 'd26e5522-f586-41fb-b03c-765285f45dba', 153, 1, 'innovator', 'innovator@innovator.com', 'local', NULL, 'en-US', '2017-01-16 14:12:03', '2017-01-16 14:12:03', 1, '2017-01-16 14:12:03', 1, NULL, 1, 'Europe/Madrid', 153);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_card`
--

DROP TABLE IF EXISTS `user_card`;
CREATE TABLE `user_card` (
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `card_status` varchar(10) COLLATE utf8_general_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_follow`
--

DROP TABLE IF EXISTS `user_follow`;
CREATE TABLE `user_follow` (
  `id` int(11) NOT NULL,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `send_notifications` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_friendship`
--

DROP TABLE IF EXISTS `user_friendship`;
CREATE TABLE `user_friendship` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_http_session`
--

DROP TABLE IF EXISTS `user_http_session`;
CREATE TABLE `user_http_session` (
  `id` char(255) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_invite`
--

DROP TABLE IF EXISTS `user_invite`;
CREATE TABLE `user_invite` (
  `id` int(11) NOT NULL,
  `user_originator_id` int(11) DEFAULT NULL,
  `space_invite_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `source` varchar(45) DEFAULT NULL,
  `token` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `language` varchar(10) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_invite_group`
--

DROP TABLE IF EXISTS `user_invite_group`;
CREATE TABLE `user_invite_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_invite_id` int(11) DEFAULT NULL,
  `space_role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_mentioning`
--

DROP TABLE IF EXISTS `user_mentioning`;
CREATE TABLE `user_mentioning` (
  `id` int(11) NOT NULL,
  `object_model` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_message`
--

DROP TABLE IF EXISTS `user_message`;
CREATE TABLE `user_message` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_originator` tinyint(4) DEFAULT NULL,
  `last_viewed` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_module`
--

DROP TABLE IF EXISTS `user_module`;
CREATE TABLE `user_module` (
  `id` int(11) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_module`
--

INSERT INTO `user_module` (`id`, `module_id`, `user_id`, `state`) VALUES
(1, 'calendar', 0, 0),
(2, 'cfiles', 0, 0),
(3, 'linklist', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_password`
--

DROP TABLE IF EXISTS `user_password`;
CREATE TABLE `user_password` (
  `id` int(11) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `algorithm` varchar(20) DEFAULT NULL,
  `password` text,
  `salt` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_password`
--

INSERT INTO `user_password` (`id`, `user_id`, `algorithm`, `password`, `salt`, `created_at`) VALUES
(1, 1, 'sha512whirlpool', 'ff277996fc82f6e46f95998733720ff18c1039021d9dc59efe7fcb89cc88e0f8d22599ca0a9b52a195ddd14e92c54a079011843811f43711e3ccda69853023ca', 'f68573f9-daa4-4b3d-a2f0-f64b32776074', '2016-11-07 12:33:43'),
(2, 1, 'sha512whirlpool', '8c15ffe15db0b03104b5158ed52ef36e0cca0a71dee1e3a7100b2f45f50a729f35d9db60436ff34072476c830316fcd3d52aa122fa36f3e8af5934f9ecab9730', 'cd4aae3b-2327-43f2-9002-3109e5f5d589', '2016-11-07 14:28:14'),
(31, 48, 'sha512whirlpool', 'c8e2181ebdeafd9342cce26baaa8818cb4186ae1d5414a454c520cc906e9914ad087493f8d4e9f87cbdf18a3c4f267c3079692abe46960dcf9c74a53f4a8af42', 'dcae968b-d80e-4f46-a699-5bb7700d7f41', '2017-01-16 14:11:15'),
(32, 49, 'sha512whirlpool', '9d4786e47d99f40585be88ffdc76b12e803ed51b4e83835cf4829f5cd7208bcf9f61748f1ca4c56325fee5510ee7e49500c882bce58ac144a529d9e6e9a53468', 'cffbe4d7-39e1-4fa7-94b8-1a2fcc766404', '2017-01-16 14:12:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `user_role`
--

INSERT INTO `user_role` (`id`, `group_id`, `name`) VALUES
(1, 3, 'Advisor'),
(2, 4, 'Innovator'),
(3, 3, 'Advisor Observer'),
(4, 3, 'Advisor Participant'),
(5, 4, 'Company');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_role_workflow`
--

DROP TABLE IF EXISTS `user_role_workflow`;
CREATE TABLE `user_role_workflow` (
  `id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `user_role_workflow`
--

INSERT INTO `user_role_workflow` (`id`, `user_role_id`, `workflow_id`, `group_id`, `default`) VALUES
(0, 5, 2, 4, 1),
(1, 1, 1, 3, 1),
(2, 2, 1, 4, 1),
(3, 2, 2, 4, 0),
(4, 3, 2, 3, 1),
(5, 4, 2, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wall`
--

DROP TABLE IF EXISTS `wall`;
CREATE TABLE `wall` (
  `id` int(11) NOT NULL,
  `object_model` varchar(50) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `wall`
--

INSERT INTO `wall` (`id`, `object_model`, `object_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'humhub\\modules\\user\\models\\User', 1, NULL, NULL, NULL, NULL),
(3, 'humhub\\modules\\user\\models\\User', 2, NULL, NULL, NULL, NULL),
(4, 'humhub\\modules\\user\\models\\User', 3, NULL, NULL, NULL, NULL),
(11, 'humhub\\modules\\user\\models\\User', 4, NULL, NULL, NULL, NULL),
(12, 'humhub\\modules\\user\\models\\User', 5, NULL, NULL, NULL, NULL),
(152, 'humhub\\modules\\user\\models\\User', 48, NULL, NULL, NULL, NULL),
(153, 'humhub\\modules\\user\\models\\User', 49, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wall_entry`
--

DROP TABLE IF EXISTS `wall_entry`;
CREATE TABLE `wall_entry` (
  `id` int(11) NOT NULL,
  `wall_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wiki_page`
--

DROP TABLE IF EXISTS `wiki_page`;
CREATE TABLE `wiki_page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_home` tinyint(4) NOT NULL DEFAULT '0',
  `admin_only` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wiki_page_revision`
--

DROP TABLE IF EXISTS `wiki_page_revision`;
CREATE TABLE `wiki_page_revision` (
  `id` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `is_latest` tinyint(1) NOT NULL DEFAULT '0',
  `wiki_page_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workflow`
--

DROP TABLE IF EXISTS `workflow`;
CREATE TABLE `workflow` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `workflow`
--

INSERT INTO `workflow` (`id`, `name`) VALUES
(1, 'WorkFlow Pre Nir'),
(2, 'WorkFlow Nir');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workflow_space_type`
--

DROP TABLE IF EXISTS `workflow_space_type`;
CREATE TABLE `workflow_space_type` (
  `workflow_id` int(11) NOT NULL,
  `space_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `workflow_space_type`
--

INSERT INTO `workflow_space_type` (`workflow_id`, `space_type_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `easypp_profile`
--

DROP TABLE IF EXISTS `easypp_profile`;
CREATE TABLE `easypp_profile` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `space_id` int(11) UNSIGNED,
  `profile` varchar(100) CHARACTER SET utf8,
  `online` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `easypp_links`
--

DROP TABLE IF EXISTS `easypp_links`;
CREATE TABLE `easypp_links` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `space_id` int(11) UNSIGNED,
  `profile` varchar(100) CHARACTER SET utf8,
  `advisor_link` varchar(250) CHARACTER SET utf8,
  `innovator_link` varchar(250) CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Estructura de tabla para la tabla `user_interactive_tutorial_state`
--

DROP TABLE IF EXISTS `user_interactive_tutorial_state`;
CREATE TABLE IF NOT EXISTS `user_interactive_tutorial_state` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tutorial_page_name` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_object` (`user_id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


--
-- Estructura de tabla para la tabla `cards_interactive_tutorial_state`
--
DROP TABLE IF EXISTS `cards_interactive_tutorial_state`;
CREATE TABLE IF NOT EXISTS `cards_interactive_tutorial_state` (
  `id` int(11) NOT NULL,
  `cards_id` int(11) DEFAULT NULL,
  `language` varchar(15) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `intereractive_tutorial_json` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indices de la tabla `cards_interactive_tutorial_state`
--
ALTER TABLE `cards_interactive_tutorial_state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-cards_id-tutorial_idx` (`cards_id`);


--
-- AUTO_INCREMENT de la tabla `cards_interactive_tutorial_state`
--
ALTER TABLE `cards_interactive_tutorial_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `easypp_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `easypp_links`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- Volcado de datos para la tabla `cards_interactive_tutorial_state`
--

INSERT INTO `cards_interactive_tutorial_state` (`id`, `cards_id`, `language`, `state`, `intereractive_tutorial_json`, `created`, `modified`) VALUES
(1, 31, 'en-US', 'pending', '               {\r\n            selector:\'.wall_humhubmodulescardsmodelsCard_#CARD_ID_#\',\r\n            showNext: true,\r\n            description: "With the Enter Company Profile card, you can create and share a profile page",\r\n            shape: \'rect\',\r\n            timeout: 100\r\n        },\r\n                {\r\n            selector:\'#folded-card-id-#CARD_ID_#\',\r\n            event:\'click\',\r\n            showNext: false,\r\n            description: "Unfold the card",\r\n            shape: \'rect\',\r\n            timeout: 100\r\n        }', NULL, NULL),
(3, 34, 'en-US', 'pending', '{\r\n                selector:\'#child-card-id-#CARD_ID_#\',\r\n                showNext: true,\r\n                description: "This Card let\'s you to find a link from EasyPP service",\r\n                shape: \'rect\',\r\n                timeout: 300\r\n            },{\r\n                selector:\'#btnEasyPP\',\r\n                description: "Click To go to the EasyPP Page",\r\n                event:\'click\',\r\n                showNext: false,\r\n                shape: \'rect\',\r\n                timeout: 300\r\n            },{\r\n                selector:\'#btnCloseEasyPP\',\r\n                description: "Close button",\r\n                showNext: true,\r\n                shape: \'rect\',\r\n                timeout: 300\r\n            },\r\n            {\r\n                selector:\'#btnGetEasyPPLink\',\r\n                description: "Select a profile and get EasyPP link",\r\n                showNext: false,\r\n                shape: \'rect\',\r\n                timeout: 300\r\n            },', NULL, NULL),
(4, 23, 'en-US', 'pending', '	{\r\n                selector:\'#child-card-id-#CARD_ID_#\',\r\n                showNext: true,\r\n                description: "<?php echo Yii::t(\'HelpModule.steps\',  "Description For card"); ?>",\r\n                shape: \'rect\',\r\n                timeout: 100\r\n            }', NULL, NULL),
(5, 32, 'en-US', 'pending', '			{\r\n				selector:\'#child-card-id-#CARD_ID_#\',\r\n                showNext: true,\r\n                description: "Description For card Send Profile Card",\r\n                shape: \'rect\',\r\n                timeout: 100\r\n            }', NULL, NULL),
(6, 31, 'en-US', 'ongoing', '          {\r\n            selector:\'.wall_humhubmodulescardsmodelsCard_#CARD_ID_#\',\r\n            showNext: true,\r\n            description: "With the Enter Company Profile card, you can create and share a profile page",\r\n            shape: \'rect\',\r\n            timeout: 100\r\n        },\r\n                {\r\n            selector:\'#folded-card-id-#CARD_ID_#\',\r\n            event:\'click\',\r\n            showNext: false,\r\n            description: "Unfold the card",\r\n            shape: \'rect\',\r\n            timeout: 100\r\n        }', NULL, NULL);





--
-- Índices para tablas volcadas

--
-- Indices de la tabla `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendar_entry`
--
ALTER TABLE `calendar_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendar_entry_participant`
--
ALTER TABLE `calendar_entry_participant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_entryuser` (`calendar_entry_id`,`user_id`);

--
-- Indices de la tabla `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `space_k_idx` (`space_id`),
  ADD KEY `cards_id_idx` (`card_id`);

--
-- Indices de la tabla `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_cards_1_idx` (`step_id`),
  ADD KEY `fk_cards_1_idx1` (`workflow_id`),
  ADD KEY `card_type_idx` (`card_type_id`),
  ADD KEY `fk_cards_1_idx2` (`related_card`),
  ADD KEY `cards_parent_idx` (`card_parent_id`);

--
-- Indices de la tabla `card_content`
--
ALTER TABLE `card_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uni` (`card_id`,`content_related_id`);

--
-- Indices de la tabla `card_restriction`
--
ALTER TABLE `card_restriction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `card_restriction_id` (`card_restriction_id`),
  ADD KEY `card_restriction_completed_id` (`card_restriction_completed_id`);

--
-- Indices de la tabla `card_type`
--
ALTER TABLE `card_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cfiles_file`
--
ALTER TABLE `cfiles_file`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cfiles_folder`
--
ALTER TABLE `cfiles_folder`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company_card`
--
ALTER TABLE `company_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indices de la tabla `company_contact`
--
ALTER TABLE `company_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company_extra`
--
ALTER TABLE `company_extra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company_space`
--
ALTER TABLE `company_space`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indices de la tabla `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_object_model` (`object_model`,`object_id`),
  ADD UNIQUE KEY `index_guid` (`guid`),
  ADD KEY `fk-contentcontainer` (`contentcontainer_id`),
  ADD KEY `fk-create-user` (`created_by`),
  ADD KEY `fk-update-user` (`updated_by`);

--
-- Indices de la tabla `contentcontainer`
--
ALTER TABLE `contentcontainer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_target` (`class`,`pk`),
  ADD UNIQUE KEY `unique_guid` (`guid`);

--
-- Indices de la tabla `contentcontainer_permission`
--
ALTER TABLE `contentcontainer_permission`
  ADD PRIMARY KEY (`permission_id`,`group_id`,`module_id`,`contentcontainer_id`);

--
-- Indices de la tabla `contentcontainer_setting`
--
ALTER TABLE `contentcontainer_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings-unique` (`module_id`,`contentcontainer_id`,`name`),
  ADD KEY `fk-contentcontainerx` (`contentcontainer_id`);

--
-- Indices de la tabla `custom_pages_container_page`
--
ALTER TABLE `custom_pages_container_page`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_container_snippet`
--
ALTER TABLE `custom_pages_container_snippet`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_page`
--
ALTER TABLE `custom_pages_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom-page-url-unique` (`url`);

--
-- Indices de la tabla `custom_pages_snippet`
--
ALTER TABLE `custom_pages_snippet`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template`
--
ALTER TABLE `custom_pages_template`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tmpl_name` (`name`);

--
-- Indices de la tabla `custom_pages_template_container`
--
ALTER TABLE `custom_pages_template_container`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-template` (`template_id`);

--
-- Indices de la tabla `custom_pages_template_container_content`
--
ALTER TABLE `custom_pages_template_container_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-container-definition` (`definition_id`);

--
-- Indices de la tabla `custom_pages_template_container_content_definition`
--
ALTER TABLE `custom_pages_template_container_content_definition`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template_container_content_item`
--
ALTER TABLE `custom_pages_template_container_content_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-container-item-tmpl` (`template_id`),
  ADD KEY `fk-tmpl-container-item-content` (`container_content_id`);

--
-- Indices de la tabla `custom_pages_template_container_content_template`
--
ALTER TABLE `custom_pages_template_container_content_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-container-tmpl` (`template_id`),
  ADD KEY `fk-tmpl-container-tmpl-definition` (`definition_id`);

--
-- Indices de la tabla `custom_pages_template_element`
--
ALTER TABLE `custom_pages_template_element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-element-tmpl` (`template_id`);

--
-- Indices de la tabla `custom_pages_template_file_content`
--
ALTER TABLE `custom_pages_template_file_content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template_image_content`
--
ALTER TABLE `custom_pages_template_image_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-tmpl-image-definition` (`definition_id`);

--
-- Indices de la tabla `custom_pages_template_image_content_definition`
--
ALTER TABLE `custom_pages_template_image_content_definition`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template_owner_content`
--
ALTER TABLE `custom_pages_template_owner_content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template_richtext_content`
--
ALTER TABLE `custom_pages_template_richtext_content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_pages_template_text_content`
--
ALTER TABLE `custom_pages_template_text_content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enterprise_ldap_group`
--
ALTER TABLE `enterprise_ldap_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-ldapgroup-group` (`group_id`);

--
-- Indices de la tabla `enterprise_ldap_space`
--
ALTER TABLE `enterprise_ldap_space`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-ldapspace-space` (`space_id`);

--
-- Indices de la tabla `extra_data_user`
--
ALTER TABLE `extra_data_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user_idx` (`user_id`),
  ADD KEY `fk-source_idx` (`source_type_id`);

--
-- Indices de la tabla `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_object` (`object_model`,`object_id`);

--
-- Indices de la tabla `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `group_permission`
--
ALTER TABLE `group_permission`
  ADD PRIMARY KEY (`permission_id`,`group_id`,`module_id`);

--
-- Indices de la tabla `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-group_user` (`user_id`,`group_id`),
  ADD KEY `fk-group-group` (`group_id`);

--
-- Indices de la tabla `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_object` (`object_model`,`object_id`);

--
-- Indices de la tabla `linklist_category`
--
ALTER TABLE `linklist_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `linklist_link`
--
ALTER TABLE `linklist_link`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_log_level` (`level`),
  ADD KEY `idx_log_category` (`category`);

--
-- Indices de la tabla `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_updated` (`updated_at`),
  ADD KEY `index_updated_by` (`updated_by`);

--
-- Indices de la tabla `message_entry`
--
ALTER TABLE `message_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_user_id` (`user_id`),
  ADD KEY `index_message_id` (`message_id`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `module_enabled`
--
ALTER TABLE `module_enabled`
  ADD PRIMARY KEY (`module_id`);

--
-- Indices de la tabla `nda_agreement`
--
ALTER TABLE `nda_agreement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nda_model_id` (`nda_model_id`),
  ADD KEY `space_id` (`space_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `nda_model`
--
ALTER TABLE `nda_model`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nda_model_chose`
--
ALTER TABLE `nda_model_chose`
  ADD PRIMARY KEY (`id`),
  ADD KEY `space_id` (`space_id`),
  ADD KEY `model_id` (`nda_model_id`);

--
-- Indices de la tabla `nda_model_obligatory`
--
ALTER TABLE `nda_model_obligatory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indices de la tabla `nir_related`
--
ALTER TABLE `nir_related`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nir_related_1_idx` (`id_space_pre_nir`,`id_space_nir`),
  ADD KEY `fk_nir_related_2_idx` (`id_space_nir`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_user_id` (`user_id`),
  ADD KEY `index_seen` (`seen`),
  ADD KEY `index_desktop_notified` (`desktop_notified`),
  ADD KEY `index_desktop_emailed` (`emailed`),
  ADD KEY `index_groupuser` (`user_id`,`class`,`group_key`);

--
-- Indices de la tabla `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `poll_answer`
--
ALTER TABLE `poll_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `poll_answer_user`
--
ALTER TABLE `poll_answer_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `profile_field`
--
ALTER TABLE `profile_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_profile_field_category` (`profile_field_category_id`);

--
-- Indices de la tabla `profile_field_category`
--
ALTER TABLE `profile_field_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unique-setting` (`name`,`module_id`);

--
-- Indices de la tabla `source_type`
--
ALTER TABLE `source_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `space`
--
ALTER TABLE `space`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url-unique` (`url`);

--
-- Indices de la tabla `space_membership`
--
ALTER TABLE `space_membership`
  ADD PRIMARY KEY (`space_id`,`user_id`),
  ADD KEY `index_status` (`status`);

--
-- Indices de la tabla `space_module`
--
ALTER TABLE `space_module`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `space_type`
--
ALTER TABLE `space_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `space_type_relationship`
--
ALTER TABLE `space_type_relationship`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `space_user_role`
--
ALTER TABLE `space_user_role`
  ADD PRIMARY KEY (`space_id`,`user_id`,`user_role_id`),
  ADD UNIQUE KEY `pk` (`space_id`,`user_id`,`user_role_id`),
  ADD KEY `fk_space_user_role_2_idx` (`user_id`),
  ADD KEY `fk_space_user_role_3_idx` (`user_role_id`);

--
-- Indices de la tabla `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_id` (`workflow_id`);

--
-- Indices de la tabla `step_user_space`
--
ALTER TABLE `step_user_space`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `task_user`
--
ALTER TABLE `task_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `url_oembed`
--
ALTER TABLE `url_oembed`
  ADD PRIMARY KEY (`url`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_guid` (`guid`),
  ADD UNIQUE KEY `unique_wall_id` (`wall_id`);

--
-- Indices de la tabla `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indices de la tabla `user_card`
--
ALTER TABLE `user_card`
  ADD PRIMARY KEY (`user_id`,`card_id`),
  ADD KEY `card_id` (`card_id`) USING BTREE,
  ADD KEY `pk_uc` (`card_id`,`user_id`);

--
-- Indices de la tabla `user_follow`
--
ALTER TABLE `user_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_user` (`user_id`),
  ADD KEY `index_object` (`object_model`,`object_id`);

--
-- Indices de la tabla `user_friendship`
--
ALTER TABLE `user_friendship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-friends` (`user_id`,`friend_user_id`),
  ADD KEY `fk-friend` (`friend_user_id`);

--
-- Indices de la tabla `user_http_session`
--
ALTER TABLE `user_http_session`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_invite`
--
ALTER TABLE `user_invite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_token` (`token`);

--
-- Indices de la tabla `user_invite_group`
--
ALTER TABLE `user_invite_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user-invite` (`user_invite_id`),
  ADD KEY `fk-group` (`group_id`);

--
-- Indices de la tabla `user_mentioning`
--
ALTER TABLE `user_mentioning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_user` (`user_id`),
  ADD KEY `i_object` (`object_model`,`object_id`);

--
-- Indices de la tabla `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`message_id`,`user_id`),
  ADD KEY `index_last_viewed` (`last_viewed`);

--
-- Indices de la tabla `user_module`
--
ALTER TABLE `user_module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_user_module` (`user_id`,`module_id`);

--
-- Indices de la tabla `user_password`
--
ALTER TABLE `user_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indices de la tabla `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `user_role_workflow`
--
ALTER TABLE `user_role_workflow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `wall`
--
ALTER TABLE `wall`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wall_entry`
--
ALTER TABLE `wall_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wiki_page`
--
ALTER TABLE `wiki_page`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wiki_page_revision`
--
ALTER TABLE `wiki_page_revision`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `workflow`
--
ALTER TABLE `workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `workflow_space_type`
--
ALTER TABLE `workflow_space_type`
  ADD KEY `p_k` (`workflow_id`,`space_type_id`),
  ADD KEY `fk_workflow_space_type_1_idx` (`space_type_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calendar_entry`
--
ALTER TABLE `calendar_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calendar_entry_participant`
--
ALTER TABLE `calendar_entry_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4362;
--
-- AUTO_INCREMENT de la tabla `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT de la tabla `card_content`
--
ALTER TABLE `card_content`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `card_restriction`
--
ALTER TABLE `card_restriction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `card_type`
--
ALTER TABLE `card_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `cfiles_file`
--
ALTER TABLE `cfiles_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cfiles_folder`
--
ALTER TABLE `cfiles_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `company_card`
--
ALTER TABLE `company_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `company_contact`
--
ALTER TABLE `company_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `company_space`
--
ALTER TABLE `company_space`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `contentcontainer`
--
ALTER TABLE `contentcontainer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT de la tabla `contentcontainer_setting`
--
ALTER TABLE `contentcontainer_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `custom_pages_container_page`
--
ALTER TABLE `custom_pages_container_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_container_snippet`
--
ALTER TABLE `custom_pages_container_snippet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_page`
--
ALTER TABLE `custom_pages_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_snippet`
--
ALTER TABLE `custom_pages_snippet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template`
--
ALTER TABLE `custom_pages_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_container`
--
ALTER TABLE `custom_pages_template_container`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_container_content`
--
ALTER TABLE `custom_pages_template_container_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_container_content_definition`
--
ALTER TABLE `custom_pages_template_container_content_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_container_content_item`
--
ALTER TABLE `custom_pages_template_container_content_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_container_content_template`
--
ALTER TABLE `custom_pages_template_container_content_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_element`
--
ALTER TABLE `custom_pages_template_element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_file_content`
--
ALTER TABLE `custom_pages_template_file_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_image_content`
--
ALTER TABLE `custom_pages_template_image_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_image_content_definition`
--
ALTER TABLE `custom_pages_template_image_content_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_owner_content`
--
ALTER TABLE `custom_pages_template_owner_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_richtext_content`
--
ALTER TABLE `custom_pages_template_richtext_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `custom_pages_template_text_content`
--
ALTER TABLE `custom_pages_template_text_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `enterprise_ldap_group`
--
ALTER TABLE `enterprise_ldap_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `enterprise_ldap_space`
--
ALTER TABLE `enterprise_ldap_space`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `extra_data_user`
--
ALTER TABLE `extra_data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `group_user`
--
ALTER TABLE `group_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de la tabla `like`
--
ALTER TABLE `like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `linklist_category`
--
ALTER TABLE `linklist_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `linklist_link`
--
ALTER TABLE `linklist_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `message_entry`
--
ALTER TABLE `message_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nda_agreement`
--
ALTER TABLE `nda_agreement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nda_model`
--
ALTER TABLE `nda_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `nda_model_chose`
--
ALTER TABLE `nda_model_chose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nda_model_obligatory`
--
ALTER TABLE `nda_model_obligatory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `nir_related`
--
ALTER TABLE `nir_related`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `poll_answer`
--
ALTER TABLE `poll_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `poll_answer_user`
--
ALTER TABLE `poll_answer_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `profile_field`
--
ALTER TABLE `profile_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `profile_field_category`
--
ALTER TABLE `profile_field_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT de la tabla `source_type`
--
ALTER TABLE `source_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `space`
--
ALTER TABLE `space`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT de la tabla `space_module`
--
ALTER TABLE `space_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `space_type`
--
ALTER TABLE `space_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `space_type_relationship`
--
ALTER TABLE `space_type_relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `step`
--
ALTER TABLE `step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `step_user_space`
--
ALTER TABLE `step_user_space`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2389;
--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `task_user`
--
ALTER TABLE `task_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT de la tabla `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user_follow`
--
ALTER TABLE `user_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user_friendship`
--
ALTER TABLE `user_friendship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user_invite`
--
ALTER TABLE `user_invite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `user_invite_group`
--
ALTER TABLE `user_invite_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user_mentioning`
--
ALTER TABLE `user_mentioning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user_module`
--
ALTER TABLE `user_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user_password`
--
ALTER TABLE `user_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `wall`
--
ALTER TABLE `wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT de la tabla `wall_entry`
--
ALTER TABLE `wall_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5606;
--
-- AUTO_INCREMENT de la tabla `wiki_page`
--
ALTER TABLE `wiki_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `wiki_page_revision`
--
ALTER TABLE `wiki_page_revision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `cards_id` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `space_k` FOREIGN KEY (`space_id`) REFERENCES `space` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `card_type` FOREIGN KEY (`card_type_id`) REFERENCES `card_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cards_parent` FOREIGN KEY (`card_parent_id`) REFERENCES `cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cards_related` FOREIGN KEY (`related_card`) REFERENCES `cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `step_id` FOREIGN KEY (`step_id`) REFERENCES `step` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `w_id` FOREIGN KEY (`workflow_id`) REFERENCES `workflow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `work_id` FOREIGN KEY (`workflow_id`) REFERENCES `workflow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `card_content`
--
ALTER TABLE `card_content`
  ADD CONSTRAINT `fk_card_content_1` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `card_restriction`
--
ALTER TABLE `card_restriction`
  ADD CONSTRAINT `card_restriction_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`),
  ADD CONSTRAINT `card_restriction_ibfk_2` FOREIGN KEY (`card_restriction_id`) REFERENCES `cards` (`id`),
  ADD CONSTRAINT `card_restriction_ibfk_3` FOREIGN KEY (`card_restriction_completed_id`) REFERENCES `cards` (`id`);

--
-- Filtros para la tabla `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `fk-contentcontainer` FOREIGN KEY (`contentcontainer_id`) REFERENCES `contentcontainer` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk-create-user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk-update-user` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `contentcontainer_setting`
--
ALTER TABLE `contentcontainer_setting`
  ADD CONSTRAINT `fk-contentcontainerx` FOREIGN KEY (`contentcontainer_id`) REFERENCES `contentcontainer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_container`
--
ALTER TABLE `custom_pages_template_container`
  ADD CONSTRAINT `fk-tmpl-template` FOREIGN KEY (`template_id`) REFERENCES `custom_pages_template` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_container_content`
--
ALTER TABLE `custom_pages_template_container_content`
  ADD CONSTRAINT `fk-tmpl-container-definition` FOREIGN KEY (`definition_id`) REFERENCES `custom_pages_template_container_content_definition` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_container_content_item`
--
ALTER TABLE `custom_pages_template_container_content_item`
  ADD CONSTRAINT `fk-tmpl-container-item-content` FOREIGN KEY (`container_content_id`) REFERENCES `custom_pages_template_container_content` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-tmpl-container-item-tmpl` FOREIGN KEY (`template_id`) REFERENCES `custom_pages_template` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_container_content_template`
--
ALTER TABLE `custom_pages_template_container_content_template`
  ADD CONSTRAINT `fk-tmpl-container-tmpl` FOREIGN KEY (`template_id`) REFERENCES `custom_pages_template` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-tmpl-container-tmpl-definition` FOREIGN KEY (`definition_id`) REFERENCES `custom_pages_template_container_content_definition` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_element`
--
ALTER TABLE `custom_pages_template_element`
  ADD CONSTRAINT `fk-tmpl-element-tmpl` FOREIGN KEY (`template_id`) REFERENCES `custom_pages_template` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `custom_pages_template_image_content`
--
ALTER TABLE `custom_pages_template_image_content`
  ADD CONSTRAINT `fk-tmpl-image-definition` FOREIGN KEY (`definition_id`) REFERENCES `custom_pages_template_image_content_definition` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `enterprise_ldap_group`
--
ALTER TABLE `enterprise_ldap_group`
  ADD CONSTRAINT `fk-ldapgroup-group` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `enterprise_ldap_space`
--
ALTER TABLE `enterprise_ldap_space`
  ADD CONSTRAINT `fk-ldapspace-space` FOREIGN KEY (`space_id`) REFERENCES `space` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `extra_data_user`
--
ALTER TABLE `extra_data_user`
  ADD CONSTRAINT `fk-source-type` FOREIGN KEY (`source_type_id`) REFERENCES `source_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-user-extra` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `fk-group-group` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-user-group` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nda_model_obligatory`
--
ALTER TABLE `nda_model_obligatory`
  ADD CONSTRAINT `nda_model_obligatory_ibfk_2` FOREIGN KEY (`space_id`) REFERENCES `space` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nir_related`
--
ALTER TABLE `nir_related`
  ADD CONSTRAINT `fk_nir_related_1` FOREIGN KEY (`id_space_pre_nir`) REFERENCES `space` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nir_related_2` FOREIGN KEY (`id_space_nir`) REFERENCES `space` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `space_user_role`
--
ALTER TABLE `space_user_role`
  ADD CONSTRAINT `fk_space_user_role_1` FOREIGN KEY (`space_id`) REFERENCES `space` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_space_user_role_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_space_user_role_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `step_user_space`
--
ALTER TABLE `step_user_space`
  ADD CONSTRAINT `step_user_space_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `step_user_space_ibfk_3` FOREIGN KEY (`space_id`) REFERENCES `space` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `step_user_space_ibfk_4` FOREIGN KEY (`step_id`) REFERENCES `step` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_card`
--
ALTER TABLE `user_card`
  ADD CONSTRAINT `fk_user_card_id` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_friendship`
--
ALTER TABLE `user_friendship`
  ADD CONSTRAINT `fk-friend` FOREIGN KEY (`friend_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_invite_group`
--
ALTER TABLE `user_invite_group`
  ADD CONSTRAINT `fk-group` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk-user-invite` FOREIGN KEY (`user_invite_id`) REFERENCES `user_invite` (`id`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `workflow_space_type`
--
ALTER TABLE `workflow_space_type`
  ADD CONSTRAINT `fk_workflow_space_type_1` FOREIGN KEY (`space_type_id`) REFERENCES `space_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_workflow_space_type_2` FOREIGN KEY (`workflow_id`) REFERENCES `workflow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;



ALTER TABLE `user_interactive_tutorial_state`
  ADD CONSTRAINT `fk-user-tutorial` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

  --
-- Filtros para la tabla `cards_interactive_tutorial_state`
--
ALTER TABLE `cards_interactive_tutorial_state`
  ADD CONSTRAINT `fk-cards_id-tutorial` FOREIGN KEY (`cards_id`) REFERENCES `cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
