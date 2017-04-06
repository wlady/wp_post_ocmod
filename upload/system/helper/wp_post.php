<?php

require_once(DIR_CONFIG . 'wp_post.php');

function curl_get($url)
{
    ob_start();
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        [
            CURLOPT_URL            => $url,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => CURL_TIMEOUT,
        ]
    );
    curl_exec($ch);
    curl_close($ch);
    $content = ob_get_clean();

    return $content;
}

function curl_post($url, $params)
{
    ob_start();
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        [
            CURLOPT_URL            => $url,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => CURL_TIMEOUT,
        ]
    );
    curl_exec($ch);
    curl_close($ch);
    $content = ob_get_clean();

    return $content;
}
