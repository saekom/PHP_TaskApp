<?php

// DB接続の情報
define('DSN', 'mysql:host=mysql;dbname=task_app;charset=utf8');
define('DB_USER', 'testuser');
define('DB_PASSWORD', 'password');

// エラー表示の設定(Noticeが表示されなくなる)
error_reporting(E_ALL & ~E_NOTICE);