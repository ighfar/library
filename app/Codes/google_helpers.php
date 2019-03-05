<?php
if ( ! function_exists('set_google_short_url'))
{
    function set_google_short_url($url)
    {
        $data_passing = array("longUrl" => $url );
        $data_string = json_encode($data_passing);
        $url = 'https://www.googleapis.com/urlshortener/v1/url?key='.env('GOOGLE_API');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        curl_close($ch);
        $getUrl = json_decode($result);

        return $getUrl->id;

    }
}