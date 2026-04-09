<?php
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=UTF-8');

// データの受け取り
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["status" => "error"]);
    exit;
}

// メールの設定
$to = "gumdam1107@yahoo.co.jp"; // 受信先メールアドレス
$subject = "【チャット申込】" . $data['name'] . "様 / " . $data['area'];

$message = "LPのチャットより申し込みがありました。\n\n"
         . "【エリア】　　 " . $data['area'] . "\n"
         . "【種類/体重】　" . $data['pet'] . "\n"
         . "【プラン】　　 " . $data['plan'] . "\n"
         . "【お名前】　　 " . $data['name'] . " 様\n"
         . "【電話番号】　 " . $data['tel'] . "\n"
         . "【希望日時】　 " . $data['datetime'] . "\n\n"
         . "※早急に折り返しをお願いします。";

$headers = "From: system@yushin.life\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

// 送信実行
mb_language("Japanese");
mb_internal_encoding("UTF-8");

if (mb_send_mail($to, $subject, $message, $headers)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}