
--
-- Database: `assign2` and php web application user
CREATE DATABASE assign2;
GRANT USAGE ON *.* TO 'root'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON assign2.* TO 'root'@'localhost';
FLUSH PRIVILEGES;

USE assign2;
--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `birthDate` DATE NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `birthDate`, `image`) VALUES
(1, 'Jack', '2010-03-30','Jack.jpg'),
(2, 'Andy', '2014-07-08', 'Andy.jpg'),
(3, 'Maria', '2016-10-12', 'Maria.jpg');
