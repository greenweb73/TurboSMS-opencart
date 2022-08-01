<?php
class ControllerExtensionModuleTurboSms extends Controller
{

    public function send($eventRoute, $data) {

        $this->registry->set('turbosms', new gateway\TurboSMS($this->registry));

        $order_id = $data[0];

        $this->load->model('checkout/order');
        $this->load->model('account/order');


        if (count($this->model_account_order->getOrderHistories((int) $order_id)) < 2) {

            $order_info = $this->model_checkout_order->getOrder((int) $order_id);
            $total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

            $telephone = $this->formatPhone($order_info['telephone']);

            $turbosms = new gateway\TurboSMS($this->registry);

            $balance = $turbosms->getBalance();
            if ($balance > 5) {
                $turbosms->sendSMS($telephone, $order_id, $total);
            }
        }
    }

    protected function formatPhone(string $phone) {

        preg_match_all('/\d+/', $phone, $matches);

        $formated_phone = implode('', $matches[0]);
        $formated_phone = (strlen($formated_phone) < 11) ? '38' . $formated_phone : $formated_phone;

        return $formated_phone;
    }

}
