/*
Navicat MySQL Data Transfer
Date: 2017-04-20 11:45:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jan_goods
-- ----------------------------
DROP TABLE IF EXISTS `jan_goods`;
CREATE TABLE `jan_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jan_goods
-- ----------------------------
INSERT INTO `jan_goods` VALUES ('1', '苹果');
INSERT INTO `jan_goods` VALUES ('2', '梨');
INSERT INTO `jan_goods` VALUES ('3', '香蕉');
