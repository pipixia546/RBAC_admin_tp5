/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : myadmin

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-06-27 15:52:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_role`
-- ----------------------------
DROP TABLE IF EXISTS `tp_role`;
CREATE TABLE `tp_role` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `rule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_role
-- ----------------------------
INSERT INTO `tp_role` VALUES ('1', '超级管理员', ',1,2,3,4,5,6,8,7,9,10');
INSERT INTO `tp_role` VALUES ('6', '测试管理员', ',1,2,3,4,7');

-- ----------------------------
-- Table structure for `tp_rule`
-- ----------------------------
DROP TABLE IF EXISTS `tp_rule`;
CREATE TABLE `tp_rule` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `is_menu` int(1) DEFAULT '1' COMMENT '1代表是；2代表不是',
  `level_id` int(1) DEFAULT '0' COMMENT '父级id',
  `style` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_rule
-- ----------------------------
INSERT INTO `tp_rule` VALUES ('1', '后台首页', '/admin/Common/main', '1', '0', null);
INSERT INTO `tp_rule` VALUES ('2', '管理员', '', '1', '0', null);
INSERT INTO `tp_rule` VALUES ('3', '管理员管理', '/admin/User/index', '1', '2', null);
INSERT INTO `tp_rule` VALUES ('4', '角色管理', '/admin/User/rule', '1', '2', null);
INSERT INTO `tp_rule` VALUES ('5', '添加管理员', '/admin/User/add', '0', '2', null);
INSERT INTO `tp_rule` VALUES ('6', '权限管理', '/admin/User/edit_role', '0', '2', null);
INSERT INTO `tp_rule` VALUES ('7', '', '/admin/Index/index', null, null, null);
INSERT INTO `tp_rule` VALUES ('8', '添加角色', '/admin/User/add_role', '0', '2', null);
INSERT INTO `tp_rule` VALUES ('9', '删除角色', '/admin/User/del_role', '0', '2', null);
INSERT INTO `tp_rule` VALUES ('10', '删除管理员', '/admin/User/del_user', '0', '2', null);

-- ----------------------------
-- Table structure for `tp_useradmin`
-- ----------------------------
DROP TABLE IF EXISTS `tp_useradmin`;
CREATE TABLE `tp_useradmin` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `login_time` int(5) NOT NULL DEFAULT '0',
  `login_ip` varchar(20) NOT NULL,
  `role_id` int(2) NOT NULL,
  `addtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_useradmin
-- ----------------------------
INSERT INTO `tp_useradmin` VALUES ('6', 'admin', 'ac6a06cc44d5180a1c243a2a541b10b0', '7', '127.0.0.1', '1', '1530084129');
INSERT INTO `tp_useradmin` VALUES ('3', 'admin365', '116e4903b7a68143e221bc484c0ad2a0', '0', '', '7', '0');
INSERT INTO `tp_useradmin` VALUES ('4', 'admindasd', '21232f297a57a5a743894a0e4a801fc3', '0', '', '7', '0');
