<?php
header('Content-Type: application/json; charset=UTF-8');
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!$data) { echo json_encode(["status" => "error"]); exit; }

$to = "info@yushin.life";
$subject = "【チャット申込】" . $data['name'] . "様";
$message = "【エリア】" . $data['area'] . "\n"
         . "【種類】" . $data['pet'] . "\n"
         . "【プラン】" . $data['plan'] . "\n"
         . "【お名前】" . $data['name'] . "様\n"
         . "【電話】" . $data['tel'] . "\n"
         . "【希望】" . $data['datetime'];

$headers = "From: system@yushin.life\r\nContent-Type: text/plain; charset=UTF-8";
mb_language("Japanese"); mb_internal_encoding("UTF-8");

if (mb_send_mail($to, $subject, $message, $headers)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}