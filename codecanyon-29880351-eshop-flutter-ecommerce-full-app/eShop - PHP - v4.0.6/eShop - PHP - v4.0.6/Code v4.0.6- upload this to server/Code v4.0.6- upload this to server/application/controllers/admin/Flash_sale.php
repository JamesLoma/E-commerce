<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Flash_sale extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['Flash_sale_model', 'Product_model']);
        if (!has_permissions('read', 'flash_sale')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'flash_sale';
            $settings = get_settings('system_settings', true);
            $res = fetch_active_flash_sale();
            $this->data['title'] = 'Flash Sale Management | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Flash Sale Management  | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();
            if (isset($_GET['edit_id'])) {
                $featured_data = fetch_details('flash_sale', ['id' => $_GET['edit_id']]);
                $this->data['product_details'] = $this->db->where_in('id', explode(',', $featured_data[0]['product_ids'] ?? ''))->get('products')->result_array();
                $this->data['fetched_data'] = $featured_data;
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function add_flash_sale()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (isset($_POST['edit_flash_sale'])) {
                if (print_msg(!has_permissions('update', 'flash_sale'), PERMISSION_ERROR_MSG, 'flash_sale')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'flash_sale'), PERMISSION_ERROR_MSG, 'flash_sale')) {
                    return false;
                }
            }

            $is_image_included = (isset($_POST['image_checkbox']) && $_POST['image_checkbox'] == 'on') ? TRUE : FALSE;
            if ($is_image_included) {
                $this->form_validation->set_rules('image', 'Image', 'trim|required|xss_clean', array('required' => 'Image is required'));
            }

            $this->form_validation->set_rules('title', ' Title ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('short_description', ' Short Description ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount', ' Discount ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_ids[]', ' Product ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('start_date', 'Start date ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('end_date', 'End date ', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
            } else {
                if ($_POST['start_date'] > $_POST['end_date']) {
                    $this->response['error'] = true;
                    $this->response['csrfName'] = $this->security->get_csrf_token_name();
                    $this->response['csrfHash'] = $this->security->get_csrf_hash();
                    $this->response['message'] = "End Date must be greater than Start Date";
                    print_r(
                        json_encode($this->response)
                    );
                    return;
                }

                $this->Flash_sale_model->add_flash_sale($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $message = (isset($_POST['edit_flash_sale'])) ? 'Sale Updated Successfully' : 'Sale Added Successfully';
                $this->response['message'] = $message;
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_flash_list()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Flash_sale_model->get_flash_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_flash_sale()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (print_msg(!has_permissions('delete', 'flash_sale'), PERMISSION_ERROR_MSG, 'flash_sale', false)) {
                return false;
            }
            $featured_data = fetch_details('flash_sale', ['id' => $_GET['id']], 'product_ids');
            $is_on_sale_id = (explode(',', $featured_data[0]['product_ids']));
            foreach ($is_on_sale_id as $product_id) {
                update_details(['is_on_sale' => 0], ['id' => $product_id], 'products');
                update_details(['sale_discount' => 0], ['id' => $product_id], 'products');
            }
            if (delete_details(['id' => $_GET['id']], 'flash_sale') == TRUE) {
                //if (update_details(['status' => 0], ['id' => $_GET['id']], 'flash_sale') == TRUE) {
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

    public function view_sale()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['main_page'] = VIEW . 'flash-sale';
                $settings = get_settings('system_settings', true);
                $this->data['title'] = 'View Flash Sale | ' . $settings['app_name'];
                $this->data['meta_description'] = 'View Flash Sale | ' . $settings['app_name'];
                //$res = fetch_product($user_id = NULL, $filter = NULL, $this->input->get('edit_id', true));
                $res = fetch_details('flash_sale', ['id' => $_GET['edit_id']], '*');
                $this->data['sale_details'] = $res[0];
                if (!empty($res)) {
                    $this->load->view('admin/template', $this->data);
                } else {
                    redirect('admin/flash_sale', 'refresh');
                }
            } else {
                redirect('admin/flash_sale', 'refresh');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
