<?php
header('Content-Type: text/html; charset=utf-8');

$ip = $_GET["ip"];
if($ip==null) $ip = get_client_ip();

$data = get_web_text('http://ip-api.com/csv/'.$ip);
$data = explode(',', $data);
if($data[0]=='success') {
    echo '{';
    echo '"country":"'.$data[1].'",';
    echo '"isp":"'.$data[10].'",';
    echo '"x":'.$data[6].',';
    echo '"y":'.$data[7].'';
    echo '}';
} else {
    echo '{}';
}

function get_client_ip() {
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ip = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = 'UNKNOWN';
    return $ip;
}

function get_web_text($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>