<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['address']) && isset($_POST['token'])) {
        $address = $_POST['address'];
        $token = $_POST['token'];

        $api_url = "https://mpchain.info/api/balance/$address/$token";

        // cURLを使用してAPIからトークン情報を取得
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response !== false && $http_code == 200) {
            $data = json_decode($response, true);
            $quantity = isset($data['quantity']) ? floatval($data['quantity']) : 0;
            $description = json_decode($data['description'], true);
            $name = isset($description['monacard']['name']) ? $description['monacard']['name'] : "Not found";
            $cid = isset($description['monacard']['cid']) ? $description['monacard']['cid'] : "Not found";
            $image_url = "https://mcspare.nachatdayo.com/image_server/img/{$cid}m";

            if ($quantity >= 1) {
                if (file_exists('content.html')) {
                    include 'content.html';
                } else {
                    echo "<p>content.htmlファイルが見つかりません。</p>";
                }
            } else {
                if (file_exists('reject.html')) {
                    $reject_html = file_get_contents('reject.html');
                    echo str_replace(
                        ["{{image_url}}", "{{token}}", "{{quantity}}", "{{name}}"],
                        [$image_url, $token, $quantity, $name],
                        $reject_html
                    );
                } else {
                    echo "<p>reject.htmlファイルが見つかりません。</p>";
                }
            }
        } else {
            echo "<p>トークン情報の取得に失敗しました。再試行してください。</p>";
        }
    } else {
        echo "<p>アドレスまたはトークンが提供されていません。</p>";
    }
} else {
    echo "<p>無効なリクエストメソッドです。</p>";
}
?>
