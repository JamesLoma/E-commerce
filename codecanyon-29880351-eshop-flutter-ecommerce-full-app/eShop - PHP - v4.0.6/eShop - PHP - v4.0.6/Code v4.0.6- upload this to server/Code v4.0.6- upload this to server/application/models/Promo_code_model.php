<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promo_code_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    public function get_promo_code_list($offset = 0, $limit = 10, $sort = 'id', $order = 'ASC')
    {
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
            $multipleWhere = ['p.`id`' => $search, 'p.`promo_code`' => $search, 'p.`message`' => $search, 'p.`start_date`' => $search, 'p.`end_date`' => $search, 'p.`discount`' => $search, 'p.`repeat_usage`' => $search, 'p.`max_discount_amount`' => $search];
        }

        $count_res = $this->db->select(' COUNT(p.id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_where($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $sc_count = $count_res->get('promo_codes p')->result_array();

        foreach ($sc_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select(' p.`id` as id , p.`promo_code`, p.`image` , p.`message` , p.`start_date` , p.`end_date`, p.`discount` , p.`repeat_usage` ,p.`minimum_order_amount` ,p.`no_of_users` ,p.`discount_type` , p.`max_discount_amount`, p.`no_of_repeat_usage` , p.`status` , p.`is_cashback`,p.`list_promocode` ');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $sc_search_res = $search_res->order_by($sort, "desc")->limit($limit, $offset)->get('promo_codes p')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($sc_search_res as $row) {
            $row = output_escaping($row);

            $operate = '<div class="dropdown">
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a href="javascript:void(0)" class="view_btn dropdown-item"  title="view" data-id="' . $row['id'] . '" data-url="admin/promo_code" ><i class="fa fa-eye" ></i> View</a>

            <a href="javascript:void(0)" class="edit_btn dropdown-item" title="Edit" data-id="' . $row['id'] . '" data-url="admin/promo_code"><i class="fa fa-pen"></i> Edit</a>

              <a href="javascript:void(0)" class="delete-brand dropdown-item" id="delete-promo-code" data-id=' . $row['id'] . ' title="Delete" ><i class="fa fa-trash"></i> Delete</a></div>';


            // $operate = '<a href="javascript:void(0)" class="view_btn btn action-btn btn-primary btn-xs mr-1 mb-1"  title="view" data-id="' . $row['id'] . '" data-url="admin/promo_code" ><i class="fa fa-eye" ></i></a>';
            // $operate .= '<a href="javascript:void(0)" class="edit_btn btn action-btn btn-success btn-xs mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '" data-url="admin/promo_code"><i class="fa fa-pen"></i></a>';
            // $operate .= '<a class="btn action-btn btn-danger btn-xs mr-1 mb-1" href="javascript:void(0)" id="delete-promo-code" title="Delete" data-id="' . $row['id'] . '" ><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row['id'];
            $tempRow['promo_code'] = $row['promo_code'];
            $tempRow['message'] = $row['message'];
            $tempRow['start_date'] = $row['start_date'];
            $tempRow['end_date'] = $row['end_date'];
            $tempRow['discount'] = $row['discount'];
            $tempRow['repeat_usage'] = ($row['repeat_usage'] == '1') ? 'Allowed' : 'Not Allowed';
            $tempRow['min_order_amt'] = $row['minimum_order_amount'];
            $tempRow['no_of_users'] = $row['no_of_users'];
            $tempRow['discount_type'] = $row['discount_type'];
            $tempRow['max_discount_amt'] = $row['max_discount_amount'];
            $row['image'] = (isset($row['image']) && !empty($row['image'])) ? base_url() . $row['image'] :  base_url() . NO_IMAGE;
            $tempRow['image'] = '<div class="mx-auto product-image"><a href=' . $row['image'] . ' data-toggle="lightbox" data-gallery="gallery"><img src=' . $row['image'] . ' class="img-fluid rounded"></a></div>';

            $tempRow['no_of_repeat_usage'] = $row['no_of_repeat_usage'];
            if ($row['status'] == '1') {
                $tempRow['status'] = '<span class="badge bg-success" >Active</span>';
            } else {
                $tempRow['status'] = '<span class="badge bg-danger" >Deactive</span>';
            }
            $tempRow['list_promocode'] = ($row['list_promocode'] == '1') ? '<span class="badge bg-primary" >SHOW</span>' : '<span class="badge bg-secondary">HIDDEN</span>';
            $tempRow['is_cashback'] = ($row['is_cashback'] == '1') ? '<span class="badge bg-success" >ON</span>' : '<span class="badge bg-danger">OFF</span>';

            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    public function get_promo_codes($limit = "", $offset = '', $sort = 'u.id', $order = 'DESC', $search = NULL)
    {
        $multipleWhere = '';
        if (isset($search) and $search != '') {
            $multipleWhere = ['p.`id`' => $search, 'p.`promo_code`' => $search, 'p.`message`' => $search, 'p.`start_date`' => $search, 'p.`end_date`' => $search, 'p.`discount`' => $search, 'p.`repeat_usage`' => $search, 'p.`max_discount_amount`' => $search];
        }

        $count_res = $this->db->select(' COUNT(p.id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_where($multipleWhere);
        }
        $where = "(NOW() between start_date AND end_date) and status = 1 and list_promocode = 1";
        if (isset($_SESSION['user_id']) || isset($_POST['user_id'])) {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_POST['user_id'];
            $where2 = "(users_id='0' OR users_id=''  OR FIND_IN_SET('$user_id', users_id)) ";
            $this->db->group_Start();
            $this->db->where($where2);
            $this->db->group_End();
        }
        $count_res->where($where);

        $sc_count = $count_res->get('promo_codes p')->result_array();

        foreach ($sc_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select(' p.`id` as id ,TIMESTAMPDIFF(SECOND,NOW(),end_date) as remaining_seconds, p.`promo_code`, p.`image` , p.`message` , p.`start_date` , p.`end_date`, p.`discount` , p.`repeat_usage` ,p.`minimum_order_amount`, `p.is_specific_users`,`p.users_id`,p.`no_of_users` ,p.`discount_type` , p.`max_discount_amount`, p.`no_of_repeat_usage` , p.`status` ,p.`is_cashback`,p.`list_promocode`');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }

        $where = "(NOW() between start_date AND end_date) and status=1  and list_promocode = 1";
        if (isset($_SESSION['user_id']) || isset($_POST['user_id'])) {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_POST['user_id'];
            $where2 = "(users_id='0' OR users_id=''  OR FIND_IN_SET('$user_id', users_id)) ";
            $this->db->group_Start();
            $this->db->where($where2);
            $this->db->group_End();
        }
        $search_res->where($where);
        // $search_res->where_in('p.users_id', $_SESSION['user_id']);
        $sc_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get('promo_codes p')->result_array();
        // echo $this->db->last_query();
        $bulkData = array();
        $bulkData['error'] = (empty($sc_search_res)) ? true : false;
        $bulkData['message'] = (empty($sc_search_res)) ? 'Promo code(s) does not exist' : 'Promo code(s) retrieved successfully';
        $bulkData['total'] = (empty($sc_search_res)) ? 0 : $total;
        $rows = array();
        $tempRow = array();

        foreach ($sc_search_res as $row) {
            // print_R($row);
            $row = output_escaping($row);
            $tempRow['id'] = $row['id'];
            $tempRow['promo_code'] = $row['promo_code'];
            $tempRow['message'] = $row['message'];
            $tempRow['start_date'] = $row['start_date'];
            $tempRow['end_date'] = $row['end_date'];
            $tempRow['discount'] = $row['discount'];
            $tempRow['repeat_usage'] = ($row['repeat_usage'] == '1') ? 'Allowed' : 'Not Allowed';
            $tempRow['min_order_amt'] = $row['minimum_order_amount'];
            $tempRow['no_of_users'] = $row['no_of_users'];
            $tempRow['discount_type'] = $row['discount_type'];
            $tempRow['max_discount_amt'] = $row['max_discount_amount'];
            $tempRow['image'] = (isset($row['image']) && !empty($row['image'])) ? base_url() . $row['image'] :  base_url() . NO_IMAGE;
            $tempRow['no_of_repeat_usage'] = $row['no_of_repeat_usage'];
            $tempRow['status'] = $row['status'];
            $tempRow['is_cashback'] = $row['is_cashback'];
            $tempRow['list_promocode'] = $row['list_promocode'];
            $tempRow['remaining_days'] =   $row['remaining_days'];
            $tempRow['is_specific_users'] =   $row['is_specific_users'];
            $tempRow['users_id'] =   $row['users_id'];
            $rows[] = $tempRow;
        }
        $bulkData['data'] = $rows;
        if (!empty($bulkData)) {
            return $bulkData;
        } else {
            return $bulkData = [];
        }
    }

    public function add_promo_code_details($data)
    {
        $data = escape_array($data);

        $promo_data = [
            'promo_code' => (isset($data['promo_code']) && !empty($data['promo_code'])) ? $data['promo_code'] : '',
            'message' => (isset($data['message']) && !empty($data['message'])) ? $data['message'] : '',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'no_of_users' => (isset($data['no_of_users']) && !empty($data['no_of_users'])) ? $data['no_of_users'] : 0,
            'minimum_order_amount' => (isset($data['minimum_order_amount']) && !empty($data['minimum_order_amount'])) ? $data['minimum_order_amount'] : '',
            'discount' => (isset($data['discount']) && !empty($data['discount'])) ? $data['discount'] : '',
            'discount_type' => (isset($data['discount_type']) && !empty($data['discount_type'])) ? $data['discount_type'] : '',
            'max_discount_amount' => (isset($data['max_discount_amount']) && !empty($data['max_discount_amount'])) ? $data['max_discount_amount'] : '',
            'repeat_usage' => (isset($data['repeat_usage']) && !empty($data['repeat_usage'])) ?  $data['repeat_usage'] : '0',
            'status' => (isset($data['status']) && !empty($data['status'])) ? $data['status'] : '1',
            'image' => (isset($data['image']) && !empty($data['image'])) ? $data['image'] : '',
            'is_cashback' => (isset($data['is_cashback']) && $data['is_cashback'] == 'on') ? '1' : '0',
            'list_promocode' => (isset($data['list_promocode']) && $data['list_promocode'] == 'on') ? '1' : '0',
            'is_specific_users' => (isset($data['is_specific_user']) && $data['is_specific_user'] == 'on') ? '1' : '0',
            'users_id' => (isset($data['users_id']) && !empty($data['users_id'])) ? implode(',', $data['users_id']) : '0'

        ];

        if ($data['repeat_usage'] == '1') {
            $promo_data['no_of_repeat_usage'] = $data['no_of_repeat_usage'];
        }
        if (isset($data['edit_promo_code'])) {
            $this->db->set($promo_data)->where('id', $data['edit_promo_code'])->update('promo_codes');
        } else {
            $this->db->insert('promo_codes', $promo_data);
        }
    }

    function settle_cashback_discount()
    {
        $return = false;
        $date = date('Y-m-d');
        $settings = get_settings('system_settings', true);
        $returnable_where = "oi.active_status='delivered' AND o.promo_code != '' AND o.promo_discount <= 0 GROUP BY `o`.`id` HAVING date = '" . $date . "'";
        $returnable_data = $this->db->select("o.id,o.date_added,o.total,o.final_total,o.promo_code,o.user_id,p.is_returnable,(date_format(o.date_added,'%Y-%m-%d')) as date ")
            ->join('order_items oi', 'oi.order_id=o.id', 'left')
            ->join('product_variants pv', 'oi.product_variant_id=pv.id', 'left')
            ->join('products p', 'p.id=pv.product_id', 'left')
            ->where($returnable_where)
            ->get('orders o')->result_array();
        foreach ($returnable_data as $result) {
            $res =  $this->db->select('oi.id as item_id, oi.order_id,p.is_returnable')
                ->join('product_variants pv', 'oi.product_variant_id = pv.id', 'left')
                ->join('products p', 'p.id = pv.product_id')
                ->where("oi.order_id", $result['id'])
                ->where_in('p.is_returnable', [0, 1])
                ->get('order_items oi')->result_array();
            $returnable_status = array_column($res, 'is_returnable');
            if (in_array("1", $returnable_status)) {
                $return = true;
            } else {
                $return = false;
            }
        }
        if ($return == true) {
            $select = "DATE_ADD(date_format(o.date_added,'%Y-%m-%d'), INTERVAL " . $settings['max_product_return_days'] . " DAY) as date";
        } elseif ($return == false) {
            $select = "(date_format(o.date_added,'%Y-%m-%d')) as date";
        } else {
            $select = "(date_format(o.date_added,'%Y-%m-%d')) as date";
        }
        $where = "oi.active_status='delivered' AND o.promo_code != '' AND o.promo_discount <= 0 GROUP BY `o`.`id` HAVING date = '" . $date . "'";
        $data = $this->db->select("o.id,o.date_added,o.total,o.final_total,o.promo_code,o.user_id,$select ")
            ->join('order_items oi', 'oi.order_id=o.id', 'left')
            ->where($where)
            ->get('orders o')->result_array();
        $wallet_updated = false;
        if (!empty($data)) {
            foreach ($data as $row) {
                $promo_code = $row['promo_code'];
                $user_id = $row['user_id'];
                $final_total = $row['final_total'];

                $res = validate_promo_code($promo_code, $user_id, $final_total);

                $discount = (isset($res['data'][0]['final_discount']) && !empty($res['data'][0]['final_discount'])) ? $res['data'][0]['final_discount'] : 0;
                $response = update_wallet_balance('credit', $user_id, $discount, 'Discounted Amount Credited for Order Item ID  : ' . $row['id']);


                if ($response['error'] == false && $response['error'] == '') {
                    update_details(['total_payable' => $res['data'][0]['final_total'], 'final_total' => $res['data'][0]['final_total'], 'promo_discount' => $res['data'][0]['final_discount']], ['id' => $row['id']], 'orders');
                    $wallet_updated = true;
                    $response_data['error'] = false;
                    $response_data['message'] = 'Discount Added Successfully...';
                } else {
                    $wallet_updated = false;
                    $response_data['error'] =  true;
                    $response_data['message'] =  'Discount not Added';
                }
            }
            if ($wallet_updated == true) {
                $user_ids = array_values(array_unique(array_column($data, "user_id")));
                foreach ($user_ids as $user) {
                    $settings = get_settings('system_settings', true);

                    //custom message
                    $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                    $user_res = fetch_details('users', ['id' => $user], 'username,fcm_id,email');

                    $custom_notification =  fetch_details('custom_notifications', ['type' => "settle_cashback_discount"], '');

                    $hashtag_cutomer_name = '< cutomer_name >';
                    $hashtag_application_name = '< application_name >';

                    $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                    $hashtag = html_entity_decode($string);

                    $data = str_replace(array($hashtag_cutomer_name, $hashtag_application_name), array($user_res[0]['username'], $app_name), $hashtag);
                    $message = output_escaping(trim($data, '"'));

                    $customer_title = (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Discounted Amount Credited";
                    $customer_msg = (!empty($custom_notification)) ? $message :  'Hello Dear ' . $user_res[0]['username'] . ' Discounted Amount Credited, which orders are delivered. Please take note of it! Regards ' . $app_name . '';

                    send_mail($user_res[0]['email'], $customer_title, $customer_msg);

                    $fcm_ids = array();
                    if (!empty($user_res[0]['fcm_id'])) {
                        $fcmMsg = array(
                            'title' => $customer_title,
                            'body' => $customer_msg,
                            'type' => "Discounted"
                        );
                        $fcm_ids[0][] = $user_res[0]['fcm_id'];
                        send_notification($fcmMsg, $fcm_ids);
                    }
                }
            } else {
                $response_data['error'] =  true;
                $response_data['message'] =  'Discounted not Added';
            }
        } else {
            $response_data['error'] =  true;
            $response_data['message'] =  'Orders Not Found';
        }
        print_r(json_encode($response_data));
    }

    function get_users($search_term = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->where("username like '%" . $search_term . "%'");
        $this->db->or_where("id like '%" . $search_term . "%'");
        $this->db->or_where("mobile like '%" . $search_term . "%'");
        $this->db->or_where("email like '%" . $search_term . "%'");
        $fetched_records = $this->db->get('users');
        $users = $fetched_records->result_array();


        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['username'] . " | " . $user['mobile'] . " | " . $user['email'], "number" => $user['mobile'], "email" => $user['email'], "name" => $user['username']);
        }
        return $data;
    }
}
