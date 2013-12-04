CREATE DATABASE IF NOT EXISTS `auction` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `auction`;

-- --------------------------------------------------------

--
-- Table structure for table `auction_prices`
--

CREATE TABLE IF NOT EXISTS `auction_prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE IF NOT EXISTS `auctions` (
  `auction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `minimum_price` int(11) NOT NULL,
  `date_end` int(11) NOT NULL,
  `action_title` varchar(250) NOT NULL,
  `auction_desc` text NOT NULL,
  PRIMARY KEY (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `password` varchar(40) NOT NULL,
  `date_registered` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `date_registered`) VALUES
(1, 'test@test.com', '4de4d95fc854e7883bec112a191c867c0678ca42', 1386144335);
