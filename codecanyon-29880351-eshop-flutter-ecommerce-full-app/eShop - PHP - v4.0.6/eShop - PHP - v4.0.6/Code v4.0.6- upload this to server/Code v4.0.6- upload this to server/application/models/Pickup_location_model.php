<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Pickup_location_model extends CI_Model
{

    function add_pickup_location($data)
    {
        $data = escape_array($data);
        $pickup_location_data = [
            'pickup_location' => $data['pickup_location'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'address_2' => $data['address2'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'pin_code' => $data['pincode'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ];
        if (isset($data['edit_pickup_location'])) {
            $this->db->set($pickup_location_data)->where('id', $data['edit_pickup_location'])->update('pickup_locations');
        } else {
            $this->db->insert('pickup_locations', $pickup_location_data);

            //    send add_pickup_location request in shiprocket

            $this->load->library(['shiprocket']);
            $this->shiprocket->add_pickup_location($pickup_location_data);
        }
    }

    public function get_list($table)
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
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
            if ($table == 'pickup_locations') {
                $multipleWhere = ['pickup_locations.id' => $search, 'pickup_locations.name' => $search, 'pickup_locations.email' => $search, 'pickup_locations.phone' => $search];
            }
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');



        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $city_count = $count_res->get($table)->result_array();

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

        $city_search_res = $search_res->order_by($sort, "asc")->limit($limit, $offset)->get($table)->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $url = 'manage_' . $table;
        foreach ($city_search_res as $row) {
            //print_r($row);
            $row = output_escaping($row);

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a href="javascript:void(0)" class="edit_btn dropdown-item" title="Edit" data-id="' . $row['id'] . '" data-url="admin/Pickup_location/' . $url . '"><i class="fa fa-pen"></i> Edit</a>
              <a href="javascript:void(0)" class=" dropdown-item" id="delete-location" data-id=' . $row['id'] . ' data-table="' . $table . '" title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';


            // $operate = ' <a href="javascript:void(0)" class="edit_btn  btn action-btn image.png btn-success btn-xs mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '" data-url="admin/Pickup_location/' . $url . '"><i class="fa fa-pen"></i></a>';

            // if ($row['status'] == '1') {
            //     $verify = '<a class="btn btn-success btn-xs update_active_status mr-1" data-table="pickup_locations" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fas fa-check-square"></i></a>';
            // } else {
            //     $verify = '<a class="btn btn-danger mr-1 btn-xs update_active_status" data-table="pickup_locations" href="javascript:void(0)" title="Active" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fas fa-times"></i></a>';
            // }



            if ($row['status'] == '1') {
                $verify = '<a class="badge bg-success text-white" ></a>';
                $verify .= '<a class="form-switch update_active_status " data-table="pickup_locations" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" checked></a>';
            } else {
                $verify = '<a class="badge bg-danger text-white" ></a>';
                $verify .= '<a class="form-switch update_active_status mr-1 mb-1" data-table="pickup_locations" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><input class="form-check-input " type="checkbox" role="switch" ></a>';
            }


            // $operate .= '  <a  href="javascript:void(0)" class=" btn action-btn image.png btn-danger btn-xs mr-1 mb-1" title="Delete" id="delete-location" data-table="' . $table . '" data-id="' . $row['id'] . '" ><i class="fa fa-trash"></i></a>';
            $tempRow['id'] = $row['id'];
            $tempRow['pickup_location'] = $row['pickup_location'];
            $tempRow['name'] = $row['name'];
            $tempRow['email'] = $row['email'];
            $tempRow['phone'] = $row['phone'];
            $tempRow['address'] = $row['address'];
            $tempRow['address2'] = $row['address_2'];
            $tempRow['city'] = $row['city'];
            $tempRow['state'] = $row['state'];
            $tempRow['country'] = $row['country'];
            $tempRow['pin_code'] = $row['pin_code'];
            $tempRow['verified'] = $verify;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
