<?php
class ControllerExtensionModuleTurboSms extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('extension/module/turbo_sms');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('turbo_sms', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['message'])) {
            $data['error_message'] = $this->error['message'];
        } else {
            $data['error_message'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/turbo_sms', 'token=' . $this->session->data['token'], true),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/module/turbo_sms', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        $data['token'] = $this->session->data['token'];
        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_message'] = $this->language->get('entry_message');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sender'] = $this->language->get('entry_sender');
        $data['entry_token'] = $this->language->get('entry_token');

        $data['text_info'] = $this->language->get('text_info');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_extension'] = $this->language->get('text_extension');
        $data['text_success'] = $this->language->get('text_success');
        $data['text_edit'] = $this->language->get('text_edit');

        $data['text_shortcode_list'] = $this->language->get('text_shortcode_list');

        if (isset($this->request->post['turbo_sms_token'])) {
            $data['turbo_sms_token'] = $this->request->post['turbo_sms_token'];
        } else {
            $data['turbo_sms_token'] = $this->config->get('turbo_sms_token');
        }

        if (isset($this->request->post['turbo_sms_token'])) {
            $data['turbo_sms_sender'] = $this->request->post['turbo_sms_sender'];
        } else {
            $data['turbo_sms_sender'] = $this->config->get('turbo_sms_sender');
        }

        if (isset($this->request->post['turbo_sms_message'])) {
            $data['turbo_sms_message'] = $this->request->post['turbo_sms_message'];
        } else {
            $data['turbo_sms_message'] = $this->config->get('turbo_sms_message');
        }

        if (isset($this->request->post['turbo_sms_status'])) {
            $data['turbo_sms_status'] = $this->request->post['turbo_sms_status'];
        } else {
            $data['turbo_sms_status'] = $this->config->get('turbo_sms_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/turbo_sms', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/turbo_sms')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }


        if ((utf8_strlen($this->request->post['turbo_sms_message']) > 0) &&
            (utf8_strlen($this->request->post['turbo_sms_message']) < 3) ||
            (utf8_strlen($this->request->post['turbo_sms_message']) > 70)) {
            $this->error['message'] = $this->language->get('error_message');
        }

        return !$this->error;
    }

    public function install()  {
        $this->load->model('extension/event');
        $this->model_extension_event->addEvent('turbo_sms', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/module/turbo_sms/send');
    }

    public function uninstall() {
        $this->load->model('extension/event');
        $this->model_extension_event->deleteEvent('turbo_sms');
    }
}
