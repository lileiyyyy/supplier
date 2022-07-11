/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : yii2basic

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-07-11 17:08:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `code` char(3) CHARACTER SET ascii DEFAULT NULL,
  `t_status` enum('ok','hold') CHARACTER SET ascii NOT NULL DEFAULT 'ok',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('1', 'test_name_1', 'C1', 'hold');
INSERT INTO `supplier` VALUES ('2', 'test_name_2', 'C2', 'hold');
INSERT INTO `supplier` VALUES ('3', 'test_name_3', 'C3', 'ok');
INSERT INTO `supplier` VALUES ('4', 'test_name_4', 'C4', 'ok');
INSERT INTO `supplier` VALUES ('5', 'test_name_5', 'C5', 'hold');
INSERT INTO `supplier` VALUES ('6', 'test_name_6', 'C6', 'ok');
INSERT INTO `supplier` VALUES ('7', 'test_name_7', 'C7', 'hold');
INSERT INTO `supplier` VALUES ('8', 'test_name_8', 'C8', 'hold');
INSERT INTO `supplier` VALUES ('9', 'test_name_9', 'C9', 'hold');
INSERT INTO `supplier` VALUES ('10', 'test_name_10', 'C10', 'ok');
INSERT INTO `supplier` VALUES ('11', 'test_name_11', 'C11', 'hold');
INSERT INTO `supplier` VALUES ('12', 'test_name_12', 'C12', 'hold');
INSERT INTO `supplier` VALUES ('13', 'test_name_13', 'C13', 'ok');
INSERT INTO `supplier` VALUES ('14', 'test_name_14', 'C14', 'ok');
INSERT INTO `supplier` VALUES ('15', 'test_name_15', 'C15', 'ok');
INSERT INTO `supplier` VALUES ('16', 'test_name_16', 'C16', 'hold');
INSERT INTO `supplier` VALUES ('17', 'test_name_17', 'C17', 'hold');
INSERT INTO `supplier` VALUES ('18', 'test_name_18', 'C18', 'ok');
INSERT INTO `supplier` VALUES ('19', 'test_name_19', 'C19', 'ok');
INSERT INTO `supplier` VALUES ('20', 'test_name_20', 'C20', 'hold');
INSERT INTO `supplier` VALUES ('21', 'test_name_21', 'C21', 'hold');
INSERT INTO `supplier` VALUES ('22', 'test_name_22', 'C22', 'ok');
INSERT INTO `supplier` VALUES ('23', 'test_name_23', 'C23', 'hold');
INSERT INTO `supplier` VALUES ('24', 'test_name_24', 'C24', 'ok');
INSERT INTO `supplier` VALUES ('25', 'test_name_25', 'C25', 'ok');
INSERT INTO `supplier` VALUES ('26', 'test_name_26', 'C26', 'hold');
INSERT INTO `supplier` VALUES ('27', 'test_name_27', 'C27', 'ok');
INSERT INTO `supplier` VALUES ('28', 'test_name_28', 'C28', 'hold');
INSERT INTO `supplier` VALUES ('29', 'test_name_29', 'C29', 'ok');
INSERT INTO `supplier` VALUES ('30', 'test_name_30', 'C30', 'hold');
INSERT INTO `supplier` VALUES ('31', 'test_name_31', 'C31', 'ok');
INSERT INTO `supplier` VALUES ('32', 'test_name_32', 'C32', 'hold');
INSERT INTO `supplier` VALUES ('33', 'test_name_33', 'C33', 'ok');
INSERT INTO `supplier` VALUES ('34', 'test_name_34', 'C34', 'ok');
INSERT INTO `supplier` VALUES ('35', 'test_name_35', 'C35', 'hold');
INSERT INTO `supplier` VALUES ('36', 'test_name_36', 'C36', 'ok');
INSERT INTO `supplier` VALUES ('37', 'test_name_37', 'C37', 'hold');
INSERT INTO `supplier` VALUES ('38', 'test_name_38', 'C38', 'ok');
INSERT INTO `supplier` VALUES ('39', 'test_name_39', 'C39', 'ok');
INSERT INTO `supplier` VALUES ('40', 'test_name_40', 'C40', 'hold');
SET FOREIGN_KEY_CHECKS=1;
