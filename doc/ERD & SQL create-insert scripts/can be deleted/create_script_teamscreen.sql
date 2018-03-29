-- ---------------------------------------
-- create script for teamscreen application database
-- ------------------------------------------

-- mysql workbench forward engineering

set @old_unique_checks=@@unique_checks, unique_checks=0;
set @old_foreign_key_checks=@@foreign_key_checks, foreign_key_checks=0;
set @old_sql_mode=@@sql_mode, sql_mode='traditional,allow_invalid_dates';

-- -----------------------------------------------------
-- schema teamscreen
-- -----------------------------------------------------
drop database if exists `teamscreen` ;

-- -----------------------------------------------------
-- schema teamscreen
-- -----------------------------------------------------
create database if not exists `teamscreen` default character set utf8 ;
use `teamscreen` ;

-- -----------------------------------------------------
-- table `teamscreen`.`team`
-- -----------------------------------------------------
drop table if exists `teamscreen`.`team` ;

create table if not exists `teamscreen`.`team` (
  `id` int not null auto_increment,
  `label` varchar(45) null,
  primary key (`id`))
engine = innodb;


-- -----------------------------------------------------
-- table `teamscreen`.`member`
-- -----------------------------------------------------
drop table if exists `teamscreen`.`member` ;

create table if not exists `teamscreen`.`member` (
  `id` int not null auto_increment,
  `name` varchar(45) null,
  `username` varchar(45) null,
  `destination` varchar(45) null,
  `drink_preference` enum('coffee', 'tea', 'water') null,
  `working_days` set('monday', 'tuesday', 'wednesday', 'thursday', 'friday') null,
  `team_id` int null,
  primary key (`id`),
  index `fk_member_team_idx` (`team_id` asc),
  constraint `fk_member_team`
    foreign key (`team_id`)
    references `teamscreen`.`team` (`id`)
    on delete cascade
    on update cascade)
engine = innodb;


-- -----------------------------------------------------
-- table `teamscreen`.`timeoff`
-- -----------------------------------------------------
drop table if exists `teamscreen`.`time_off` ;

create table if not exists `teamscreen`.`time_off` (
  `id` int not null auto_increment,
  `start_time` datetime null,
  `end_time` datetime null,
  `member_id` int not null,
  primary key (`id`),
  index `fk_time_off_member_idx` (`member_id` asc),
  constraint `fk_time_off_member`
    foreign key (`member_id`)
    references `teamscreen`.`member` (`id`)
    on delete cascade
    on update cascade)
engine = innodb;


set sql_mode=@old_sql_mode;
set foreign_key_checks=@old_foreign_key_checks;
set unique_checks=@old_unique_checks;
