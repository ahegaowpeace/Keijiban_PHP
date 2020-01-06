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

---- Create CommentTable ----
CREATE DATABASE IF NOT EXISTS keijiban_db;
DROP TABLE IF EXISTS comment_table;
create table comment_table
(
 id INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 title_id	BIGINT(15),
 user		VARCHAR(100),
 comment	TEXT,
 date_com	DATETIME
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- insert ----
START TRANSACTION;
insert into title_table (title_id, title, last_com, total_com) value (201909231357, 'ネットスラング一覧スレ', '2019-09-23 13:57', 1);
COMMIT;
