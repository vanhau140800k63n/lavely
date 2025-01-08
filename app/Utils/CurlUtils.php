<?php

namespace App\Utils;

class CurlUtils
{
    public static function setOptArray($url)
    {
        return array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: */*',
                'Accept-Language: en-US,en;q=0.9,vi;q=0.8,ja;q=0.7',
                'App-Version: 1.0.0',
                'App-Version-Code: 10000',
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2NmYxMjA1M2E4NmNiNzY4ZTAyNmY1MmUiLCJleHAiOjE3NDI2MzA0ODMsIm5hbWUiOiJI4bqtdSBWxINuIn0.nowys5VrAL_C1pi3YexU9anh-4EmrLNP9AbLzGdi4J4',
                'BROWSER-NAME: Chrome',
                'BROWSER-VERSION: 129',
                'Connection: keep-alive',
                'DEVICE-TYPE: browser',
                'Origin: https://selly.vn',
                'PLATFORM: Web',
                'Referer: https://selly.vn/',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-site',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'os-name: Browser',
                'os-version: 10.15.7',
                'sec-ch-ua: "Google Chrome";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "macOS"'
            ),
        );
    }
}
