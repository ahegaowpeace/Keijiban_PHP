## docker-composeをインストール
```
curl -L https://github.com/docker/compose/releases/download/1.6.2/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
lSELinuxを無効化する。
setenfoce 0
docker-compose up -d
```
## LAMP基本
docker-compose up -dを実行した後は、
phpからdbに接続する際のホスト名をlocalhostではなくコンテナ名とする
## プロセス起動
mysqlコンテナにログインしてshellを実行する必要あり  
port=3000/tcp(セキュリティグループ)
## その他
本当に真っ白でやりたければdataディレクトリは削除

# 要件
## DB
## PHP
