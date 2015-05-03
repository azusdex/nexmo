<?php
/**
 * Created by PhpStorm.
 * User: konstantin.khotski
 * Date: 5/3/2015
 * Time: 12:30 PM
 */

namespace Azusdex\NexmoBundle\Model;

class NexmoAccount {
    protected $api;

    public function __construct($api_key, $api_secret) {
        $this->api = new NexmoApi($api_key, $api_secret);
    }

    /**
     * Retrieve your current account balance.
     * @return array|mixed
     */
    public function getAccountBalance() {
        return $this->api->sendRequest('/account/get-balance');
    }

    /**
     * Retrieve our outbound pricing for a given country.
     * @param $code
     * @return array|mixed
     */
    public function getPriceByCountryCode($code) {
        return $this->api->sendRequest('/account/get-pricing/outbound', array('country' => $code));
    }

    /**
     * Retrieve our outbound pricing for a given international prefix.
     * @param $prefix
     * @return array|mixed
     */
    public function getPriceByPrefixCode($prefix) {
        return $this->api->sendRequest('/account/get-prefix-pricing/outbound', array('prefix' => $prefix));
    }

    /**
     * Retrieve our outbound pricing for a phone number.
     * @param $phone
     * @param string $type
     * @return array|mixed
     */
    public function getCredentials($phone, $type = 'sms') {
        return $this->api->sendRequest('/account/get-phone-pricing/outbound/'.$type, array('phone' => $phone));
    }

    /**
     * Get all inbound numbers associated with your Nexmo account.
     * @return array|mixed
     */
    public function inboundNumbers() {
        return $this->api->sendRequest('account/numbers');
    }
}