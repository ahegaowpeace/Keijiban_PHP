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

|カラム|値|型|
|---|---|---|
|ID|1|INT(10000)|
|タイトル|YYYYMMDDhhmmss|INT(15)|
|最終書込日時|YYYYMMDDhhmmss|INT(15)|
|書込総数|999|INT(4)|

- コメントテーブル  

|カラム|値|型|
|---|---|---|
|ID|1|INT(10000)|
|スレタイID|YYYYMMDDhhmmss|INT(15)|
|スレタイ|ネットスラング一覧スレ|VARCHAR(200)|
|書込者|通行人A|VARCHAR(50)|
|書込|おわた！|VARCHAR(20000)|
|書込日時|YYYYMMDDhhmmss|INT(15)|

※テーブル名はスレタイ  

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
