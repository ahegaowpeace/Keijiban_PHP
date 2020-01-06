## docker-composeをインストール
```
curl -L https://github.com/docker/compose/releases/download/1.6.2/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
lSELinuxを無効化する。
setenfoce 0
docker-compose up -d
```
## プロセス起動
docker-compose up -dを実行した後

- mysqlコンテナ
	- initスクリプトを実行し初期テーブルを作成する
	- port=3000/tcp
- phpコンテナ
	- phpからdbに接続する際のホスト名をlocalhostではなくコンテナ名とする
## その他
本当に真っ白でやりたければdataディレクトリは削除

# 要件
## DB

- タイトルテーブル  

|カラム|値|    型    |Null|Def|  Ext  |
| ---  |---|   ---   |---| --- | --- |
|  ID  |1 |INT(10000)| No |   |PrmKey|

- コメントテーブル  

|  カラム  |  TH  |  TH  |  TH  |  TH  |
| --- | --- | --- | --- | --- |
| ID | INT(10000) | No | | PrmKey |
| ID | INT(10000) | No | | |

## PHP
