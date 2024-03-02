<?php
require '../config/setting.php';
header('Content-Type: application/json');

if (isset($_POST['code']) AND isset($_POST['target']) AND isset($_POST['additional_target'])) {
$code = mysqli_real_escape_string($conn,$_POST['code']);
$target = mysqli_real_escape_string($conn,$_POST['target']);
$additional_target = mysqli_real_escape_string($conn,$_POST['additional_target']);

if (!$code || !$target || !$additional_target)
{
$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
} 
else {
 $sql_4 = mysqli_query($conn,"SELECT * FROM `tb_tripayapi` WHERE cuid = 4") or die(mysqli_error());
    $s4 = mysqli_fetch_array($sql_4);
    $apiKeys = "D6bMLXuhLdsb6hqXMxAz9aCFwm86HK2JcnMjaaWYnjcgjVSnPfZJk271iUS1AgNF";
    $merchantCodes = "U6jeTFhL";
    $signe = $merchantCodes.$apiKey.$api_id_vip.$api_key_vip;
    $sign = md5($signe);
    $curl1 = curl_init();
    curl_setopt_array($curl1, array(
        CURLOPT_URL => 'https://vip-reseller.co.id/api/game-feature',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('key' => $apiKey.$api_key_vip, 'sign' => $sign, 'type' => 'get-nickname', 'code' => $code, 'target' => $target, 'additional_target' => $additional_target),
    ));
    $response1 = curl_exec($curl1);
    curl_close($curl1);
    $hasils = json_decode($response1, true);
$nickname = $hasils['data']; 
$hasilnya = array('result' => true, 'data' => $nickname);
}
}
print(json_encode($hasilnya, JSON_PRETTY_PRINT));
?
