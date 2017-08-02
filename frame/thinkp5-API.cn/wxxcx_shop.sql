
###轮播图表
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner`(
`id` INT(11) not null auto_increment,
`name` varchar(50) not null DEFAULT '' COMMENT 'banner名称,通常作为标示',
`description` varchar(255) DEFAULT '' COMMENT 'banner描述',
`delete_time` int(11) DEFAULT 0 ,
`update_time` int(11) DEFAULT 0 ,
PRIMARY KEY(`id`)
)ENGINE = INNODB auto_increment = 2 DEFAULT CHARSET = utf8mb4 COMMENT = 'banner管理表'

###轮播图详情
drop table if exists `banner_item`;
create table `banner_item`(
`id` int(11) not null auto_increment,
`img_id` int(11) not null COMMENT '外键,关联image表',
`key_word` varchar(100) not null DEFAULT '' COMMENT '执行关键字，根据不同的type含义不同',
`type` TINYINT(4) not null DEFAULT 1 COMMENT '跳转类型，1-商品，2-专题',
`banner_id` int(11) not null COMMENT '外键，关联banner表',
`delete_time` int(11) DEFAULT 0,
`update_time` int(11) not null DEFAULT 0 ,
 PRIMARY KEY(`id`)
)ENGINE = INNODB auto_increment = 6 DEFAULT CHARSET = utf8mb4 COMMENT = 'banner子项表';

###图片表
drop table if EXISTS `image`;
create table `image`(
`id` int not null auto_increment,
`url` varchar(50) not null DEFAULT '' COMMENT '图片地址',
`from` TINYINT not null DEFAULT 1 COMMENT '图片来源',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
 `update_time` int not null DEFAULT 0 COMMENT '创建时间',
PRIMARY KEY(`id`)
)ENGINE = INNODB DEFAULT CHARSET = utf8mb4 COMMENT '图片表';

###商品主题表
drop table if EXISTS `theme`;
create table `theme`(
`id` int not null auto_increment,
`name` VARCHAR(15) not null DEFAULT '' COMMENT '主题名称',
`description` VARCHAR(150) not null DEFAULT '' COMMENT '主题描述',
`topic_img_id` int not null  DEFAULT 0 COMMENT '关联图片表外键',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
PRIMARY KEY(`id`)
)ENGINE = InNODB DEFAULT CHARSET = utf8mb4 COMMENT '商品主题表';

ALTER table `theme` add COLUMN `head_img_id` int not null DEFAULT 0 COMMENT '关联图片表主题标题图片id' after topic_img_id

###theme和product中转表
drop table if exists `theme_product`;
create table `theme_product`(
`theme_id` int not null DEFAULT 0 COMMENT 'theme表id',
`product_id` int not null DEFAULT 0 COMMENT '商品表id',
PRIMARY KEY (`theme_id`)
) engine = INNODB DEFAULT CHARSET = utf8mb4 COMMENT 'theme和product中转表（多对多关系）'

###商品表
drop table if exists `product`;
create table `product`(
`id` int not null auto_increment,
`name` varchar(50) not null DEFAULT '' COMMENT '商品名称',
`peice` DECIMAL not null DEFAULT 0 COMMENT '商品价格',
`stock` int not null DEFAULT 0 COMMENT '商品库存',
`category_id` int not null DEFAULT 0 COMMENT '外键分类id',
`main_img_id` int not null DEFAULT 0 COMMENT '外键图片表id',
`from` TINYINT not null DEFAULT 1 COMMENT '来源 1-本地 2-外地',
`summary` int not null DEFAULT 0 COMMENT '',
`img_id` int not null DEFAULT 0 COMMENT '外键图片id',
`create_time` int not null DEFAULT 0 COMMENT '创建时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
PRIMARY KEY (`id`)
) engine = INNODB DEFAULT CHARSET = utf8mb4 COMMENT 'theme和product中转表（多对多关系）'

###分类表
drop table if exists `category`;
create table `category`(
`id` int not null auto_increment,
`name` varchar(15) not null DEFAULT '' COMMENT '分类名称',
`topic_img_id` int not null DEFAULT 0 COMMENT '外键关联图片表',
`description` VARCHAR(150) not null DEFAULT '' COMMENT '描述',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
PRIMARY KEY(`id`)
)ENGINE = INNODB DEFAULT CHARSET = utf8mb4 COMMENT '分类表';

###用户表
drop table if exists `user`;
create table `user` (
`id` int auto_increment,
`openid` varchar(50) not null DEFAULT '' COMMENT '用户openid',
`nickname` varchar(50) not null DEFAULT '' COMMENT '昵称',
`extend` varchar(50) not null DEFAULT '' COMMENT '',
`create_time` int not null DEFAULT 0 COMMENT '创建时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
PRIMARY KEY(`id`)
)engine = INNODB DEFAULT charset = utf8mb4 COMMENT '用户表';

###商品详情图片表
drop table if exists product_image;
create table `product_image`(
id int auto_increment ,
`img_id` int not null DEFAULT 0 COMMENT '外键图片id',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
`order` int not null DEFAULT 0 COMMENT '外键订单号',
`product_id` int not null DEFAULT 0 COMMENT '外键商品id' ,
PRIMARY KEY(id)
) ENGINE = innodb DEFAULT charset = utf8mb4 COMMENT '商品详情图片';

###商品属性表
drop table if exists  product_property;
create table product_property (
`id` int auto_increment ,
`name` varchar(50) not null DEFAULT '' COMMENT '属性名称',
`detail` varchar(200) not null DEFAULT '' COMMENT '属性描述',
`product_id` int not null DEFAULT 0 COMMENT '外键-商品表',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
PRIMARY KEY(`id`)
) engine INNODB DEFAULT charset = utf8mb4 COMMENT '商品属性表';

###用户地址表
drop table if EXISTS user_address;
create table user_address (
`id` int auto_increment,
`name` varchar(50) not null DEFAULT '' COMMENT '地址名称',
`mobile` varchar(11) not null DEFAULT '' COMMENT '手机号码',
`provice` varchar(15) not null DEFAULT '' COMMENT '省',
`city` varchar(15) not null DEFAULT '' COMMENT '市',
`country` varchar(15) not null DEFAULT '' COMMENT '区',
`detail` varchar(100) not null DEFAULT '' COMMENT '描述',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
PRIMARY KEY(`id`)
)engine = innodb DEFAULT charset = utf8mb4 COMMENT '用户地址表';

alter table `user_address` add COLUMN `user_id` int not null DEFAULT 0 COMMENT '外键-user表' AFTER detail;

###订单表
drop table if EXISTS `order`;
CREATE table `order` (
`id` int auto_increment,
`order_no` int not null DEFAULT 0 COMMENT '订单号',
`user_id` int not null DEFAULT 0 COMMENT '外键ID',
`total_price` int not null DEFAULT 0 COMMENT '总价格',
`status` tinyint not null DEFAULT 0 COMMENT '订单状态',
`snap_name` varchar(50) not null DEFAULT '' COMMENT '收货人姓名',
`snap_img` varchar(50) not null DEFAULT 0 COMMENT '',
`snap_address` varchar(100) not null DEFAULT 0 COMMENT '收货地址',
`prepay_id` int not null DEFAULT 0 COMMENT '',
`total_count` int not null DEFAULT 0 COMMENT '',
`create_time` int not null DEFAULT 0 COMMENT '创建时间',
`update_time` int not null DEFAULT 0 COMMENT '更新时间',
`delete_time` int not null DEFAULT 0 COMMENT '删除时间',
primary key(`id`)
)ENGINE = INNODB DEFAULT charset = utf8mb4 COMMENT '订单表';

###订单商品表
drop table if exists `order_product`;
CREATE TABLE `order_product`  (
  `order_id` int(0) AUTO_INCREMENT,
  `product_id` int(0) NOT NULL DEFAULT 0 COMMENT '外键商品表ID',
  `count` int(0) NOT NULL COMMENT '数量',
  `delete_time` int(0) NOT NULL COMMENT '删除时间',
  `update_time` int(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`order_id`)
) ENGINE = InnoDB CHARACTER SET = utf8mb4;