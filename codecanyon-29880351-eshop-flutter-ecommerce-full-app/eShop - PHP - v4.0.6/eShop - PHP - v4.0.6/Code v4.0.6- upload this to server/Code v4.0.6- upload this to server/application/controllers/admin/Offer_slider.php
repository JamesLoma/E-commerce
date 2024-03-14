<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Offer_slider extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['offer_slider_model', 'offer_model']);

        if (!has_permissions('read', 'home_slider_images')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public  function index()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-offer-slider';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Offer Image | ' . $settings['app_name'] : 'Add Offer Slider | ' . $settings['app_name'];
            if (isset($_GET['edit_id'])) {
                $featured_data = fetch_details('offer_sliders', ['id' => $_GET['edit_id']]);
                $this->data['product_details'] = $this->db->where_in('id', explode(',', $featured_data[0]['offer_ids'] ?? ''))->get('offers')->result_array();
                $this->data['fetched_data'] = $featured_data;
                // print_R($this->data['product_details']);
            }

            $this->data['about_us'] = get_settings('about_us');
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function add_offer_slider()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (isset($_POST['edit_offer_slider'])) {
                if (print_msg(!has_permissions('update', 'offer_slider'), PERMISSION_ERROR_MSG, 'offer_slider')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'offer_slider'), PERMISSION_ERROR_MSG, 'offer_slider')) {
                    return false;
                }
            }

            $this->form_validation->set_rules('style', ' Style ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('offer_ids[]', ' Offer ', 'trim|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
            } else {
                $this->offer_slider_model->add_offer_slider($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $message = (isset($_POST['edit_offer_slider'])) ? 'Offer Slider Updated Successfully' : 'Offer Slider Added Successfully';
                $this->response['message'] = $message;
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_offer_slider_list()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->offer_slider_model->get_offer_slider_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_offer_slider()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (print_msg(!has_permissions('delete', 'offer_slider'), PERMISSION_ERROR_MSG, 'offer_slider', false)) {
                return false;
            }
            if (delete_details(['id' => $_GET['id']], 'offer_sliders') == TRUE) {
                $this->response['error'] = false;
                $this->response['message'] = 'Deleted Succesfully';
                print_r(json_encode($this->response));
            } else {
                $this->response['error'] = false;
                $this->response['message'] = 'Something Went Wrong';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function offer_slider_data()
    {
        $search = $this->input->get('search');
        $response = $this->offer_slider_model->get_offer_data($search);
        echo json_encode($response);
    }


    public function section_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'offer-section-order';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Section Order | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Section Order | ' . $settings['app_name'];
            $sections = $this->db->select('*')->order_by('row_order')->get('offer_sliders')->result_array();
            $this->data['section_result'] = $sections;
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_section_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                // if ($this->session->flashdata('message')) {
                $this->response['error'] = true;
                $this->response['message'] = DEMO_VERSION_MSG;
                echo json_encode($this->response);
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                return false;
                exit();
                // }
            }
            $i = 0;
            $temp = array();
            $flag = false;
            foreach ($_GET['section_id'] as $row) {
                $temp[$row] = $i;
                $data = [
                    'row_order' => $i
                ];
                $data = escape_array($data);
                $this->db->where(['id' => $row])->update('offer_sliders', $data);
                $i++;
                $flag = true;
            }
            if ($flag == true) {
                $this->response['error'] = false;
                $this->response['message'] = "Offer Section order update successfully";
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                echo json_encode($this->response);
                return false;
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Offer Section Order not updated.";
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                echo json_encode($this->response);
                return false;
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
