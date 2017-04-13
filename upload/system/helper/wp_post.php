<?php

if (!function_exists('curl_get')) {
    function curl_get($url, $timeout = 10)
    {
        ob_start();
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL            => $url,
                CURLOPT_HEADER         => false,
                CURLOPT_CONNECTTIMEOUT => $timeout,
            ]
        );
        curl_exec($ch);
        curl_close($ch);
        $content = ob_get_clean();

        return $content;
    }
}

if (!function_exists('curl_post')) {
    function curl_post($url, $params, $timeout = 10)
    {
        ob_start();
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL            => $url,
                CURLOPT_POSTFIELDS     => $params,
                CURLOPT_HEADER         => false,
                CURLOPT_CONNECTTIMEOUT => $timeout,
            ]
        );
        curl_exec($ch);
        curl_close($ch);
        $content = ob_get_clean();

        return $content;
    }
}