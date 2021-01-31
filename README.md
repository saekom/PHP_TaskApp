# 起動手順
実行環境：MacOS, PHP, nginx, MySQL

PHPで作成したタスク管理アプリを
ローカル動作させる手順を簡単にまとめます。


## 完成形
![タスク管理アプリ_完成形](/img/イメージ画像.png "イメージ画像")


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



## 02.DBの作成
### データベース"task_app"の作成
```
create database task_app;
```

### 作業ユーザーの作成とパスワードの設定。今回はホストを指定しない
ユーザー名: user
PW: password
```
create user testuser identified by 'password';
```

### "task_app"というデータベースの全てのテーブルの操作権限を「testuser」に付与
```
grant all on task_app.* to testuser;
```

### データベース"task_app"に入り、テーブルの作成
```
create table tasks (
    id int primary key auto_increment,
    title varchar(255),
    status varchar(10) default 'notyet',
    created_at datetime,
    updated_at datetime
);
```

### テスト用のレコードを入れておく
```
insert into tasks (title, created_at, updated_at) values
('基本技術者試験の勉強をする', now(), now()),
('コーヒーを買う', now(), now()),
('5kmランニングする', now(), now());
```

### データベース"task_app"に、contentsカラムを追加
```
ALTER TABLE tasks ADD content varchar(255);
```

### データベース"task_app"に、deadlineカラムを追加
```
ALTER TABLE tasks ADD deadline datetime;
```





## 03.2回目以降のコンテナの起動と停止方法
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