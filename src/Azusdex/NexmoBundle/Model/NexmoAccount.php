<?php
/**
 * Created by PhpStorm.
 * User: konstantin.khotski
 * Date: 5/3/2015
 * Time: 12:30 PM
 */

namespace Azusdex\NexmoBundle\Model;

class NexmoAccount {
    protected $api_url;
    protected $api_key;
    protected $api_secret;

    const HTTP_RESPONSE_SUCCESS_CODE = 200;

    public function __construct($api_key, $api_secret) {
        $this->api_url = 'https://rest.nexmo.com';
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }

    protected function sendRequest($url, $params = array()) {
        $params['api_key'] = $this->api_key;
        $params['api_secret'] = $this->api_secret;

        $request_url = $this->api_url.'/'.trim($url,'/').'?'.http_build_query($params);

        $request = curl_init($request_url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $response = curl_exec($request);
        $info = curl_getinfo($request);
        $response_code = (int)$info['http_code'];
        curl_close($request);

        switch($response_code) {
            case self::HTTP_RESPONSE_SUCCESS_CODE:
                return json_decode($response, true);
            default:
                return array('status' => 'ERROR', 'message' => $response);
        }
    }

    public function getAccountBalance() {
        return $this->sendRequest('/account/get-balance');
    }
}