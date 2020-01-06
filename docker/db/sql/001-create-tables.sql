---- Create TitleTable ----
CREATE DATABASE IF NOT EXISTS keijiban_db;
DROP TABLE IF EXISTS title_table;
create table title_table
(
 id		INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 title_id	BIGINT(15),
 title		VARCHAR(200),
 last_com	DATETIME,
 total_com	INT(4)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- Create CommentTable1 ----
CREATE DATABASE IF NOT EXISTS keijiban_db;
DROP TABLE IF EXISTS 201909231357;
create table 201909231357
(
 id INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 title		VARCHAR(100),
 user		VARCHAR(100),
 comment	TEXT,
 date_com	DATETIME
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- Create CommentTable2 ----
CREATE DATABASE IF NOT EXISTS keijiban_db;
DROP TABLE IF EXISTS 202009231357;
create table 202009231357
(
 id INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 title		VARCHAR(100),
 user		VARCHAR(100),
 comment	TEXT,
 date_com	DATETIME
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- insert ----
START TRANSACTION;
insert into title_table (title_id, title, last_com, total_com) value (201909231357, 'テスト用ダミースレ', '2019-09-23 13:57', 1);
insert into title_table (title_id, title, last_com, total_com) value (202009231357, 'テスト用ダミースレ2', '2020-09-23 13:57', 1);
insert into 2019_0923_1357 (title, user, comment, date_com) value ('テスト用ダミースレ', '通行人A', 'おわた！', '2019-09-23 13:57');
insert into 2020_0923_1357 (title, user, comment, date_com) value ('テスト用ダミースレ2', '通行人B', 'おわた！', '2020-09-23 13:57');
COMMIT;
