<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Flash_sale_model extends CI_Model
{
    function add_flash_sale($data)
    {
        $data = escape_array($data);
        //print_R($data);
        $slug   = create_unique_slug($data['title'], 'flash_sale');

        // check for flash sale status

        $today = date('Y-m-d H:i:s');
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        //seperate start_date into date and time
        $timestemp = strtotime($start_date);
        $date = date('Y-m-d H:i', $timestemp);
        //seperate current_date into date and time
        $timestemp = strtotime($today);
        $curr_date = date('Y-m-d H:i', $timestemp);
        //seperate end_date into date and time
        $timestemp = strtotime($end_date);
        $date1 = date('Y-m-d H:i', $timestemp);
        // end
        if ($date <= $curr_date) {
            $sale_data = [
                'title' => $data['title'],
                'slug' => $slug,
                'short_description' => $data['short_description'],
                'discount' => $data['discount'],
                'image' => (isset($data['image']) ?? !empty($data['image'])) ? $data['image'] : "",
                'product_ids' => (isset($data['product_ids']) && !empty($data['product_ids'])) ? implode(',', $data['product_ids']) : null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => 1,
            ];
        } else if ($date >= $curr_date) {
            $sale_data = [
                'title' => $data['title'],
                'slug' => $slug,
                'short_description' => $data['short_description'],
                'discount' => $data['discount'],
                'image' => (isset($data['image']) ?? !empty($data['image'])) ? $data['image'] : "",
                'product_ids' => (isset($data['product_ids']) && !empty($data['product_ids'])) ? implode(',', $data['product_ids']) : null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => 2,
            ];
        }

        if (isset($data['edit_flash_sale'])) {
            $old_featured_data = fetch_details('flash_sale', ['id' => $data['edit_flash_sale']], 'product_ids');
            $is_on_sale_id = (explode(',', $old_featured_data[0]['product_ids']));
            foreach ($is_on_sale_id as $product_id) {
                update_details(['is_on_sale' => 0], ['id' => $product_id], 'products');
                update_details(['sale_discount' => 0], ['id' => $product_id], 'products');
                update_details(['sale_start_date' => $sale_data['start_date']], ['id' => $product_id], 'products');
                update_details(['sale_end_date' => $sale_data['end_date']], ['id' => $product_id], 'products');
            }
            $this->db->set($sale_data)->where('id', $data['edit_flash_sale'])->update('flash_sale');
            $is_on_sale_id = (explode(',', $sale_data['product_ids']));
            foreach ($is_on_sale_id as $product_id) {
                update_details(['is_on_sale' => 1], ['id' => $product_id], 'products');
                update_details(['sale_discount' => $sale_data['discount']], ['id' => $product_id], 'products');
                update_details(['sale_start_date' => $sale_data['start_date']], ['id' => $product_id], 'products');
                update_details(['sale_end_date' => $sale_data['end_date']], ['id' => $product_id], 'products');
            }
        } else {
            $is_on_sale_id = (explode(',', $sale_data['product_ids']));
            foreach ($is_on_sale_id as $product_id) {
                // print_R($product_id);
                update_details(['is_on_sale' => 1], ['id' => $product_id], 'products');
                update_details(['sale_discount' => $sale_data['discount']], ['id' => $product_id], 'products');
                update_details(['sale_start_date' => $sale_data['start_date']], ['id' => $product_id], 'products');
                update_details(['sale_end_date' => $sale_data['end_date']], ['id' => $product_id], 'products');
            }
            $this->db->insert('flash_sale', $sale_data);
        }
    }

    public function get_flash_list()
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
            $multipleWhere = ['id' => $search, 'title' => $search, 'short_description' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $city_count = $count_res->get('flash_sale')->result_array();

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

        $city_search_res = $search_res->order_by($sort, "asc")->limit($limit, $offset)->get('flash_sale')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($city_search_res as $row) {
            $row = output_escaping($row);
            $operate = "";

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href=' . base_url('admin/flash_sale/view_sale') . '?edit_id=' . $row['id'] . '><i class="fa fa-eye"></i> View</a>
              <a href="javascript:void(0)" class=" dropdown-item" id="delete-flash-sale" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';

            if ($row['status'] !== '0') {
                $operate = '<div class="dropdown">
                <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                 <a href="javascript:void(0)" class="edit_btn dropdown-item" title="Edit" data-id="' . $row['id'] . '" data-url="admin/Flash_sale/"><i class="fa fa-pen"></i> Edit</a>
                 
                 <a class="dropdown-item" href=' . base_url('admin/flash_sale/view_sale') . '?edit_id=' . $row['id'] . '><i class="fa fa-eye"></i> View</a>
                 
                 <a href="javascript:void(0)" class=" dropdown-item" id="delete-flash-sale" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';
            }
            // $operate .= "<a href='./view_sale?edit_id=" . $row['id'] . "'  class='btn action-btn btn-primary btn-xs mr-1 mb-1' title='View'><i class='fa fa-eye'></i></a>";
            // $operate .= ' <a  href="javascript:void(0)" class="btn action-btn btn-danger btn-xs mr-1 mb-1" title="Delete" data-id="' . $row['id'] . '" id="delete-flash-sale" ><i class="fa fa-trash"></i></a>';
            $tempRow['id'] = $row['id'];
            $tempRow['title'] = $row['title'];
            $tempRow['slug'] = $row['slug'];
            $tempRow['short_description'] = $row['short_description'];
            $tempRow['discount'] = $row['discount'];
            $tempRow['product_ids'] = $row['product_ids'];
            if (empty($row['image'])) {
                $row['image'] = '';
            } else {
                if (file_exists(FCPATH . $row['image']) == FALSE) {
                    $row['image'] = base_url() . NO_IMAGE;
                } else {
                    $row['image'] = base_url() . $row['image'];
                }
            }
            $tempRow['image_src'] = $row['image'];
            $tempRow['image'] = "<a href='" . $row['image'] . "' data-toggle='lightbox' class='image-box-100'> <img src='" . $row['image'] . "' class='img-fluid rounded '></a>";
            $tempRow['start_date'] = $row['start_date'];
            $tempRow['end_date'] = $row['end_date'];
            $tempRow['date'] = $row['date_added'];
            if ($row['status'] == '1') {
                $tempRow['status'] = '<a class="badge bg-success text-white" >Active</a>';
            } else if ($row['status'] == '2') {
                $tempRow['status'] = '<a class="badge bg-secondary text-white" >Upcoming</a>';
            } else {
                $tempRow['status'] = '<a class="badge bg-danger text-white" >Deactive</a>';
            }
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }


        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }


    function get_flash_sale($id = NULL, $limit = 25, $offset = 0, $sort = 'id', $order = 'DESC', $slug = '', $search = '', $p_limit = 10, $p_offset = 0, $p_sort = 'pid', $p_order = 'DESC')
    {
        $count_res = $this->db->select('COUNT(id) as `total`')->where_in('status', ['1', '2']);
        $cat_count = $count_res->get('flash_sale')->result_array();

        // foreach ($cat_count as $row) {
        $total = $cat_count[0]['total'];
        // }
        // $search_res = $this->db->select('*')->where_in('status', ['1', '2'])->get('flash_sale')->result_array();
        $cat_search_res = $this->db->select('*')->where_in('status', ['1', '2'])->limit($limit, $offset)->get('flash_sale')->result_array();
        $rows = $tempRow = $bulkData = array();
        $bulkData['error'] = (empty($cat_search_res)) ? true : false;
        $bulkData['message'] = (empty($cat_search_res)) ? 'Flash  sale does not exist' : 'Flash sale retrieved successfully';
        $bulkData['total'] = (empty($cat_search_res)) ? 0 : $total;
        if (!empty($cat_search_res)) {
            foreach ($cat_search_res as $row) {
                $curr_time = date('y-m-d H:i:s');

                $row = output_escaping($row);
                $tempRow['id'] = $row['id'];
                $tempRow['title'] = $row['title'];
                $tempRow['slug'] = $row['slug'];
                $tempRow['short_description'] = $row['short_description'];
                $tempRow['discount'] = $row['discount'];
                $tempRow['product_ids'] = $row['product_ids'];

                if (empty($row['image'])) {
                    $row['image'] = '';
                } else {
                    if (file_exists(FCPATH . $row['image']) == FALSE) {
                        $row['image'] = base_url() . NO_IMAGE;
                    } else {
                        $row['image'] = base_url() . $row['image'];
                    }
                }
                $tempRow['image_src'] = $row['image'];
                $tempRow['image'] = "<a href='" . $row['image'] . "' data-toggle='lightbox'> <img src='" . $row['image'] . "' class='img-fluid rounded'></a>";

                $tempRow['server_time'] = $curr_time;
                $tempRow['start_date'] = $row['start_date'];
                $tempRow['end_date'] = $row['end_date'];

                $end_date_format = $row['end_date'];
                $end_date =  date('y-m-d H:i:s', strtotime($end_date_format));

                $dateTimeObject1 = date_create($end_date);
                $dateTimeObject2 = date_create($curr_time);
                // Calculating the difference between DateTime Objects
                $interval = date_diff($dateTimeObject1, $dateTimeObject2);

                $min = $interval->days * 24 * 60;
                $min += $interval->h * 60;
                $min += $interval->i;
                $tempRow['remaining_time'] =  $min;
                $tempRow['status'] = $row['status'];
                $tempRow['products'] = fetch_active_sale_product_data($tempRow['product_ids'], $row['discount'], $p_limit, $p_offset, $p_sort, $p_order);
                $rows[] = $tempRow;
            }
            $bulkData['data'] = $rows;
        } else {
            $bulkData['data'] = [];
        }
        return $bulkData;
    }
}
