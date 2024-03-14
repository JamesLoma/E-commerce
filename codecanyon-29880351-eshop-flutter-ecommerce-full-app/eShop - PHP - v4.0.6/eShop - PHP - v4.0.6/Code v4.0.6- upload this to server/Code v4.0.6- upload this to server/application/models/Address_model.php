<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Address_model extends CI_Model
{

    function set_address($data)
    {

        $data = escape_array($data);
        $address_data = [];

        if (isset($data['user_id'])) {
            $address_data['user_id'] = $data['user_id'];
        }
        if (isset($data['id'])) {
            $address_data['id'] = $data['id'];
        }
        if (isset($data['type'])) {
            $address_data['type'] = $data['type'];
        }
        if (isset($data['name'])) {
            $address_data['name'] = $data['name'];
        }
        if (isset($data['mobile'])) {
            $address_data['mobile'] = $data['mobile'];
        }
        $address_data['country_code'] = (isset($data['country_code']) && !empty($data['country_code']) && is_numeric($data['country_code'])) ? $data['country_code'] : 0;

        if (isset($data['alternate_mobile'])) {
            $address_data['alternate_mobile'] = $data['alternate_mobile'];
        }

        if (isset($data['address'])) {
            $address_data['address'] = $data['address'];
        }
        if (isset($data['landmark'])) {
            $address_data['landmark'] = $data['landmark'];
        }
        // if (isset($data['area_id'])) {
        //     $address_data['area_id'] = (isset($data['area_id']) & !empty($data['area_id'])) ? $data['area_id'] : 0;;
        // }
        $city = fetch_details('cities', ['id' => $data['city_id']], 'name');
        $area = fetch_details('areas', ['id' => $data['area_id']], 'name');
        if (isset($data['general_area_name'])) {
            // $address_data['general_area_name'] = isset($data['general_area_name']) && !empty($data['general_area_name']) ? $data['general_area_name'] : '';
            $address_data['area'] = isset($data['general_area_name']) && !empty($data['general_area_name']) ? $data['general_area_name'] : '';
        }
        if (isset($data['edit_general_area_name'])) {
            // $address_data['general_area_name'] = isset($data['general_area_name']) && !empty($data['general_area_name']) ? $data['general_area_name'] : '';
            $address_data['area'] = isset($data['edit_general_area_name']) && !empty($data['edit_general_area_name']) ? $data['edit_general_area_name'] : '';
        }
        if (isset($data['city_id'])) {
            $address_data['city_id'] = (isset($data['city_id']) & !empty($data['city_id'])) ? $data['city_id'] : 0;
        }
        // if (isset($data['pincode'])) {
        //     $address_data['pincode'] = (isset($data['pincode']) && !empty($data['pincode'])) ? $data['pincode'] : "";
        // }
        if (isset($data['city_name'])) {
            $address_data['city'] = (isset($data['city_name']) & !empty($data['city_name'])) ? $data['city_name'] : $city[0]['name'];
        }
        if (isset($data['area_name']) && !empty($data['area_name'])) {
            $address_data['area'] = (isset($data['area_name']) & !empty($data['area_name'])) ? $data['area_name'] : $area[0]['name'];
        }
        if (isset($data['other_city']) && !empty($data['other_city'])) {
            $address_data['city'] = (isset($data['other_city']) && !empty($data['other_city'])) ? $data['other_city'] : $city[0]['name'];
        }
        if (isset($data['other_areas']) && !empty($data['other_areas'])) {
            $address_data['area'] = (isset($data['other_areas']) & !empty($data['other_areas'])) ? $data['other_areas'] : $area[0]['name'];
        }
        if (isset($data['pincode_name']) || isset($data['pincode'])) {
            $address_data['system_pincode'] = isset($data['pincode_name']) && !empty($data['pincode_name']) ? 0 : 1;
            $address_data['pincode'] = (isset($data['pincode_name']) && !empty($data['pincode_name'])) ? $data['pincode_name'] : $data['pincode'];
        }


        if (isset($data['state'])) {
            $address_data['state'] = $data['state'];
        }

        if (isset($data['country'])) {
            $address_data['country'] = $data['country'];
        }
        if (isset($data['latitude'])) {
            $address_data['latitude'] = $data['latitude'];
        }
        if (isset($data['longitude'])) {
            $address_data['longitude'] = $data['longitude'];
        }


        // $pincode = ($_POST['pincode_name'] != '' ? $_POST['pincode_name'] : $_POST['pincode']);

        if (isset($data['id']) && !empty($data['id'])) {
            if (isset($data['is_default']) && $data['is_default'] == true) {
                $address = fetch_details('addresses', ['id' => $data['id']], '*');
                $this->db->where('user_id', $address[0]['user_id'])->set(['is_default' => '0'])->update('addresses');
                $this->db->where('id', $data['id'])->set(['is_default' => '1'])->update('addresses');
            }

            $this->db->set($address_data)->where('id', $data['id'])->update('addresses');
        } else {
            $this->db->insert('addresses', escape_array($address_data));
            $last_added_id = $this->db->insert_id();
            if (isset($data['is_default']) && $data['is_default'] == true) {
                $this->db->where('user_id', $data['user_id'])->set('is_default', '0')->update('addresses');
                $this->db->where('id', $last_added_id)->set('is_default', '1')->update('addresses');
            }
        }
    }

    function delete_address($data)
    {
        $this->db->delete('addresses', ['id' => $data['id']]);
    }

    function get_address($user_id, $id = false, $fetch_latest = false, $is_default = false)
    {
        $where = [];
        if (isset($user_id) || $id != false) {
            if (isset($user_id) && $user_id != null && !empty($user_id)) {
                $where['user_id'] = $user_id;
            }
            if ($id != false) {
                $where['addr.id'] = $id;
            }
            $this->db->select('addr.*')
                ->where($where)
                ->group_by('addr.id')->order_by('addr.id', 'DESC');
            if ($fetch_latest == true) {
                $this->db->limit('1');
            }
            if (!empty($is_default)) {
                $this->db->where('is_default', 1);
            }
            $res = $this->db->get('addresses addr')->result_array();
            // print_R($this->db->last_query());functionedit
            if (!empty($res)) {
                for ($i = 0; $i < count($res); $i++) {
                    $area_id = (isset($res[$i]['area_id']) && ($res[$i]['area_id']) != 0) ? $res[$i]['area_id'] : "";
                    $minimum_free_delivery_order_amount =  fetch_details('areas', ['id' => $area_id], 'minimum_free_delivery_order_amount,delivery_charges');
                    $amount = $minimum_free_delivery_order_amount[0]['minimum_free_delivery_order_amount'];
                    $delivery_charges = $minimum_free_delivery_order_amount[0]['delivery_charges'];
                    $res[$i] = output_escaping($res[$i]);
                    $res[$i]['minimum_free_delivery_order_amount'] = (isset($amount) && $amount != NULL) ? "$amount" : "0";
                    $res[$i]['delivery_charges'] = (isset($delivery_charges) && $delivery_charges != NULL) ? "$delivery_charges" : "0";
                }
            }
            return $res;
        }
    }

    public function get_address_list($user_id = '')
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'ASC';
        $multipleWhere = '';

        if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
            $where['user_id'] = $_GET['user_id'];
        }

        if (!empty($user_id)) {
            $where['user_id'] = $user_id;
        }

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
            $multipleWhere = ['addr.name' => $search, 'addr.address' => $search, 'mobile' => $search, 'area' => $search, 'city' => $search, 'state' => $search, 'country' => $search, 'pincode' => $search];
        }

        $count_res = $this->db->select(' COUNT(addr.id) as `total` ,addr.*');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->group_start();
            $count_res->or_like($multipleWhere);
            $count_res->group_end();
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $address_count = $count_res->get('addresses addr')->result_array();

        foreach ($address_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select('addr.*');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->group_start();
            $search_res->or_like($multipleWhere);
            $count_res->group_end();
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $address_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get('addresses addr')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($address_search_res as $row) {
            $row = output_escaping($row);
            $default = $row['is_default'] == 1 ? 'Default' : 'Set as default';
            $theme = fetch_details('themes', ['is_default' => 1], 'name');
            $btn = $row['is_default'] == 1 ? 'primary' : ' ';
            $class = $row['is_default'] == 1 ? '' : 'default-address ';
            $operate = '<div class="d-flex"><a href="javascript:void(0)" style="
                color: initial;
            " class="edit-address btn mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '"  data-toggle="modal" data-target="#address-modal"  data-bs-toggle="modal" data-bs-target="#address-modal"><ion-icon name="create-outline" class="fs-4"></ion-icon></a>';
            $operate .= '<a href="javascript:void(0)" style="
                color: initial;
            " class="delete-address btn mr-1 mb-1" title="Delete" data-id="' . $row['id'] . '"><ion-icon name="trash-outline" class="fs-4"></ion-icon></a>';
            $operate .= '<a href="javascript:void(0)" style="
                color: initial;
            " class="' . $class . ' btn text-' . $btn . ' mr-1 mb-1" title="' . $default . '" data-id="' . $row['id'] . '"><ion-icon name="checkbox-outline" class="fs-4"></ion-icon></i></a></div>';

            $tempRow['id'] = $row['id'];
            $tempRow['name'] = $row['name'];
            $tempRow['type'] = $row['type'];
            $tempRow['mobile'] = (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) ? str_repeat("X", strlen($row['mobile']) - 3) . substr($row['mobile'], -3) : $row['mobile'];
            $tempRow['alternate_mobile'] = $row['alternate_mobile'];
            $tempRow['address'] = $row['address'];
            $tempRow['landmark'] = $row['landmark'];
            $tempRow['area'] = $row['area'];
            $tempRow['area_id'] = $row['area_id'];
            $tempRow['city'] = $row['city'];
            $tempRow['city_id'] = $row['city_id'];
            $tempRow['state'] = $row['state'];
            $tempRow['pincode'] = $row['pincode'];
            $tempRow['pincode_name'] = $row['pincode'];
            $tempRow['system_pincode'] = $row['system_pincode'];
            $tempRow['country'] = $row['country'];
            $tempRow['action'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
