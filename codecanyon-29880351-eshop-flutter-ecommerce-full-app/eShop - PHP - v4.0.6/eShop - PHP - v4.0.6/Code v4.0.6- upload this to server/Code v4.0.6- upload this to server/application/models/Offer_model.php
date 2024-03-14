<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Offer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    function add_offer($image_name)
    {
        $image_name = escape_array($image_name);
        $offer_data = [
            'type' => $image_name['offer_type'],
            'image' => $image_name['image'],
        ];
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'categories' && isset($image_name['category_id']) && !empty($image_name['category_id'])) {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
            $offer_data['type_id'] = $image_name['category_id'];
        }
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'brand' && isset($image_name['brand_id']) && !empty($image_name['brand_id'])) {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
            $offer_data['type_id'] = $image_name['brand_id'];
        }

        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'products' && isset($image_name['product_id']) && !empty($image_name['product_id'])) {
            $offer_data['type_id'] = $image_name['product_id'];
        }
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'offer_url' && isset($image_name['link']) && !empty($image_name['link'])) {
            $offer_data['link'] = $image_name['link'];
            $offer_data['type_id'] = 0;
        }
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'all_products') {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
        }
        if (isset($image_name['edit_offer'])) {
            if (empty($image_name['image'])) {
                unset($offer_data['image']);
            }
            $this->db->set($offer_data)->where('id', $image_name['edit_offer'])->update('offers');
        } else {
            $this->db->insert('offers', $offer_data);
        }
    }
    function add_popup_offer($image_name)
    {
        // print_R($image_name);
        // return;
        $image_name = escape_array($image_name);
        $offer_data = [
            'type' => $image_name['offer_type'],
            'image' => $image_name['image'],
        ];
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'categories' && isset($image_name['category_id']) && !empty($image_name['category_id'])) {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
            $offer_data['type_id'] = $image_name['category_id'];
        }
        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'brand' && isset($image_name['brand_id']) && !empty($image_name['brand_id'])) {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
            $offer_data['type_id'] = $image_name['brand_id'];
        }

        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'products' && isset($image_name['product_id']) && !empty($image_name['product_id'])) {
            $offer_data['type_id'] = $image_name['product_id'];
        }
        if ((isset($image_name['popup_offer_status']) && $image_name['popup_offer_status'] == 'on')) {
            $offer_data['status'] = 1;
            update_details(['status' => 0], ['status' => 1], 'popup_offers');
        } else if (empty($image_name['popup_offer_status'])) {
            $offer_data['status'] = 0;
        }

        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'offer_url' && isset($image_name['link']) && !empty($image_name['link'])) {
            $offer_data['link'] = $image_name['link'];
            $offer_data['type_id'] = 0;
        }


        if (isset($image_name['offer_type']) && $image_name['offer_type'] == 'all_products') {
            $offer_data['min_discount'] = $image_name['min_discount'];
            $offer_data['max_discount'] = $image_name['max_discount'];
        }
        if (isset($image_name['edit_offer'])) {
            if (empty($image_name['image'])) {
                unset($offer_data['image']);
            }
            $this->db->set($offer_data)->where('id', $image_name['edit_offer'])->update('offers');
        } else {
            $this->db->insert('popup_offers', $offer_data);
        }
    }
    function get_offer_list()
    {

        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DES';
        $multipleWhere = '';


        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['`id`' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $offer_count = $count_res->get('offers')->result_array();

        foreach ($offer_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select(' * ');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $offer_search_res = $search_res->order_by($sort, "des")->limit($limit, $offset)->get('offers')->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($offer_search_res as $row) {
            $row = output_escaping($row);
            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href=' . base_url('admin/offer') . '?edit_id=' . $row['id'] . '><i class="fa fa-pen"></i> Edit</a>
              <a href="javascript:void(0)" class="delete-brand dropdown-item" id="delete-offer" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';

            // $operate = ' <a href="' . base_url('admin/offer?edit_id=' . $row['id']) . '" class="btn action-btn btn-success btn-xs mr-1 mb-1"  title="Edit" data-id="' . $row['id'] . '" data-url="admin/offer/"><i class="fa fa-pen"></i></a>';
            // $operate .= ' <a href="javaScript:void(0)" id="delete-offer" class="btn action-btn btn-danger btn-xs mr-1 mb-1" title="Delete" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row['id'];
            $tempRow['type'] = $row['type'];
            $tempRow['type_id'] = $row['type_id'];

            $tempRow['min_discount'] = $row['min_discount'];
            $tempRow['max_discount'] = $row['max_discount'];
            $tempRow['link'] = $row['link'];
            if (empty($row['image']) || file_exists(FCPATH . $row['image']) == FALSE) {
                $row['image'] = base_url() . NO_IMAGE;
                $row['image_main'] = base_url() . NO_IMAGE;
            } else {
                $row['image_main'] = base_url($row['image']);
                $row['image'] = get_image_url($row['image'], 'thumb', 'sm');
            }
            $tempRow['image'] = "<div class='image-box-100' ><a href='" . $row['image_main'] . "' data-toggle='lightbox' data-gallery='gallery'> <img src='" . $row['image'] . "' class='mh-100' ></a></div>";

            $tempRow['date_added'] = $row['date_added'];
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_popup_offer_list()
    {

        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DES';
        $multipleWhere = '';


        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['`id`' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $offer_count = $count_res->get('popup_offers')->result_array();

        foreach ($offer_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select(' * ');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $offer_search_res = $search_res->order_by($sort, "des")->limit($limit, $offset)->get('popup_offers')->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($offer_search_res as $row) {

            $row = output_escaping($row);

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
             
              <a href="javascript:void(0)" class=" dropdown-item" id="delete-popup-offer" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';

            // $operate = ' <a href="javaScript:void(0)" id="delete-popup-offer" class="btn action-btn btn-danger btn-xs mr-1 mb-1" title="Delete" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i></a>';


            $tempRow['id'] = $row['id'];
            $tempRow['type'] = $row['type'];
            $tempRow['type_id'] = $row['type_id'];
            $tempRow['min_discount'] = $row['min_discount'];
            $tempRow['max_discount'] = $row['max_discount'];
            $tempRow['link'] = $row['link'];

            if ($row['status'] == '1') {
                $tempRow['status'] = '<a class="badge bg-success text-white" ></a>';
                $tempRow['status'] .= '<a class="form-switch update_offer_active_status " data-table="popup_offers" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" checked></a>';
            } else {
                $tempRow['status'] = '<a class="badge bg-danger text-white" ></a>';
                $tempRow['status'] .= '<a class="form-switch update_offer_active_status mr-1 mb-1" data-table="popup_offers" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" ></a>';
            }


            // if ($row['status'] == '1') {
            //     $tempRow['status'] = '<a class="badge bg-success text-white" >Active</a>';
            //     $operate .= '<a class="btn action-btn btn-warning btn-xs update_offer_active_status mr-1 mb-1" data-table="popup_offers" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye-slash"></i></a>';
            // } else {
            //     $tempRow['status'] = '<a class="badge bg-danger text-white" >Inactive</a>';
            //     $operate .= '<a class="btn action-btn btn-primary mr-1 mb-1 btn-xs update_offer_active_status" data-table="popup_offers" href="javascript:void(0)" title="Active" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye"></i></a>';
            // }
            if (empty($row['image']) || file_exists(FCPATH . $row['image']) == FALSE) {
                $row['image'] = base_url() . NO_IMAGE;
                $row['image_main'] = base_url() . NO_IMAGE;
            } else {
                $row['image_main'] = base_url($row['image']);
                $row['image'] = get_image_url($row['image'], 'thumb', 'sm');
            }
            $tempRow['image'] = "<div class='image-box-100' ><a href='" . $row['image_main'] . "' data-toggle='lightbox' data-gallery='gallery'> <img src='" . $row['image'] . "' class='mh-100' ></a></div>";

            $tempRow['date_added'] = $row['date_added'];
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
