/**
 * Author:  viktor
 * Created: Sep 19, 2020
 */
/**
* Добавление поля active в таблицу статей
*/
 ALTER TABLE articles /* Выбираем таблицу для вставки поля active */
 ADD active TINYINT(0) NOT NULL 
 DEFAULT 1 /* Значение по умолчанию */
 COMMENT "Поле active в таблицу статей, по умолчанию 1 т.е. активна";
