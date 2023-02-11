# クイズ作成プラグイン「すみれ」

ショートコードで、選択式のクイズを作成する事が出来ます。

### 基本機能
ショートコードを作り、編集エディタに貼り付けてください。

### 必須
- 質問文を`[quiz][/quiz]`で囲みます。
- `question`パラメーターに、回答リストを半角カンマ区切りで入力します。
- `answer`パラメータに、回答を入力します。

### 任意
- `commentary`パラメータを入力すると、回答表示時に解説文を表示します。
- `random="true"`を設定すると、質問がランダムに並び替えられて表示されます。
- `style="school"`を設定すると、学校デザインに変更されます。style="default"がデフォルト値です。適当な値に設定すると、CSSが全て外れます。

### その他機能
- クラッシックエディタに見本のショートコードを設置するメニューを追加しています。

## 見本1（style="default" or 設定なし）
```
[quiz question="1.桃太郎,2.浦島太郎,3.金太郎" answer="1.桃太郎"]桃から生まれたのは？[/quiz]
```

### 回答前
<img width="686" alt="スクリーンショット 2023-02-11 11 38 30" src="https://user-images.githubusercontent.com/27271636/218234801-a697485d-ffc3-4ed3-9276-35feecc8ba23.png">

### 回答後
<img width="694" alt="スクリーンショット 2023-02-11 11 44 06" src="https://user-images.githubusercontent.com/27271636/218234986-7bd5178b-3ee3-43e6-88c8-816b1c27afb1.png">


## 見本2（style="school"）
```
[quiz question="土浦市,日立市,古河市,水戸市" answer="水戸市" commentary="水戸市の人口は約27万人です。" random="true" style="school"]茨城県の県庁所在地を答えなさい。[/quiz]
```

### 回答前
<img width="678" alt="スクリーンショット 2023-02-11 11 42 29" src="https://user-images.githubusercontent.com/27271636/218234914-71da2312-8439-4aa5-9776-6e7e4d277412.png">

### 回答後
<img width="685" alt="スクリーンショット 2023-02-11 11 45 42" src="https://user-images.githubusercontent.com/27271636/218235051-03e0e48e-671b-4785-9b92-295a953ad216.png">


## インストール方法

### FTPで直接アップロードする場合

1. 「wp-make-quiz.zip」を解凍ソフトを使って解凍します。
2. 解凍して作成された「wp-make-quiz」フォルダを、「/wp-content/plugins/」ディレクトリにアップロードします。
3. WordPress管理画面の「プラグイン」メニューより、「クイズ作成プラグイン」を有効化します。

### WordPress管理画面からインストールする場合

1. WordPress管理画面より、「プラグイン」>「新規追加」>「プラグインのアップロード」とアクセスします。
2. 「ファイルを選択」から、添付の「wp-make-quiz.zip」を選択して、「今すぐインストール」をクリックします。
3. 「プラグインを有効化」をクリックします。

## このプラグインについて
このプラグインは吉田喜彦さんが作成した [WordPressクイズ作成プラグインすみれ日本語スマホ対応版](https://www.kagua.biz/wp/wpplugin/wp-make-quiz.html) をカスタマイズしたものになります。

### カスタマイズした機能
- jQueryをJavascriptに変換
- 問題に戻るボタンの追加
- CSSの修正
- style="school" の追加
- クラッシックエディタ機能追加

ソースコードはGPLです。
