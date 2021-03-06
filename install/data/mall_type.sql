DROP TABLE IF EXISTS `np_mall_type`;
CREATE TABLE IF NOT EXISTS `np_mall_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL COMMENT '分类名',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `pid` (`pid`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城分类表';


DROP TABLE IF EXISTS `np_mall_brand`;
CREATE TABLE IF NOT EXISTS `np_mall_brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '品牌名',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT 'LOGO',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城品牌表';