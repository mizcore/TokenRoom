<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        }

        function checkToken(address) {
            const token = "MONA";
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
    <div id="status">MPurseでログイン中...</div>
    <button onclick="manualReload()">再試行</button>
</body>
</html>
