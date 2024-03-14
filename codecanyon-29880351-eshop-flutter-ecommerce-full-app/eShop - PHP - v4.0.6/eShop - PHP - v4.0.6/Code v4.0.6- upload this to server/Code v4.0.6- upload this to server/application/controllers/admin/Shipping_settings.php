<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model('Setting_model');

        if (!has_permissions('read', 'shipping_settings')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }


    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'shipping-settings';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Shipping Methods Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Shipping Methods Management  | ' . $settings['app_name'];
            $this->data['settings'] = get_settings('shipping_method', true);
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_shipping_settings()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'shipping_settings'), PERMISSION_ERROR_MSG, 'shipping_settings')) {
                return false;
            }

            $_POST['temp'] = '1';
            $this->form_validation->set_rules('temp', '', 'trim|required|xss_clean');
            // print_R($_POST);
            if ((!isset($_POST['shiprocket_shipping_method']) && !isset($_POST['local_shipping_method']))) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'Please select atleast one shipping method';
                print_r(json_encode($this->response));
                return false;
            }
            if (isset($_POST['shiprocket_shipping_method']) == "on") {
                $this->form_validation->set_rules('email', ' Email ', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', ' Password ', 'trim|required|xss_clean');
                $this->form_validation->set_rules('webhook_token', ' Token ', 'trim|xss_clean');
            }

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                $this->Setting_model->update_shipping_method($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'System Setting Updated Successfully';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
