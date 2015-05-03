<?php
/**
 * Created by PhpStorm.
 * User: konstantin.khotski
 * Date: 5/3/2015
 * Time: 1:53 PM
 */

namespace Azusdex\NexmoBundle\Model;

class NexmoMessage {
    protected $api;

    public function __construct($api_key, $api_secret) {
        $this->api = new NexmoApi($api_key, $api_secret);
    }

    /**
     * send sms
     * @param $from
     * @param $to
     * @param $text
     * @return array|mixed
     */
    public function sendTextMessage($from, $to, $text) {
        $params = array(
            'from' => $this->validateFrom($from) ? $this->validateFrom($from) : false,
            'to' => $this->validateTo($to) ? $this->validateTo($to) : false,
            'text' => $this->validateText($text),
            'type' => $this->validateTextEnglish($text) ? NexmoApi::MESSAGE_TYPE_DEFAULTS : NexmoApi::MESSAGE_TYPE_UNICODE,
        );

        return $this->sendRequest('sms/json', $params);
    }

    /**
     * validate field from
     * @param $from
     * @return mixed|string
     */
    private function validateFrom($from) {
        $f = preg_replace('/[^a-zA-Z0-9]/', '', (string)$from);

        if (preg_match('/[^a-zA-Z]/', $f)) {
            $f = substr($f, 0, 11);
        } else {
            if (substr($f, 0, 2) == '00') {
                $f = substr($f, 2);
                $f = substr($f, 0, 15);
            }
        }

        return $f;
    }

    /**
     * validate number
     * @param $to
     * @return bool|int|string
     */
    private function validateTo($to) {
        $f = preg_replace('/[^0-9]/', '', (string)$to);

        return is_numeric($f) ? $f : false;
    }

    /**
     * if english
     * @param $text
     * @return bool
     */
    private function validateTextEnglish($text) {
        if (strlen($text) != mb_strlen($text, 'UTF-8')) {
            return false;
        }

        return true;
    }

    /**
     * coding text to UTF 8
     * @param $text
     * @return string
     */
    private function validateText($text) {
        if (!mb_check_encoding($text)) {
            $text = mb_convert_encoding($text, 'UTF-8', 'auto');
        }

        return $text;
    }
}