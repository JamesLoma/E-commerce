<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Client_apikeys_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    public function set($data)
    {
        $this->load->helper('string');
        $secret_key = random_string('sha1', 40);

        $client_data = [
            'name' => $data['name'],
            'secret' => $secret_key
        ];
        if (isset($data['edit_client_api_keys'])) {
            unset($client_data['secret']);
            $this->db->set($client_data)->where('id', $data['edit_client_api_keys'])->update('client_api_keys');
        } else {
            $this->db->insert('client_api_keys', $client_data);
        }
    }

    public function get_list()
    {

        $offset = 0;
        $limit = 10;
        $sort = 'u.id';
        $order = 'ASC';
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
            $multipleWhere = ['id' => $search, 'name' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $city_count = $count_res->get('client_api_keys')->result_array();

        foreach ($city_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select('*');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $client_search_res = $search_res->order_by($sort, "desc")->limit($limit, $offset)->get('client_api_keys')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($client_search_res as $row) {
            $row = output_escaping($row);

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a href="javascript:void(0)" class="edit_btn  dropdown-item" title="Edit" data-id="' . $row['id'] . '" data-url="admin/client_api_keys/"><i class="fa fa-pen"></i> Edit</a>
                <a href="javascript:void(0)" class="dropdown-item" id="delete-client" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';

            if ($row['status'] == '1') {
                $tempRow['status'] = '<a class="badge bg-success text-white" ></a>';
                $tempRow['status'] .= '<a class="form-switch update_active_status " data-table="client_api_keys" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" checked></a>';
            } else {
                $tempRow['status'] = '<a class="badge bg-danger text-white" ></a>';
                $tempRow['status'] .= '<a class="form-switch update_active_status mr-1 mb-1" data-table="client_api_keys" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" ></a>';
            }



            // $operate = ' <a href="javascript:void(0)" class="edit_btn  btn btn-success btn-xs mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '" data-url="admin/client_api_keys/"><i class="fa fa-pen"></i></a>';
            // $operate .= '<a  href="javascript:void(0)" class=" btn btn-danger btn-xs mr-1 mb-1" title="Delete" id="delete-client" data-table="client_api_keys" data-id="' . $row['id'] . '" ><i class="fa fa-trash"></i></a>';
            // if ($row['status'] == '1') {
            //     $tempRow['status'] = '<a class="badge bg-success text-white" >Active</a>';
            //     $operate .= '<a class="btn btn-warning btn-xs update_active_status mr-1" data-table="client_api_keys" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye-slash"></i></a>';
            // } else {
            //     $tempRow['status'] = '<a class="badge bg-danger text-white" >Inactive</a>';
            //     $operate .= '<a class="btn btn-primary mr-1 btn-xs update_active_status" data-table="client_api_keys" href="javascript:void(0)" title="Active" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye"></i></a>';
            // }
            $tempRow['id'] = $row['id'];
            $tempRow['name'] = $row['name'];
            $tempRow['secret'] = $row['secret'];
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
