<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Offer_slider_model extends CI_Model
{
    function add_offer_slider($data)
    {
        $data = escape_array($data);
        $offer_data = [
            'offer_ids' => (isset($data['offer_ids']) && !empty($data['offer_ids'])) ? implode(',', $data['offer_ids']) : '',
            'style' => $data['style'],
        ];

        if (isset($data['edit_offer_slider'])) {
            $this->db->set($offer_data)->where('id', $data['edit_offer_slider'])->update('offer_sliders');
        } else {
            $this->db->insert('offer_sliders', $offer_data);
        }
    }
    public function get_offer_slider_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'desc';
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
            $multipleWhere = ['id' => $search, 'style' => $search, 'offer_ids' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $city_count = $count_res->get('offer_sliders')->result_array();

        foreach ($city_count as $row) {
            $total = $row['total'];
        }



        $search_res = $this->db->select(' * ');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $city_search_res = $search_res->order_by($sort, "asc")->limit($limit, $offset)->get('offer_sliders')->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($city_search_res as $row) {
            $row = output_escaping($row);

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a href="javascript:void(0)" class="edit_btn dropdown-item" title="Edit" data-id="' . $row['id'] . '" data-url="admin/offer_slider/"><i class="fa fa-pen"></i> Edit</a>
              <a href="javascript:void(0)" class=" dropdown-item" id="delete-offer-slider" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';



            // $operate = ' <a href="javascript:void(0)" class="edit_btn btn action-btn btn-primary btn-xs mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '" data-url="admin/offer_slider/"><i class="fa fa-pen"></i></a>';
            // $operate .= ' <a  href="javascript:void(0)" class="btn action-btn btn-danger btn-xs mr-1 mb-1" title="Delete" data-id="' . $row['id'] . '" id="delete-offer-slider" ><i class="fa fa-trash"></i></a>';
            $tempRow['id'] = $row['id'];
            $tempRow['style'] = ucfirst(str_replace('_', ' ', $row['style']));
            $tempRow['offer_ids'] = $row['offer_ids'];
            $tempRow['date'] = $row['date_added'];
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_offer_data($search_term = "")
    {
        $where = " (id like '%" . $search_term . "%') or type like '%" . $search_term . "%' ";
        // Fetch offers
        $this->db->select('*');
        $this->db->where($where);
        $fetched_records = $this->db->get('offers');
        $offers = $fetched_records->result_array();

        // 
        $this->db->select('count(`id`) as total');
        $this->db->where($where);
        $fetched_records = $this->db->get('offers');
        $offers_count = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        $data['total'] = $offers_count[0]['total'];

        foreach ($offers as $offer) {
            $image = base_url($offer['image']);
            $min_discount = isset($offer['min_discount']) && !empty($offer['min_discount']) ? $offer['min_discount'] : "0";
            $max_discount = isset($offer['max_discount']) && !empty($offer['max_discount']) ? $offer['max_discount'] : "0";
            $html =  '<div class="mx-auto product-image"><img src="' . $image . '" class="img-fluid rounded"></div>';
            $data['data'][] = array(
                "id" => $offer['id'],
                "type" => $offer['type'],
                "min_discount" => $min_discount,
                "max_discount" => $max_discount,
                "image" => $image,
                "text" => $html
            );
        }
        return $data;
    }
}
