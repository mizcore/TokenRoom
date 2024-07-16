<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../c-styles.css">
    <title>MPurse Login Check</title>
    <script>
       async function loginWithMPurse() {
            try {
                document.getElementById('status').innerHTML = "ログイン中...";
                const address = await window.mpurse.getAddress();
                checkToken(address);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('status').innerHTML = "ログインに失敗しました。再試行してください。";
            }
        }

        function checkToken(address) {
            const token = "MONA"; // ここにトークン名を入れる
            const request = new XMLHttpRequest();
            request.open('POST', 'process_login.php', true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = function() {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        document.open();
                        document.write(request.responseText);
                        document.close();
                    } else {
                        document.getElementById('status').innerHTML = "APIリクエストに失敗しました。再試行してください。";
                    }
                }
            };
            request.send('address=' + address + '&token=' + token);
        }

        function manualReload() {
            location.reload();
        }

        window.onload = loginWithMPurse;
    </script>
</head>
<body>
        <div id="contents" style="text-align: center;">
        <div id="status" style="padding: 20px;">MPurseでログイン中...</div>
        <button onclick="manualReload()">再試行</button> <button onclick="loginWithMPurse()">アプリからログイン</button>
    </div>
    <div id="footer" style="display:block;">
        Mpurseでログインして該当の所持トークンがあれば記事を読めるページです。<br>
        このシステムはchatGPTを用いて作られました。
        <h2>Mpurseってなあに？</h2>
        モナコインやモナカードを入れることができるお財布ブラウザ拡張機能です。<br>
        ChromeやFirefoxで使える他、Android, iOSアプリ版があります。<br>
        詳しい説明や導入方法は以下のURL先をご覧ください。<br>
        <a href="https://blog.n-ista.org/2019/06/mpursegoogle-chromefirefox.html" target="_blank">
            Mpurseのウォレット（口座）開設方法(秘密結社にすたブログ )
        </a>
        <h2>入手先</h2>
    <a href="https://chromewebstore.google.com/detail/mpurse/ljkohnccmlcpleonoiabgfggnhpkihaa">Chrome拡張機能版</a>
    <a href="https://addons.mozilla.org/ja/firefox/addon/mpchain_mpurse/">Firefox拡張機能版</a>
    <a href="https://apps.apple.com/jp/app/mpurse/id1494156643">iOSアプリ版</a>
    <a href="https://play.google.com/store/apps/details?id=info.mpchain.mpurse&hl=ja">Androidアプリ版</a>
    </div>
    </div>
    </body>
</html>
