<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Popup_offer extends CI_Controller
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
            $this->data['main_page'] = TABLES . 'manage-popup-offer';
            $settings = get_settings('system_settings', true);
            $this->data['categories'] = $this->category_model->get_categories();
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Offer Image | ' . $settings['app_name'] : 'Add Popup Offer | ' . $settings['app_name'];
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

    public function add_offer()
    {
        if (isset($_POST['edit_offer'])) {
            if (print_msg(!has_permissions('update', 'new_offer_images'), PERMISSION_ERROR_MSG, 'new_offer_images')) {
                return false;
            }
        } else {
            if (print_msg(!has_permissions('create', 'new_offer_images'), PERMISSION_ERROR_MSG, 'new_offer_images')) {
                return false;
            }
        }

        $this->form_validation->set_rules('offer_type', 'Offer Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('image', 'Offer Image', 'trim|required|xss_clean', array('required' => 'Offer image is required'));

        if (isset($_POST['offer_type']) && $_POST['offer_type'] == 'offer_url') {
            $this->form_validation->set_rules('link', 'Link', 'trim|required|xss_clean');
        }

        if (isset($_POST['offer_type']) && $_POST['offer_type'] == 'categories' ?? '') {
            $this->form_validation->set_rules('min_discount', 'Min Discount ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('max_discount', 'Max Discount ', 'trim|required|xss_clean');
        } else if (isset($_POST['offer_type']) && $_POST['offer_type'] == 'all_products' ?? '') {
            $this->form_validation->set_rules('min_discount', 'Min Discount ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('max_discount', 'Max Discount ', 'trim|required|xss_clean');
        } else if (isset($_POST['offer_type']) && $_POST['offer_type'] == 'brand' ?? '') {
            $this->form_validation->set_rules('min_discount', 'Min Discount ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('max_discount', 'Max Discount ', 'trim|required|xss_clean');
        }
        if (!$this->form_validation->run()) {
            $this->response['error'] = true;
            $this->response['csrfName'] = $this->security->get_csrf_token_name();
            $this->response['csrfHash'] = $this->security->get_csrf_hash();
            $this->response['message'] = validation_errors();
            print_r(json_encode($this->response));
        } else {
            $this->offer_model->add_popup_offer($_POST);

            $this->response['error'] = false;
            $this->response['csrfName'] = $this->security->get_csrf_token_name();
            $this->response['csrfHash'] = $this->security->get_csrf_hash();
            $message = (isset($_POST['edit_offer'])) ? 'Offer Image Update Successfully' : 'Offer Image Added Successfully';
            $this->response['message'] = $message;
            print_r(json_encode($this->response));
        }
    }

    public function view_offers()
    {
        return $this->offer_model->get_popup_offer_list();
    }

    public function delete_offer()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'new_offer_images'), PERMISSION_ERROR_MSG, 'new_offer_images', false)) {
                return false;
            }
            if (delete_details(['id' => $_GET['id']], 'popup_offers') == TRUE) {
                $this->response['error'] = false;
                $this->response['message'] = 'Deleted Succesfully';
            } else {
                $this->response['error'] = true;
                $this->response['message'] = 'Something Went Wrong';
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function update_status()
    {
        // print_R($_GET);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                $this->response['error'] = true;
                $this->response['message'] = DEMO_VERSION_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }
            $data = fetch_details('popup_offers', '', 'status');
            $status = array_column($data, "status");
            // print_R($status);
            if ($_GET['status'] == '0') {
                if (in_array(1, $status)) {
                    // echo "here";
                    $response['error'] = 'true';
                    $response['csrfName'] = $this->security->get_csrf_token_name();
                    $response['csrfHash'] = $this->security->get_csrf_hash();
                    $response['message'] = 'You can active only one popup offer at a time';
                    print_r(json_encode($response));
                    return false;
                }
            }
            $_GET['status'] = ($_GET['status'] == '1') ? 0 : 1;
            $this->db->trans_start();
            if ($_GET['table'] == 'users') {
                $this->db->set('active', $this->db->escape($_GET['status']));
            } else {
                $this->db->set('status', $this->db->escape($_GET['status']));
            }

            $this->db->where('id', $_GET['id'])->update($_GET['table']);
            $this->db->trans_complete();
            $error = false;
            $message = str_replace('_', ' ', $_GET['table']);
            if ($this->db->trans_status() === true) {
                $error = true;
            }
            $response['error'] = $error;
            $response['csrfName'] = $this->security->get_csrf_token_name();
            $response['csrfHash'] = $this->security->get_csrf_hash();
            $response['message'] = $message;
            print_r(json_encode($response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
