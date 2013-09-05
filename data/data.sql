SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `example`
-- ----------------------------
DROP TABLE IF EXISTS `example`;
CREATE TABLE `example` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of example
-- ----------------------------
INSERT INTO `example` VALUES ('2', 'title 2', 'desc 2');
