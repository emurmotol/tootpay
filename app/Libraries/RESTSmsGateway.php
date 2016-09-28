<?php
namespace App\Libraries;

class RESTSmsGateway
{
    function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    function sendMessageToNumber($to, $message) {
        $query = array_merge(['phone' => $to, 'message' => $message]);
        return $this->makeRequest('/v1/sms/', 'PUT', $query);
    }

    private function makeRequest($url, $method, $query = []) {
        $_url = 'http://' . $this->host . ':' . $this->port . $url . '?' . http_build_query($query);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // todo change this
        curl_setopt($ch, CURLOPT_URL, $_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }
}
?>