
## 目標を入力するだけで、達成するまでのタスクを生成するアプリ

<h2 style="text-align: center;">taskall(タスカル)</h2>

htps://github.com/ShotaMihara/Taskall/blob/main/ReadMe/top.png

# 概要
目標はある。だけど最初の一歩がわからない。
Taskall（たすかる）は、そんな迷いを「行動」に変えるアプリです。
ユーザーが入力した目標を、具体的で実行可能なタスクへと自動で分解。
一歩ずつ確実に前進できる“行動地図”を提供します。
/Users/user/Taskall/ReadMe/top.png
# 制作背景
未経験からWEBエンジニアを目指した当時、何から始めればいいのか分からず、<br>
検索しても専門用語や抽象的なロードマップばかりで、最初の一歩が見えませんでした。<br>
しかし、自分で時間をかけてタスク化してみると、一つひとつは大きな壁ではなく、<br>
行動に落とし込めるものだと気づきました。<br>
同じように、目標があっても最初の行動が見えずに立ち止まっている人は多いはず。<br>
そこで私は、目標を“すぐに実行できる行動リスト”に自動変換し、<br>
一歩を踏み出す手助けができるツールとして、Taskall（たすかる）を開発しました。


# 画面説明
・ユーザー登録画面</br>
Topページから新規登録ボタンを押すと、ユーザー登録画面へ推移します。</br>
名前、メールアドレス、パスワードを入力登録後、myPageへ推移します。</br>
※既に登録している方はリンクを押してもらうとログインページに飛びます。

![user](/Readme/user.gif)</br>

・目標作成画面</br>
目標追加ボタンを押すと、目標入力フォームが表示されます。</br>
なりたい目標を入力するとタスクが作成され、右側に参考になるYoutube動画が表示されます。</br>
作成されたタスクには具体的な内容が記入されております。</br>

![setting](/Readme/setting.gif)</br>

・目標作成確認</br>
作成されたタスクが気に入らない場合は、再読み込みボタンを押して、タスクを再生成します。</br>
また、資格のレベルが複数ある場合は、再度目標を設定ボタンを押してレベルを指定して再作成できます。</br>
OKであればタスクを保存ボタンを押すとmypageに推移し、作成した目標が表示されます。</br>

![show](/Readme/show.gif)</br>

・目標、タスクの確認</br>
作成された目標の詳細を見るボタンを押すとタスクの一覧を見ることができます。</br>
完了したタスクにはチェックボックスにチェックを入れることで進捗を管理できます。</br>
（ゴールの進捗が一目でわかりやすいよう、進捗度に応じたバーを設置してます。）</br>
下部に作成した時に取得したYoutube動画のリンクが表示されます。</br>
編集ボタンを押すと編集ページに推移し、タスク名、タスク詳細を編集でき、タスクの削除を行えます。</br>
締め切りを設ける場合は日付を設定できます。</br>

![task.edit](/Readme/task.edit.gif)</br>


# 使用技術

**バックエンド**<br>
PHP 8.2.27/ Laravel 12.2.0

**フロントエンド**<br>
HTML / CSS / javascript / Tailwind

**インフラ**<br>
mysql 8.0</br>
Docker (開発環境)


**その他の使用技術**<br>
gemini-2.0-flash</br>
YouTube Data API</br>
git(gitHub) / Visual Studio Code</br>
Drawio(ER図))</br>

### ・ ER図
![ER](/Readme/ER.png)</br>

### ・ 各種テーブル

| **テーブル名** | **定義** |
| ---- | ---- |
| User<br>(ユーザー) | ユーザーの登録情報 |
| Goal<br>(目標) | ユーザーが作成した目標 |
| Task<br>(タスク) | 自動生成、編集されたタスク |
| Resource<br>(リソース) | 目標に関する動画URL |

### メイン機能

-   **ユーザーの新規作成・表示・編集・削除**
-   **目標入力画面**
-   **タスクの自動作成・表示・編集・削除**
-   **関連動画の取得**

<br>

### 認証機能

-   ユーザー登録・ログイン・ログアウト
-   メールアドレス認証
-   メールアドレス変更
-   パスワード再設定
