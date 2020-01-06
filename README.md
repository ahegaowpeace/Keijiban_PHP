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

- keijiban_db

- タイトルテーブル  

|概要|カラム名|値|型|
|---|---|---|---|
|ID|id|1|INT(4)|
|スレタイID|title_id|YYYY_MMDD_hhmmss|VARCHAR(15)|
|スレタイ|title|ネットスラング一覧スレ|VARCHAR(200)|
|最終書込日時|last_com|YYYY-MM-DD hh:mm:ss|DATETIME|
|書込総数|total_com|999|INT(4)|

※YYYYMMDDhhmmssはINT型では表せない

- コメントテーブル  

|カラム|値|型|
|---|---|---|
|ID|id|1|INT(4)|
|書込者|user|通行人A|VARCHAR(100)|
|書込|comment|おわた！|TEXT|
|書込日時|date_com|YYYY-MM-DD hh:mm:ss|DATETIME|

※テーブル名はスレタイID   
※テーブル名をスレタイIDにしたいけれど、数字のみ、ハイフンが使えないので2019_0923_1713みたいにするかも

## PHP(外観)

#### スレ立て

- Input
	- タイトル
- Output
	- スレ立ち
	- タイトルテーブルにレコード追加

#### 書き込み

- Input
	- 名前(任意)
	- 本文
- Output
	- 反映
	- コメントテーブルにレコード追加
