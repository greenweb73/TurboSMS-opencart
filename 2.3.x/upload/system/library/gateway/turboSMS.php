<?php
namespace gateway;

class TurboSMS
{
    protected $token;
    protected $smsSender;
    protected $smsMessage;

    protected $baseUriApi = 'https://api.turbosms.ua/';

    /**
     * TurboSMS constructor main settings.
     */
    public function __construct($registry)
    {
        $this->registry = $registry;

        $this->token = $this->config->get('turbo_sms_token');
        $this->smsSender = $this->config->get('turbo_sms_sender');
        $this->smsMessage = $this->config->get('turbo_sms_message');
    }

    public function __get($name) {
        return $this->registry->get($name);
    }

    public function getBalance() {
       $result = $this->request('user', 'balance.json');
       if ($result->response_code === 0) return $result->response_result->balance;
       return 0;
    }

    public function sendSMS(string $phone, $order_id = '', $order_total = '') {

        $shortcodes = array(
            'order_id'   => $order_id,
            'order_total' => $order_total,
        );

        preg_match_all("|\{\{(.*)\}\}|U", $this->smsMessage, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $row) {
                $replase = (empty($shortcodes[$row])) ? '' : $shortcodes[$row];
                $this->smsMessage = str_ireplace('{{' . $row . '}}', $replase, $this->smsMessage);
            }
        }

        $data_sms = array(
            'recipients'  => [$phone],
            'sms' => [
                'sender' => $this->smsSender,
                'text' => $this->smsMessage
            ]
        );

        $result = $this->request('message', 'send.json', $data_sms );

    }

    public function request($module, $method = '', $data = array()) {

        $ch = curl_init($this->baseUriApi.$module .'/'. $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($res);
        return $res;
    }



}
