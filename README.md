# とーくんるーむ
Mpurseでログインし、該当のMonaparty Tokenがあったら記事が読める的なやつです。
chatGPTに9割作らせました。
なんとなくは何やってるか処理がわかりますが、ソースコード読めないマンなのでﾜｶﾙ人は変なとこあったら指摘していただけると助かります！
あとgithub初めて使ったのでよくわかりません！！

## やりたいけど自分じゃできなさそうリスト
- 枚数とか種類を指定した記事を作れるようにする
- web上で記事が作れるようにする
- スニペットとして既存のCMSに組み込めるようにする

## 使い方 説明
①
![image](https://github.com/user-attachments/assets/a557a084-859b-463a-8e0c-c9081f6a1ddc)
一番最初の階層のindex.htmlの21行目
const tokens = ["",""]
の""にトークン名(モナカード名ではないよ！)を入れる。
いっぱい記事を作るときは
 ["TEST","TEST2","TEST3","TEST3"]
 みたいな感じ

②
contentsフォルダの中に、トークンと同じ名前(.は_に変えてください※)でフォルダを作成。
その中に表示するページを作成してください。
templateフォルダがあるので、コピペして使ってもいいです。

※…例えば monacoin.chan というトークン名なら monacoin_chan でフォルダを作ってください。

③
contents内にある.htacsessの中の「サイトアドレス」部分を、アップロードしてるサーバー名などに変えてください。

④
サーバーにアップロードし、動くかどうか確認してください。
たぶん、うごくよ！
