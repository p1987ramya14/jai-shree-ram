<?php
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$userIP = getUserIP();
$accessKey = '69d1c6a59b8cfb849eceea17a8d2a2c2'; // Replace with your actual API key
$geoDataUrl = "https://api.ipinfo.io/202.142.114.62?access_key=69d1c6a59b8cfb849eceea17a8d2a2c2";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $geoDataUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$geoData = curl_exec($ch);
if (curl_errno($ch)) {
    error_log('cURL Error: ' . curl_error($ch));
    $geoData = FALSE;
}
curl_close($ch);

if ($geoData === FALSE) {
    // Log error and redirect to fallback URL
    error_log('Geo Data Request Failed');
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
    exit();
}

$geoData = json_decode($geoData, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // Log JSON decode error
    error_log('JSON Decode Error: ' . json_last_error_msg());
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
    exit();
}

error_log('Decoded Geo Data: ' . print_r($geoData, true));

if (isset($geoData['country']) && strtoupper($geoData['country']) === 'US') {
    header("Location: https://roastandrelish.store");
} else {
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
}

exit();
?>
