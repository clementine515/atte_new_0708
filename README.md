# 勤怠打刻システムATTE
<img width="1143" alt="atte_toppage" src="https://github.com/clementine515/atte_new_0708/assets/163751500/3e6f6c52-2290-453e-bc74-d863a7dee8e4">

## 作成目的
初級模擬案件として作成

## 機能一覧
新規会員登録、ログイン、ログアウト、勤務開始/勤務終了/休憩開始/休憩終了の打刻、
日付毎の勤怠一覧取得、ユーザー毎の勤怠一覧取得、ページネーション、メール認証
（勤務開始/勤務終了ボタンは1日１回ずつのみ、休憩開始/休憩終了ボタンは何度でも打刻可）

## ログイン用テストアカウント　
メールアドレス：sazae@gmail.com パスワード：sazae
#### 注意事項１：
打刻ページの右上「日付一覧」から日付毎の勤怠一覧が確認できますが、
ダミーデータを6月いっぱいしか入力していないため「＜」ボタンで日付を遡ってご確認をお願いいたします。
#### 注意事項2：
ダミーデータの登録数の関係上、6/24の勤怠一覧でページネーションをご確認いただけます。
#### 注意事項3：
日付毎の勤怠一覧が確認できるページで各ユーザーの名前をクリックすると個人別の勤怠記録をご確認いただけます。

## 使用技術
#### Laravel Framework 8.83.27
#### PHP8.3.0
#### MySQL8.0.26

## テーブル設計
<img width="571" alt="atte_tables" src="https://github.com/clementine515/atte_new_0708/assets/163751500/69e412c4-0500-4de1-ab5c-28d9a8f785d6">

## ER図
<img width="783" alt="atte_erd" src="https://github.com/clementine515/atte_new_0708/assets/163751500/b6668327-f2df-432b-92f7-630b1543ee76">

## 環境構築
### <Dockerビルド>
### 1 git clone git@github.com:clementine515/atte_new_0708.git
### 2 DockerDesktopアプリを立ち上げる
### 3 docker-compose up -d --build
### 注意事項：
#### MacのM1・M2チップのPCの場合、no matching manifest for linux/arm64/v8 in the manifest list entriesのメッセージが表示されビルドができないことがあります。 エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内の一番上に「platform: linux/x86_64」を追加で記載してください

### <Laravel環境構築>
### 1 docker-compose exec php bash
### 2 composer install
### 3 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
### 4 .envに以下の環境変数を追加
#### DB_CONNECTION=mysql
#### DB_HOST=mysql
#### DB_PORT=3306
#### DB_DATABASE=laravel_db
#### DB_USERNAME=laravel_user
#### DB_PASSWORD=laravel_pass
### 5 アプリケーションキーの作成
#### php artisan key:generate
### 6 マイグレーションの実行
#### php artisan migrate
### 7 シーディングの実行
#### php artisan db:seed

## URL
### 開発環境：http://localhost/
### phpMyAdmin:：http://localhost:8080/
