<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['Brand_model']);

        if (!has_permissions('read', 'brands')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'brand';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Brand Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Brand Management | ' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function create_brand()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'brand';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Brand | ' . $settings['app_name'] : 'Add Brand | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Brand , Create Brand | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('brands', ['id' => $_GET['edit_id']]);
            }
            $this->load->model(['Brand_model']);
            // $this->data['brands'] = $this->Brand_model->get_brands();

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function add_brand()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (isset($_POST['edit_brand'])) {
                if (print_msg(!has_permissions('update', 'brands'), PERMISSION_ERROR_MSG, 'brands')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'brands'), PERMISSION_ERROR_MSG, 'brands')) {
                    return false;
                }
            }

            $this->form_validation->set_rules('brand_input_name', 'name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('brand_input_image', 'Image', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {

                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                if (isset($_POST['edit_brand'])) {
                    if (is_exist(['name' => $_POST['brand_input_name']], 'brands', $_POST['edit_brand'])) {
                        $response["error"]   = true;
                        $response["message"] = "Name Already Exist ! Provide a unique name";
                        $response["data"] = array();
                        echo json_encode($response);
                        return false;
                    }
                } else {
                    if (!$this->form_validation->is_unique($_POST['brand_input_name'], 'brands.name')) {
                        $response["error"]   = true;
                        $response["message"] = "Name Already Exist ! Provide a unique name";
                        $response["data"] = array();
                        echo json_encode($response);
                        return false;
                    }
                }

                $this->Brand_model->add_brand($_POST);
                $this->response['error'] = false;
                $message = (isset($_POST['edit_brand'])) ? 'Brand Updated Successfully' : 'Brand Added Successfully';
                $this->response['message'] = $message;
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    function delete_brand()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (print_msg(!has_permissions('delete', 'brands'), PERMISSION_ERROR_MSG, 'brands')) {
                return false;
            }
            if ($this->Brand_model->delete_brand($_GET['id']) == TRUE) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'Deleted Succesfully';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function brand_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Brand_model->get_brand_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
