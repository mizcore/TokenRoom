<?php
// process_login.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['address']) && isset($_POST['tokens'])) {
        $address = $_POST['address'];
        $tokens = json_decode($_POST['tokens'], true);

        $results = [];
        $errors = false;
        
        foreach ($tokens as $token) {
            $api_url = "https://mpchain.info/api/balance/$address/$token";

            // cURLを使用してAPIからトークン情報を取得
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($response !== false && $http_code == 200) {
                $data = json_decode($response, true);
                $quantity = isset($data['quantity']) ? floatval($data['quantity']) : 0;

                // descriptionフィールドが存在するかチェック
                if (isset($data['description'])) {
                    // descriptionフィールドをJSONとしてデコード
                    $description = json_decode($data['description'], true);
                    // monacardフィールドからcidとnameを取得
                    $cid = isset($description['monacard']['cid']) ? $description['monacard']['cid'] : "Not found";
                    $name = isset($description['monacard']['name']) ? $description['monacard']['name'] : "Not found";
                } else {
                    $cid = "Not found";
                    $name = "Not found";
                }
                
                $results[$token] = [
                    'quantity' => $quantity,
                    'cid' => $cid,
                    'name' => $name
                ];
            } else {
                $results[$token] = [
                    'quantity' => 0,
                    'cid' => "",
                    'name' => ""
                ];
                $errors = true;
            }
        }

        // 結果に応じた表示
        if ($errors) {
            echo "<p>一部のトークン情報の取得に失敗しました。再試行してください。</p>";
        }

        foreach ($results as $token => $data) {
            $quantity = $data['quantity'];
            $cid = $data['cid'];
            $name = $data['name'];
            $url_token = str_replace('.', '_', $token); // トークン名の "." を "_" に置き換え
            $image_url = ($cid !== "Not found") ? "https://mcspare.nachatdayo.com/image_server/img/{$cid}m" : "no_image.jpg";
            
            echo "<div class='token-container'>";
            if ($quantity >= 1) {
                echo "<div class='image-container'><img src='$image_url' alt='$token'></div>";
                echo "<div class='token-container-center'><h2>$name</h2><p>$token<br>$quantity / 1枚 所有済み</p>";
                echo "<a href='contents/$url_token/index.html' target='_blank'><button>記事を読む！</button></a></div>";
            } else {
                echo "<div class='image-container'><img src='$image_url' alt='$token' class='grayed-out'><div class='lock-overlay'><p>未所持</p></div></div>";
                echo "<div class='token-container-center'><h2>$name</h2><p>$token<br>$quantity / 1 未所持</p><a href='https://mona-tools.com/mona_asset_detail.php?asset_id=$token' target='_blank'><button>トークンを買う</button></a><br><span style='font-size:0.5em;color:#666;'>※買った後はしばらくしてから再度アクセスしてください。</span></div>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>アドレスまたはトークンが提供されていません。</p>";
    }
} else {
    echo "<p>無効なリクエストメソッドです。</p>";
}
?>
