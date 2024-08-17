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
$accessKey = getenv('69d1c6a59b8cfb849eceea17a8d2a2c2'); // Use environment variable for security
$geoDataUrl = "http://api.ipstack.com/$userIP?access_key=$accessKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $geoDataUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$geoData = curl_exec($ch);
if (curl_errno($ch)) {
    // Handle cURL error
    $geoData = FALSE;
}
curl_close($ch);

if ($geoData === FALSE) {
    // Handle error if API request fails
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
    exit();
}

$geoData = json_decode($geoData, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // Handle JSON decode error
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
    exit();
}

if (isset($geoData['country_code']) && $geoData['country_code'] === 'US') {
    header("Location: https://roastandrelish.store");
} else {
    header("Location: https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF");
}

exit();
?>
