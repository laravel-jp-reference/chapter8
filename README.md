# Laravelリファレンス 8章 Laravelの実践

[![Build Status](http://img.shields.io/travis/laravel-jp-reference/chapter8/master.svg?style=flat-square)](https://travis-ci.org/laravel-jp-reference/chapter8)
[![StyleCI](https://styleci.io/repos/48643492/shield)](https://styleci.io/repos/48643492)
[![Coverage Status](https://img.shields.io/coveralls/laravel-jp-reference/chapter8/master.svg?style=flat-square)](https://coveralls.io/github/laravel-jp-reference/chapter8)
[![Code Climate](https://img.shields.io/codeclimate/github/laravel-jp-reference/chapter8.svg?style=flat-square)](https://codeclimate.com/github/laravel-jp-reference/chapter8)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/cc9e553f-b833-4fb5-b2cf-89ec344a86e9.svg?style=flat-square)](https://insight.sensiolabs.com/projects/cc9e553f-b833-4fb5-b2cf-89ec344a86e9)

[![Dependency Status](https://www.versioneye.com/user/projects/56868b4ceb4f470030000786/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56868b4ceb4f470030000786)
[![GitHub license](https://img.shields.io/github/license/laravel-jp-reference/chapter8.svg?style=flat-square)](https://github.com/laravel-jp-reference/chapter8/blob/master/LICENSE)
[![GitHub license](https://img.shields.io/badge/laravel--jp--reference-chapter8-orange.svg?style=flat-square)](https://github.com/laravel-jp-reference/chapter8)

*このサンプルリポジトリはlaravel/homestead version0.3系を利用しています。*

## このリポジトリについて
このリポジトリはImpress社から発行されている、  
[「Laravelリファレンス」](http://book.impress.co.jp/books/1114101107)の「8章 Laravelの実践(P.371)」で利用しているサンプルアプリケーションです。

## アプリケーションの動作準備
Vagrantが必要です。その他Homesteadを利用しています

 - ［ 言語］PHP 5.5.9 以上
 - ［ データベース］MySQL（実行環境）、sqlite3（テスト）
 - ［ Web サーバ］Nginxまたは Apache
 - ［ キャッシュシステム］Memcached（キャッシュやセッションに利用しますが、設定ファイ
ルで変更できます）

## Homestead利用準備

### 付属のHomestead.yaml.distを利用する場合

Homestead.yaml.distの下記の部分を利用環境に合わせ、    
Homestead.yamlにファイル名を変更してご利用ください。

```yaml
folders:
    - map: "/path/to/ApplicationDirectory"
      to: "/home/vagrant/chapter12"
sites:
    - map: homestead.app
      to: "/home/vagrant/chapter12/public"
```

### homestead makeコマンドを利用する場合
Homesteadをプロジェクト開発時の依存パッケージとして利用する場合は、  
Homestead利用環境で `composer install` を実行して依存パッケージとしてインストールします。  

```bash
$ composer install
```

インストール後、プロジェクトディレクトリで下記のコマンドを実行します。  

```bash
$ vendor/bin/homestead make
```

コマンド実行後プロジェクトのルートディレクトリ配下にHomestead.yamlが設置されますので、  
メモリやcpuなどをお使いの環境に合わせて変更してください。

## Vagrant/Homesteadの起動

Vagrantfile設置ディレクトリで次のコマンドを実行します。  

```bash
$ vagrant up
```

コマンド実行後はお使いの環境でhostsなどを利用してサンプルアプリケーションをご利用ください。  
vagrant環境にログインするには次のコマンドをご利用ください。

```bash
$ vagrant ssh
```

## 依存ライブラリのインストール

Composerコマンドを利用して、依存ライブラリのインストールを行います。  
テストや開発などで利用するパッケージを含めてインストールする場合は、次のコマンドを入力してください。  
```bash
$ composer install
```

*barryvdh/laravel-ide-helper* などもこのコマンドでインストールされます。  

テストや開発依存パッケージが不要な場合は、次のコマンドを入力してください。  

```bash
$ composer install --no-dev -o;
```

### Dependencies
```json
  "require": {
    "php": ">=5.5.9",
    "laravel/framework": "5.1.*",
    "predis/predis": "1.*",
    "gregwar/captcha": "1.*"
  },
  "require-dev": {
    "fzaninotto/faker": "~1.4",
    "mockery/mockery": "0.9.*",
    "phpunit/phpunit": "~4.0",
    "phpspec/phpspec": "~2.1",
    "doctrine/dbal": "~2.3",
    "barryvdh/laravel-ide-helper": "2.*",
    "laravel/homestead": "~2.0"
  },
```

laravel-elixirを利用する場合は、npmコマンドを利用する必要があります。  
（サンプルアプリケーションでは利用せずに動作します）  

```bash
$ npm install
```

*gulpなどのインストールが必要となります。(Homesteadには含まれています)*

## アプリケーション実行方法
実行環境が準備できましたらプロジェクト設置ディレクトリで、  
下記のコマンドでデータベースマイグレーションを実行してください。

```bash
$ php artisan migrate --seed
```

アプリケーションで利用するデータベースの作成、データベースの外部キー制約作成などを実行します。  

### データベース接続情報
* アカウント情報

| 資格情報 | 値 |
|-----------|-------|
| ホスト | localhost |
| データベース名 | homestead |
| ユーザー名 | homestead |
| パスワード | secret |

データベースへログインする場合は以下のようにご利用ください。

```
$ mysql -u homestead -psecret homestead

mysql> show tables;
+---------------------+
| Tables_in_homestead |
+---------------------+
| comments            |
| entries             |
| migrations          |
| users               |
+---------------------+
```

## 追加サンプル

### アプリケーション最適化
アプリケーションの最適化を行うため、config/compile.phpを利用しています。  
`bootstrap/cache/compiled.php`ファイルにアプリケーションの実装コードが含まれるようになりますので、  
アプリケーションの動作を最適化（高速化）が行えます。  

### MailCatcher
付属のHomestead環境にはメール送信テストなどに利用できる、  
[MailCatcher](http://mailcatcher.me/)が利用できるように追加しています。  
port1080を利用してブラウザからアクセスし、メール送信の動作確認が行えます。  

*homestead.appドメインをご利用の場合は http://homestead.app:1080/ となります*
