/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  viktor
 * Created: Oct 5, 2020
 */

DROP TABLE IF EXISTS users;
CREATE TABLE users
    -> (
    ->  id                         smallint unsigned NOT NULL auto_increment COMMENT 'ID пользователя',
    ->  whenRegistred              date NOT NULL COMMENT 'Когда пользователь зарегестрирован',
    ->  login VARCHAR(50)          NOT NULL COMMENT 'Логин пользователя',
    ->  password VARCHAR(50)       NOT NULL COMMENT 'Пароль пользователя',
    ->  activeUser TINYINT(1)      NOT NULL DEFAULT '0' COMMENT 'Разрешение на авторизацию 0 доступ запрещен 1 доступ разрешен',
    ->  
    ->  PRIMARY KEY                (id),
    ->  UNIQUE INDEX               login (login)
    -> )
    -> COMMENT 'Таблица для хранения паролей и логинов пользователей';

