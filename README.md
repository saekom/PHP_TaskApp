# 起動手順
実行環境：MacOS, PHP, nginx, MySQL

PHPで作成したタスク管理アプリを
ローカル動作させる手順を簡単にまとめます。


## 01. 初回起動
### アプリの中へ移動
```
cd PHP_TaskApp
```

### 環境を構築。初回も今回はこれのみでOK。
```
docker-compose up -d
```

### 仮想サーバー立ち上げ後のURL
http://localhost/index.php



## 02.2回目以降の起動
### 起動中のコンテナを立ち上げる('-d'でプロセスを表示しない。私は基本これ)
```
docker-compose up -d
```

### 起動中のコンテナを立ち上げる(プロセスを表示する。仮想サーバーのログがザーッと流れてきます)
```
docker-compose up
```

### 起動中のコンテナを停止する
```
docker-compose up stop
```