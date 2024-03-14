<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Invoice_model extends CI_Model
{
    public function get_sales_list(
        $offset = 0,
        $limit = 10,
        $sort = " o.id ",
        $order = 'ASC'
    ) {

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        }
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $filters = [
                'u.username' => $search,
                'u.email' => $search,
                'u.mobile' => $search,
                'o.final_total' => $search,
                'o.date_added' => $search,
                'o.id' => $search,
            ];
        }

        $count_res = $this->db->select(' COUNT(o.id) as `total` ')->join(' `users` u', 'u.id= o.user_id');
        if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {

            $count_res->where(" DATE(date_added) >= DATE('" . $_GET['start_date'] . "') ");
            $count_res->where(" DATE(date_added) <= DATE('" . $_GET['end_date'] . "') ");
        }
        if (isset($_GET['order_status']) && !empty($_GET['order_status'])) {
            $status = trim($_GET['order_status']);
            $count_res->where(" o.active_status = '$status' ");
        }
        if (isset($filters) && !empty($filters)) {
            $this->db->group_Start();
            $count_res->or_like($filters);
            $this->db->group_End();
        }

        $sales_count = $count_res->get('`orders` o')->result_array();

        foreach ($sales_count as $row) {
            $total = $row['total'];
        }
        $search_res = $this->db->select(' o.* , u.username ,u.email,u.mobile  ')->join(' `users` u', 'u.id= o.user_id');

        if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $search_res->where(" DATE(date_added) >= DATE('" . $_GET['start_date'] . "') ");
            $search_res->where(" DATE(date_added) <= DATE('" . $_GET['end_date'] . "') ");
        }
        if (isset($_GET['order_status']) && !empty($_GET['order_status'])) {
            $status = trim($_GET['order_status']);
            $search_res->where(" o.active_status = '$status' ");
        }
        if (isset($filters) && !empty($filters)) {
            $search_res->group_Start();
            $search_res->or_like($filters);
            $search_res->group_End();
        }

        $user_details = $search_res->order_by($sort, "DESC")->limit($limit, $offset)->get('`orders` o')->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($user_details as $row) {
            $row = output_escaping($row);
            if (trim($row['active_status']) == 'awaiting') {
                $active_status = '<label class="badge bg-secondary">' . $row['active_status'] . '</label>';
            }
            if ($row['active_status'] == 'received') {
                $active_status = '<label class="badge bg-primary">' . $row['active_status'] . '</label>';
            }
            if ($row['active_status'] == 'processed') {
                $active_status = '<label class="badge bg-info">' . $row['active_status'] . '</label>';
            }
            if ($row['active_status'] == 'shipped') {
                $active_status = '<label class="badge bg-warning">' . $row['active_status'] . '</label>';
            }
            if ($row['active_status'] == 'delivered') {
                $active_status = '<label class="badge bg-success">' . $row['active_status'] . '</label>';
            }
            if ($row['active_status'] == 'returned' || $row['active_status'] == 'cancelled') {
                $active_status = '<label class="badge bg-danger">' . $row['active_status'] . '</label>';
            }

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a href=' . base_url('admin/orders/edit_orders') . '?edit_id=' . $row['id'] . ' class="btn dropdown-item" title="View" ><i class="fa fa-eye"></i> View</a>

            <a href="' . base_url() . 'admin/invoice?edit_id=' . $row['id'] . '" class="btn dropdown-item" title="Invoice" ><i class="fa fa-file"></i> Invoice</a>

              <a href="javascript:void(0)" class="delete-orders dropdown-item" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';


            // $operate = '<a href=' . base_url('admin/orders/edit_orders') . '?edit_id=' . $row['id'] . ' class="btn action-btn btn-secondary btn-xs mr-1 mb-1" title="View" ><i class="fa fa-eye"></i></a>';
            // $operate .= '<a href="javascript:void(0)" class="delete-orders btn action-btn btn-danger btn-xs mr-1 mb-1" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i></a>';
            // $operate .= '<a href="' . base_url() . 'admin/invoice?edit_id=' . $row['id'] . '" class="btn action-btn btn-info btn-xs mr-1 mb-1" title="Invoice" ><i class="fa fa-file"></i></a>';

            $tempRow['operate'] = $operate;

            $tempRow['id'] = $row['id'];
            $tempRow['name'] = $row['username'];
            // $tempRow['mobile'] = $row['mobile'];
            $tempRow['address'] = $row['address'];
            $tempRow['mobile'] = (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) ? str_repeat("X", strlen($row['mobile']) - 3) . substr($row['mobile'], -3) : $row['mobile'];
            $tempRow['status'] = $active_status;
            $tempRow['date_added'] = $row['date_added'];
            $tempRow['final_total'] = '<span class="badge bg-danger">' . $row['final_total'] . '</span>';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    // inventory report
    public function inventory_list(
        $offset = 0,
        $limit = 10,
        $sort = "final_total",
        $order = 'DESC'
    ) {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        }
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'final_total') {
                $sort = "final_total";
            } else {
                $sort = $_GET['sort'];
            }
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        }


        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $filters = [
                'oi.product_name' => $search,
                'oi.product_variant_id' => $search,
                'oi.variant_name' => $search,
                'oi.quantity' => $search,
                'oi.sub_total' => $search,
            ];
        }

        $count_row = $this->db->select('oi.product_variant_id, COUNT( DISTINCT oi.product_variant_id) as `total` ');

        if (isset($filters) && !empty($filters)) {
            $this->db->group_start();
            $count_row->or_like($filters);
            $this->db->group_end();
        }

        $sales_count = $count_row->get('`order_items` oi')->result_array();

        foreach ($sales_count as $row) {
            $total = $row['total'];
        }

        $query = $this->db->select('oi.*,SUM(oi.sub_total) AS final_total, SUM(oi.quantity) AS qty')->group_by('oi.product_variant_id');

        if (isset($filters) && !empty($filters)) {
            $query->group_Start();
            $query->or_like($filters);
            $query->group_End();
        }

        $results = $query->order_by($sort, $order)->limit($limit, $offset)->get('`order_items` oi')->result_array();

        $bulkData = $rows = $tempRow = array();
        $bulkData['total'] = $total;
        $currency_symbol = get_settings('currency');

        foreach ($results as $row) {
            $row = output_escaping($row);
            if (!empty($row['variant_name'])) {
                $tempRow['product_name'] = $row['product_name']  . "(" . $row['variant_name'] . ")";
            } else {
                $tempRow['product_name'] = $row['product_name'];
            }
            $tempRow['product_variant_id'] = $row['product_variant_id'];
            $tempRow['unit_of_measure'] = $row['variant_name'];
            $tempRow['total_units_sold'] = $row['qty'];
            $tempRow['final_total'] =  intval($row['final_total']);
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
