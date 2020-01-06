---- create ----
CREATE DATABASE IF NOT EXISTS test_db;
DROP TABLE IF EXISTS master_table;
create table master_table
(
 id	INT(20) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 title	VARCHAR(100),
 artist	VARCHAR(50),
 pagenum	INT(11),
 category	VARCHAR(100),
 tag	VARCHAR(100),
 etc	VARCHAR(100),
 uploadtime	VARCHAR(100)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- insert ----
START TRANSACTION;
insert into master_table (title, uploadtime, pagenum) value ('バッテリー', '2019-09-23 19:44:46', 36);
COMMIT;
