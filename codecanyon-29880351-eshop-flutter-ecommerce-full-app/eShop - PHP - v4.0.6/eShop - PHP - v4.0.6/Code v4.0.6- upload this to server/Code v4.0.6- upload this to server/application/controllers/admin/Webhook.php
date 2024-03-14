<?php defined('BASEPATH') or exit('No direct script access allowed');
class Webhook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phonepe');
    }

    public function razorpay()
    {

        //Debug in server first
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('HTTP_X_RAZORPAY_SIGNATURE', $_SERVER))
            exit();

        $this->load->library(['razorpay']);
        $system_settings = get_settings('system_settings', true);
        $credentials = $this->razorpay->get_credentials();

        $request = file_get_contents('php://input');
        if ($request === false || empty($request)) {
            $this->edie("Error in reading Post Data");
        }
        $request = json_decode($request, true);

        define('RAZORPAY_SECRET_KEY', $credentials['secret_hash']);
        log_message('error', 'Razorpay IPN POST --> ' . var_export($request, true));
        $http_razorpay_signature = isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']) ? $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] : "";
        log_message('error', 'Razorpay IPN SERVER --> ' . var_export($_SERVER, true));


        $txn_id = (isset($request['payload']['payment']['entity']['id'])) ? $request['payload']['payment']['entity']['id'] : "";

        if (!empty($request['payload']['payment']['entity']['id'])) {
            if (!empty($txn_id)) {
                $transaction = fetch_details('transactions', ['txn_id' => $txn_id], '*');
            }
            $amount = $request['payload']['payment']['entity']['amount'];
            $amount = ($amount / 100);
        } else {
            $amount = 0;
            $currency = (isset($request['payload']['payment']['entity']['currency'])) ? $request['payload']['payment']['entity']['currency'] : "";
        }


        if (!empty($transaction)) {
            $order_id = $transaction[0]['order_id'];
            $user_id = $transaction[0]['user_id'];
        } else {
            $order_id = 0;
            $order_id = (isset($request['payload']['order']['entity']['notes']['order_id'])) ? $request['payload']['order']['entity']['notes']['order_id'] : $request['payload']['payment']['entity']['notes']['order_id'];
        }

        $this->load->model('transaction_model');

        if ($http_razorpay_signature) {
            if ($request['event'] == 'payment.authorized') {
                $currency = (isset($request['payload']['payment']['entity']['currency'])) ? $request['payload']['payment']['entity']['currency'] : "INR";
                $this->load->library("razorpay");
                $response = $this->razorpay->capture_payment($amount * 100, $txn_id, $currency);
                return;
            }
            if ($request['event'] == 'payment.captured' || $request['event'] == 'order.paid') {
                if ($request['event'] == 'order.paid') {
                    $order_id = $request['payload']['order']['entity']['receipt'];
                    $order_data = fetch_orders($order_id);
                    $user_id = (isset($order_data['order_data'][0]['user_id'])) ? $order_data['order_data'][0]['user_id'] : "";
                }
                if (!empty($order_id)) {
                    /* To do the wallet recharge if the order id is set in the patter */
                    if (strpos($order_id, "wallet-refill-user") !== false) {
                        if (!is_numeric($order_id) && strpos($order_id, "wallet-refill-user") !== false) {
                            $temp = explode("-", $order_id);
                            if (isset($temp[3]) && is_numeric($temp[3]) && !empty($temp[3] && $temp[3] != '')) {
                                $user_id = $temp[3];
                            } else {
                                $user_id = 0;
                            }
                        }
                        log_message('error', 'Razorpay user ID - Add transaction --> ' . var_export($user_id, true));

                        $data['transaction_type'] = "wallet";
                        $data['user_id'] = $user_id;
                        $data['order_id'] = $order_id;
                        $data['type'] = "credit";
                        $data['txn_id'] = $txn_id;
                        $data['amount'] = $amount;
                        $data['status'] = "success";
                        $data['message'] = "Wallet refill successful";
                        $this->transaction_model->add_transaction($data);
                        log_message('error', 'Razorpay user ID - transaction data --> ' . var_export($data, true));

                        $this->load->model('customer_model');
                        if ($this->customer_model->update_balance($amount, $user_id, 'add')) {
                            $response['error'] = false;
                            $response['transaction_status'] = $request['event'];
                            $response['message'] = "Wallet recharged successfully!";
                        } else {
                            $response['error'] = true;
                            $response['transaction_status'] = $request['event'];
                            $response['message'] = "Wallet could not be recharged!";
                            log_message('error', 'razorpay Webhook | wallet recharge failure --> ' . var_export($request['event'], true));
                        }
                        echo json_encode($response);
                        return false;
                    } else {

                        /* process the order and mark it as received */
                        $order = fetch_orders($order_id, false, false, false, false, false, false, false);
                        if (isset($order['order_data'][0]['user_id'])) {
                            $user = fetch_details('users', ['id' => $order['order_data'][0]['user_id']]);
                            $overall_total = array(
                                'total_amount' => $order['order_data'][0]['total'],
                                'delivery_charge' => $order['order_data'][0]['delivery_charge'],
                                'tax_amount' => $order['order_data'][0]['total_tax_amount'],
                                'tax_percentage' => $order['order_data'][0]['total_tax_percent'],
                                'discount' =>  $order['order_data'][0]['promo_discount'],
                                'wallet' =>  $order['order_data'][0]['wallet_balance'],
                                'final_total' =>  $order['order_data'][0]['final_total'],
                                'otp' => $order['order_data'][0]['otp'],
                                'address' =>  $order['order_data'][0]['address'],
                                'payment_method' => $order['order_data'][0]['payment_method']
                            );

                            $overall_order_data = array(
                                'cart_data' => $order['order_data'][0]['order_items'],
                                'order_data' => $overall_total,
                                'subject' => 'Order received successfully',
                                'user_data' => $user[0],
                                'system_settings' => $system_settings,
                                'user_msg' => 'Hello, Dear ' . ucfirst($user[0]['username']) . ', We have received your order successfully. Your order summaries are as followed',
                                'otp_msg' => 'Here is your OTP. Please, give it to delivery boy only while getting your order.',
                            );
                            if (isset($user[0]['email']) && !empty($user[0]['email'])) {
                                send_mail($user[0]['email'], 'Order received successfully', $this->load->view('admin/pages/view/email-template.php', $overall_order_data, TRUE));
                            }
                            /* No need to add because the transaction is already added just update the transaction status */
                            if (!empty($transaction)) {
                                $transaction_id = $transaction[0]['id'];
                                update_details(['status' => 'success'], ['id' => $transaction_id], 'transactions');
                            } else {
                                /* add transaction of the payment */
                                $amount = ($request['payload']['payment']['entity']['amount'] / 100);
                                $data = [
                                    'transaction_type' => 'transaction',
                                    'user_id' => $user_id,
                                    'order_id' => $order_id,
                                    'type' => 'razorpay',
                                    'txn_id' => $txn_id,
                                    'amount' => $amount,
                                    'status' => 'success',
                                    'message' => 'order placed successfully',
                                ];
                                $this->transaction_model->add_transaction($data);
                            }
                            update_details(['active_status' => 'received'], ['id' => $order_id], 'orders');
                            update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                            $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                            update_details(['status' => $status], ['order_id' => $order_id], 'order_items', false);
                            update_details(['status' => $status], ['id' => $order_id], 'orders', false);

                            // place order custome notification on payment success

                            $custom_notification = fetch_details('custom_notifications', ['type' => "place_order"], '');
                            $hashtag_order_id = '< order_id >';
                            $string = json_encode($custom_notification[0]['title'], JSON_UNESCAPED_UNICODE);
                            $hashtag = html_entity_decode($string);
                            $data1 = str_replace($hashtag_order_id, $order_id, $hashtag);
                            $title = output_escaping(trim($data1, '"'));
                            $hashtag_application_name = '< application_name >';
                            $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                            $hashtag = html_entity_decode($string);
                            $data2 = str_replace($hashtag_application_name, $system_settings['app_name'], $hashtag);
                            $message = output_escaping(trim($data2, '"'));

                            $fcm_admin_subject = (!empty($custom_notification)) ? $title : 'New order placed ID #' . $order_id;
                            $fcm_admin_msg = (!empty($custom_notification)) ? $message : 'New order received for  ' . $system_settings['app_name'] . ' please process it.';
                            $user_fcm = fetch_details('users', ['id' => $user_id], 'fcm_id');
                            $user_fcm_id[0][] = $user_fcm[0]['fcm_id'];
                            if (!empty($user_fcm_id)) {
                                $fcmMsg = array(
                                    'title' => $fcm_admin_subject,
                                    'body' => $fcm_admin_msg,
                                    'type' => "place_order",
                                    'content_available' => true
                                );
                                send_notification($fcmMsg, $user_fcm_id);
                            }
                            update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');
                        }
                    }
                } else {
                    log_message('error', 'Razorpay Order id not found --> ' . var_export($request, true));
                    /* No order ID found */
                }

                $response['error'] = false;
                $response['transaction_status'] = $request['event'];
                $response['message'] = "Transaction successfully done";
                echo json_encode($response);
                return false;
            } elseif ($request['event'] == 'payment.failed') {
                //$order = fetch_orders($order_id, false, false, false, false, false, false, false);

                if (!empty($order_id)) {
                    // update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');
                    update_details(['active_status' => 'cancelled'], ['id' => $order_id], 'orders');
                    update_details(['active_status' => 'cancelled'], ['order_id' => $order_id], 'order_items');
                }
                /* No need to add because the transaction is already added just update the transaction status */
                if (!empty($transaction)) {
                    $transaction_id = $transaction[0]['id'];
                    update_details(['status' => 'failed'], ['id' => $transaction_id], 'transactions');
                }
                $response['error'] = true;
                $response['transaction_status'] = $request['event'];
                $response['message'] = "Transaction is failed. ";
                log_message('error', 'Razorpay Webhook | Transaction is failed --> ' . var_export($request['event'], true));
                echo json_encode($response);
                return false;
            } elseif ($request['event'] == 'payment.authorized') {
                if (!empty($order_id)) {
                    update_details(['active_status' => 'awaiting'], ['id' => $order_id], 'orders');
                    update_details(['active_status' => 'awaiting'], ['order_id' => $order_id], 'order_items');
                }
            } elseif ($request['event'] == "refund.processed") {
                //Refund Successfully
                $transaction = fetch_details('transactions', ['txn_id' => $request['payload']['refund']['entity']['payment_id']]);
                if (empty($transaction)) {
                    return false;
                }
                process_refund($transaction[0]['id'], $transaction[0]['status']);
                $response['error'] = false;
                $response['transaction_status'] = $request['event'];
                $response['message'] = "Refund successfully done. ";
                log_message('error', 'Razorpay Webhook | Payment refund done --> ' . var_export($request['event'], true));
                echo json_encode($response);
                return false;
            } elseif ($request['event'] == "refund.failed") {
                $response['error'] = true;
                $response['transaction_status'] = $request['event'];
                $response['message'] = "Refund is failed. ";
                log_message('error', 'Razorpay Webhook | Payment refund failed --> ' . var_export($request['event'], true));
                echo json_encode($response);
                return false;
            } else {
                $response['error'] = true;
                $response['transaction_status'] = $request['event'];
                $response['message'] = "Transaction could not be detected.";
                log_message('error', 'Razorpay Webhook | Transaction could not be detected --> ' . var_export($request['event'], true));
                echo json_encode($response);
                return false;
            }
        } else {
            log_message('error', 'razorpay Webhook | Invalid Server Signature  --> ' . var_export($request['event'], true));
            return false;
        }
    }

    public function edie($error_msg)
    {
        global $debug_email;
        $report =  "ERROR : " . $error_msg . "\n\n";
        $report .= "POST DATA\n\n";
        foreach ($_POST as $key => $value) {
            $report .= "|$key| = |$value| \n";
        }
        log_message('error', $report);
        die($error_msg);
    }
    public function spr_webhook()
    {
        $shiprocket_settings = get_settings('shipping_method', true);
        $token = $shiprocket_settings['webhook_token'];
        $request = file_get_contents('php://input');
        if ($request === false || empty($request)) {
            $this->edie("Error in reading Post Data");
        }
        $request = json_decode($request, true);
        if (isset($_SERVER['HTTP_X_API_KEY']) && !empty($_SERVER['HTTP_X_API_KEY'])) {
            if ($token == $_SERVER['HTTP_X_API_KEY']) {
                if (isset($request['awb']) && !empty($request['awb'])) {

                    if (strtolower($request['current_status']) == "delivered") {
                        $order_details = fetch_details('order_tracking', ['awb_code' => $request['awb']], 'order_id');
                        if (!empty($order_details)) {
                            $order_id = $order_details[0]['order_id'];
                            // print_R($order_id);
                            if (!empty($order_id)) {
                                $status = json_encode(array(array('delivered', date("d-m-Y h:i:sa"))));
                                update_details(['active_status' => 'delivered'], ['id' => $order_id], 'orders');
                                update_details(['status' => $status], ['id' => $order_id], 'orders', false);
                                $res['error'] = false;
                                $res['message'] = "order Updated successfully";
                                echo json_encode($res);
                                return false;
                            } else {
                                $res['error'] = true;
                                $res['message'] = "order not updated";
                                echo json_encode($res);
                                return false;
                            }
                        } else {
                            $res['error'] = true;
                            $res['message'] = "order not found";
                            echo json_encode($res);
                            return false;
                        }
                    } else if (strtolower($request['current_status']) == "canceled") {
                        $order_details = fetch_details('order_tracking', ['awb_code' => $request['awb']], 'order_id');
                        if (!empty($order_details)) {
                            $order_id = $order_details[0]['order_id'];
                            // print_R($order_id);
                            if (!empty($order_id)) {
                                $status = json_encode(array(array('cancelled', date("d-m-Y h:i:sa"))));
                                update_details(['active_status' => 'cancelled'], ['id' => $order_id], 'orders');
                                update_details(['status' => $status], ['id' => $order_id], 'orders', false);
                                $res['error'] = false;
                                $res['message'] = "order Updated successfully";
                                echo json_encode($res);
                                return false;
                            } else {
                                $res['error'] = true;
                                $res['message'] = "order not updated";
                                echo json_encode($res);
                                return false;
                            }
                        } else {
                            $res['error'] = true;
                            $res['message'] = "order not found";
                            echo json_encode($res);
                            return false;
                        }
                    }
                } else {
                    $res['error'] = true;
                    $res['message'] = "awb not found";
                    echo json_encode($res);
                    return false;
                }
            } else {
                $res['error'] = true;
                $res['message'] = "token is  not veified";
                echo json_encode($res);
                return false;
            }
        } else {
            $res['error'] = true;
            $res['message'] = "token is required";
            echo json_encode($res);
            return false;
        }
    }

    public function myfatoorah_success_url()
    {
        $response['error'] = false;
        $response['transaction_status'] = 'Success';
        $response['message'] = "Transaction successfully done";
        echo json_encode($response);
        return false;
    }

    public function myfatoorah_error_url()
    {

        $response['error'] = true;
        $response['transaction_status'] = 'Failure';
        $response['message'] = "Transaction is failed. ";
        log_message('error', 'My Fatoorah Transaction is failed --> ');
        echo json_encode($response);
        return false;
    }
    public function myfatoorah()
    {
        $system_settings = get_settings('system_settings', true);
        //get MyFatoorah-Signature from request headers
        $request_headers = apache_request_headers();
        $MyFatoorah_Signature = $request_headers['MyFatoorah-Signature'];

        $payment_settings = get_settings('payment_method', true);
        $secret = $payment_settings['myfatoorah__secret_key'];
        // $secret = 'XyXEaQw97JFXQDFibyybAWE6aXujBvoHw3+5BvCRbKl8YOWYHTmX3fn+PSnn0UslQlgIh5xnej5MeLg5onRvTg==';

        //Get webhook body content
        $body = (file_get_contents("php://input"));

        $data = json_decode($body, true);

        //Log data to check the result

        // log_message('error', $body);

        // error_log(PHP_EOL . date('d.m.Y h:i:s') . ' - ' . $body, 3, './webhook.log');

        //Validate the signature
        // $this->validateSignature($data, $secret, $MyFatoorah_Signature);

        //Call $data['Event'] function
        if (empty($data['Event'])) {
            exit();
        } else {

            log_message('error', $data['Data']['PaymentId']);
            $txn_id = (isset($data['Data']['PaymentId'])) ? $data['Data']['PaymentId'] : "";

            if (!empty(($data['Data']['PaymentId']))) {
                if (!empty($txn_id)) {
                    $transaction = fetch_details('transactions', ['txn_id' => $txn_id], '*');
                }
                $amount = $data['Data']['InvoiceValueInBaseCurrency'];
                // $amount = ($amount / 100);
            } else {
                $amount = 0;
                $currency = (isset($data['Data']['PayCurrency'])) ? $data['Data']['PayCurrency'] : "";
            }

            if (!empty($transaction)) {
                $order_id = $transaction[0]['order_id'];
                $user_id = $transaction[0]['user_id'];
            } else {
                $order_id = 0;
                $order_id = (isset($data['Data']['UserDefinedField'])) ? $data['Data']['UserDefinedField'] : $data['Data']['UserDefinedField'];
            }

            $this->load->model('transaction_model');


            // if ($request['event'] == 'payment.authorized') {
            //     $currency = (isset($request['payload']['payment']['entity']['currency'])) ? $request['payload']['payment']['entity']['currency'] : "INR";
            //     $this->load->library("razorpay");
            //     $response = $this->razorpay->capture_payment($amount * 100, $txn_id, $currency);
            //     return;
            // }
            if ($data['Event'] == 'TransactionsStatusChanged') {






                if ($data['Data']['TransactionStatus'] == "FAILED") {



                    if (!empty($order_id)) {
                        // update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');
                        update_details(['active_status' => 'cancelled'], ['order_id' => $order_id], 'order_items');
                    }
                    /* No need to add because the transaction is already added just update the transaction status */
                    if (!empty($transaction)) {
                        $transaction_id = $transaction[0]['id'];
                        update_details(['status' => 'failed'], ['id' => $transaction_id], 'transactions');
                    }
                    $response['error'] = true;
                    $response['transaction_status'] = $data['Data']['TransactionStatus'];
                    $response['message'] = "Transaction is failed. ";
                    log_message('error', 'Razorpay Webhook | Transaction is failed --> ' . var_export($data['Data']['TransactionStatus'], true));
                    echo json_encode($response);
                    return false;
                } else if ($data['Data']['TransactionStatus'] == "SUCCESS") {


                    if ($data['Event'] == 'TransactionsStatusChanged') {
                        $order_id = $data['Data']['UserDefinedField'];
                        $order_data = fetch_orders($order_id);
                        $user_id = (isset($order_data['order_data'][0]['user_id'])) ? $order_data['order_data'][0]['user_id'] : "";
                    }
                    if (!empty($order_id)) {
                        /* To do the wallet recharge if the order id is set in the patter */
                        if (strpos($order_id, "wallet-refill-user") !== false) {
                            if (!is_numeric($order_id) && strpos($order_id, "wallet-refill-user") !== false) {
                                $temp = explode("-", $order_id);
                                if (isset($temp[3]) && is_numeric($temp[3]) && !empty($temp[3] && $temp[3] != '')) {
                                    $user_id = $temp[3];
                                } else {
                                    $user_id = 0;
                                }
                            }

                            $data['transaction_type'] = "wallet";
                            $data['user_id'] = $user_id;
                            $data['order_id'] = $order_id;
                            $data['type'] = "credit";
                            $data['txn_id'] = $txn_id;
                            $data['amount'] = $amount;
                            $data['status'] = "success";
                            $data['message'] = "Wallet refill successful";
                            log_message('error', 'My fatoorah user ID -  transaction data--> ' . var_export($data, true));


                            $this->transaction_model->add_transaction($data);
                            log_message('error', 'My Fatoorah user ID - Add transaction --> ' . var_export($txn_id, true));

                            $this->load->model('customer_model');
                            if ($this->customer_model->update_balance($amount, $user_id, 'add')) {
                                $response['error'] = false;
                                $response['transaction_status'] = $data['Data']['TransactionStatus'];
                                $response['message'] = "Wallet recharged successfully!";
                                log_message('error', 'My fatoorah user ID - Wallet recharged successfully --> ' . var_export($order_id, true));
                            } else {
                                $response['error'] = true;
                                $response['transaction_status'] = $data['Data']['TransactionStatus'];
                                $response['message'] = "Wallet could not be recharged!";
                                log_message('error', 'My Fatoorah Webhook | wallet recharge failure --> ' . var_export($data['Data']['TransactionStatus'], true));
                            }
                            echo json_encode($response);
                            return false;
                        } else {

                            /* process the order and mark it as received */
                            $order = fetch_orders($order_id, false, false, false, false, false, false, false);
                            if (isset($order['order_data'][0]['user_id'])) {
                                $user = fetch_details('users', ['id' => $order['order_data'][0]['user_id']]);
                                $overall_total = array(
                                    'total_amount' => $order['order_data'][0]['total'],
                                    'delivery_charge' => $order['order_data'][0]['delivery_charge'],
                                    'tax_amount' => $order['order_data'][0]['total_tax_amount'],
                                    'tax_percentage' => $order['order_data'][0]['total_tax_percent'],
                                    'discount' => $order['order_data'][0]['promo_discount'],
                                    'wallet' => $order['order_data'][0]['wallet_balance'],
                                    'final_total' => $order['order_data'][0]['final_total'],
                                    'otp' => $order['order_data'][0]['otp'],
                                    'address' => $order['order_data'][0]['address'],
                                    'payment_method' => $order['order_data'][0]['payment_method'],
                                );

                                $overall_order_data = array(
                                    'cart_data' => $order['order_data'][0]['order_items'],
                                    'order_data' => $overall_total,
                                    'subject' => 'Order received successfully',
                                    'user_data' => $user[0],
                                    'system_settings' => $system_settings,
                                    'user_msg' => 'Hello, Dear ' . ucfirst($user[0]['username']) . ', We have received your order successfully. Your order summaries are as followed',
                                    'otp_msg' => 'Here is your OTP. Please, give it to delivery boy only while getting your order.',
                                );

                                if (isset($user[0]['email']) && !empty($user[0]['email'])) {
                                    send_mail($user[0]['email'], 'Order received successfully', $this->load->view('admin/pages/view/email-template.php', $overall_order_data, true));
                                }
                                /* No need to add because the transaction is already added just update the transaction status */
                                if (!empty($transaction)) {
                                    $transaction_id = $transaction[0]['id'];
                                    update_details(['status' => 'success'], ['id' => $transaction_id], 'transactions');
                                } else {
                                    /* add transaction of the payment */
                                    $amount = ($data['Data']['InvoiceValueInBaseCurrency']);
                                    $data = [
                                        'transaction_type' => 'transaction',
                                        'user_id' => $user_id,
                                        'order_id' => $order_id,
                                        'type' => 'my fatoorah',
                                        'txn_id' => $txn_id,
                                        'amount' => $amount,
                                        'status' => 'success',
                                        'message' => 'order placed successfully',
                                    ];
                                    $this->transaction_model->add_transaction($data);
                                }
                                update_details(['active_status' => 'received'], ['id' => $order_id], 'orders');
                                $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                                update_details(['status' => $status], ['id' => $order_id], 'orders', false);

                                update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                                $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                                update_details(['status' => $status], ['order_id' => $order_id], 'order_items', false);

                                // place order custome notification on payment success

                                $custom_notification = fetch_details('custom_notifications', ['type' => "place_order"], '');
                                $hashtag_order_id = '< order_id >';
                                $string = json_encode($custom_notification[0]['title'], JSON_UNESCAPED_UNICODE);
                                $hashtag = html_entity_decode($string);
                                $data1 = str_replace($hashtag_order_id, $order_id, $hashtag);
                                $title = output_escaping(trim($data1, '"'));
                                $hashtag_application_name = '< application_name >';
                                $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                                $hashtag = html_entity_decode($string);
                                $data2 = str_replace($hashtag_application_name, $system_settings['app_name'], $hashtag);
                                $message = output_escaping(trim($data2, '"'));

                                $fcm_admin_subject = (!empty($custom_notification)) ? $title : 'New order placed ID #' . $order_id;
                                $fcm_admin_msg = (!empty($custom_notification)) ? $message : 'New order received for  ' . $system_settings['app_name'] . ' please process it.';
                                $user_fcm = fetch_details('users', ['id' => $user_id], 'fcm_id');
                                $user_fcm_id[0][] = $user_fcm[0]['fcm_id'];
                                if (!empty($user_fcm_id)) {
                                    $fcmMsg = array(
                                        'title' => $fcm_admin_subject,
                                        'body' => $fcm_admin_msg,
                                        'type' => "place_order",
                                        'content_available' => true,
                                    );
                                    send_notification($fcmMsg, $user_fcm_id);
                                }
                                // update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');
                            }
                        }
                    } else {
                        log_message('error', 'My Fatoorah Order id not found --> ' . var_export($data['data'], true));
                        /* No order ID found */
                    }

                    $response['error'] = false;
                    $response['transaction_status'] = $data['Data']['TransactionStatus'];
                    $response['message'] = "Transaction successfully done";
                    echo json_encode($response);
                    return false;
                }
            }


            // $this->$data['Event']($data['Data']);

        }
    }


    public function validateSignature($body, $secret, $MyFatoorah_Signature)
    {

        if ($body['Event'] == 'RefundStatusChanged') {
            unset($body['Data']['GatewayReference']);
        }
        $data = $body['Data'];

        //1- Order all data properties in alphabetic and case insensitive.
        uksort($data, 'strcasecmp');

        //2- Create one string from the data after ordering it to be like that key=value,key2=value2 ...
        $orderedData = implode(
            ',',
            array_map(
                function ($v, $k) {
                    return sprintf("%s=%s", $k, $v);
                },
                $data,
                array_keys($data)
            )
        );

        //4- Encrypt the string using HMAC SHA-256 with the secret key from the portal in binary mode.
        //Generate hash string
        $result = hash_hmac('sha256', $orderedData, $secret, true);

        //5- Encode the result from the previous point with base64.
        $hash = base64_encode($result);

        error_log(PHP_EOL . date('d.m.Y h:i:s') . ' - Generated Signature  - ' . $hash, 3, './webhook.log');
        error_log(PHP_EOL . date('d.m.Y h:i:s') . ' - MyFatoorah-Signature - ' . $MyFatoorah_Signature, 3, './webhook.log');

        //6- Compare the signature header with the encrypted hash string. If they are equal, then the request is valid and from the MyFatoorah side.
        if ($MyFatoorah_Signature === $hash) {
            error_log(PHP_EOL . date('d.m.Y h:i:s') . ' - Signature is valid ', 3, './webhook.log');

            // log_message('error', $body);
            // log_message('error', $result);

            log_message("error", "SIGNATURE MATCHED");
            return true;
        } else {
            error_log(PHP_EOL . date('d.m.Y h:i:s') . ' - Signature is not valid ', 3, './webhook.log');
            exit;
        }
    }

    // ------------------------------------------------ Instamojo PAYMENT GATEWAY ------------------------------------------


    public function instamojo_webhook()
    {
        $this->load->library(['instamojo']);
        $system_settings = get_settings('system_settings', true);
        $request = file_get_contents('php://input');

        // $request = json_decode($request, true);

        log_message('error', 'instamojo file webhook--> ' . var_export($request, true));
        log_message('error', 'instamojo file webhook--> ' . var_export($_POST['purpose'], true));


        $txn_id = (isset($_POST['payment_id'])) ? $_POST['payment_id'] : "";

        if (!empty($txn_id)) {

            $transaction = fetch_details('transactions', ['txn_id' => $txn_id], '*');

            $amount = $_POST['amount'];
        } else {
            $amount = 0;
        }


        if (!empty($transaction)) {
            $order_id = $_POST['purpose'];
            log_message('error', 'instamojo Webhook | transaction order id --> ' . var_export($order_id, true));
            $user_id = $transaction[0]['user_id'];
        } else {
            $order_id = 0;
            $order_id = ($order_id = $_POST['purpose']) ? $order_id = $_POST['purpose'] : $order_id = $_POST['purpose'];
            $order_data = fetch_orders($order_id);
            $user_id = (isset($order_data['order_data'][0]['user_id'])) ? $order_data['order_data'][0]['user_id'] : "";
        }

        $this->load->model('transaction_model');
        if ($_POST['status'] == 'Credit' || $_POST['status'] == 'credit') {

            if (!empty($order_id)) {
                /* To do the wallet recharge if the order id is set in the patter */
                if (strpos($order_id, "wallet-refill-user") !== false) {
                    if (!is_numeric($order_id) && strpos($order_id, "wallet-refill-user") !== false) {
                        $temp = explode("-", $order_id);
                        if (isset($temp[3]) && is_numeric($temp[3]) && !empty($temp[3] && $temp[3] != '')) {
                            $user_id = $temp[3];
                        } else {
                            $user_id = 0;
                        }
                    }

                    $data['transaction_type'] = "wallet";
                    $data['user_id'] = $user_id;
                    $data['order_id'] = $order_id;
                    $data['type'] = "credit";
                    $data['txn_id'] = $txn_id;
                    $data['amount'] = $amount;
                    $data['status'] = "success";
                    $data['message'] = "Wallet refill successful";

                    $this->transaction_model->add_transaction($data);

                    $this->load->model('customer_model');
                    if ($this->customer_model->update_balance($amount, $user_id, 'add')) {
                        $response['error'] = false;
                        $response['transaction_status'] = $_POST['status'];
                        $response['message'] = "Wallet recharged successfully!";
                    } else {
                        $response['error'] = true;
                        $response['transaction_status'] = $_POST['status'];
                        $response['message'] = "Wallet could not be recharged!";
                    }
                    echo json_encode($response);
                    return false;
                } else {

                    /* process the order and mark it as received */
                    $order = fetch_orders($order_id, false, false, false, false, false, false, false);

                    if (isset($order['order_data'][0]['user_id'])) {
                        $user = fetch_details('users', ['id' => $order['order_data'][0]['user_id']]);
                        $overall_total = array(
                            'total_amount' => $order['order_data'][0]['total'],
                            'delivery_charge' => $order['order_data'][0]['delivery_charge'],
                            'tax_amount' => $order['order_data'][0]['total_tax_amount'],
                            'tax_percentage' => $order['order_data'][0]['total_tax_percent'],
                            'discount' =>  $order['order_data'][0]['promo_discount'],
                            'wallet' =>  $order['order_data'][0]['wallet_balance'],
                            'final_total' =>  $order['order_data'][0]['final_total'],
                            'otp' => $order['order_data'][0]['otp'],
                            'address' =>  $order['order_data'][0]['address'],
                            'payment_method' => $order['order_data'][0]['payment_method']
                        );

                        $overall_order_data = array(
                            'cart_data' => $order['order_data'][0]['order_items'],
                            'order_data' => $overall_total,
                            'subject' => 'Order received successfully',
                            'user_data' => $user[0],
                            'system_settings' => $system_settings,
                            'user_msg' => 'Hello, Dear ' . ucfirst($user[0]['username']) . ', We have received your order successfully. Your order summaries are as followed',
                            'otp_msg' => 'Here is your OTP. Please, give it to delivery boy only while getting your order.',
                        );
                        if (isset($user[0]['email']) && !empty($user[0]['email'])) {
                            send_mail($user[0]['email'], 'Order received successfully', $this->load->view('admin/pages/view/email-template.php', $overall_order_data, TRUE));
                        }
                        /* No need to add because the transaction is already added just update the transaction status */
                        if (!empty($transaction)) {
                            $transaction_id = $transaction[0]['id'];
                            update_details(['status' => 'success'], ['id' => $transaction_id], 'transactions');
                        } else {
                            /* add transaction of the payment */
                            $amount = ($request['payload']['payment']['entity']['amount'] / 100);
                            $data = [
                                'transaction_type' => 'transaction',
                                'user_id' => $user_id,
                                'order_id' => $order_id,
                                'type' => 'instamojo',
                                'txn_id' => $txn_id,
                                'amount' => $amount,
                                'status' => 'success',
                                'message' => 'order placed successfully',
                            ];
                            $this->transaction_model->add_transaction($data);
                        }

                        update_details(['active_status' => 'received'], ['id' => $order_id], 'orders');
                        update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                        $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $status], ['order_id' => $order_id], 'order_items', false);
                        update_details(['status' => $status], ['id' => $order_id], 'orders', false);

                        // place order custome notification on payment success

                        $custom_notification = fetch_details('custom_notifications', ['type' => "place_order"], '');
                        $hashtag_order_id = '< order_id >';
                        $string = json_encode($custom_notification[0]['title'], JSON_UNESCAPED_UNICODE);
                        $hashtag = html_entity_decode($string);
                        $data1 = str_replace($hashtag_order_id, $order_id, $hashtag);
                        $title = output_escaping(trim($data1, '"'));
                        $hashtag_application_name = '< application_name >';
                        $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                        $hashtag = html_entity_decode($string);
                        $data2 = str_replace($hashtag_application_name, $system_settings['app_name'], $hashtag);
                        $message = output_escaping(trim($data2, '"'));

                        $fcm_admin_subject = (!empty($custom_notification)) ? $title : 'New order placed ID #' . $order_id;
                        $fcm_admin_msg = (!empty($custom_notification)) ? $message : 'New order received for  ' . $system_settings['app_name'] . ' please process it.';
                        $user_fcm = fetch_details('users', ['id' => $user_id], 'fcm_id');
                        $user_fcm_id[0][] = $user_fcm[0]['fcm_id'];
                        if (!empty($user_fcm_id)) {
                            $fcmMsg = array(
                                'title' => $fcm_admin_subject,
                                'body' => $fcm_admin_msg,
                                'type' => "place_order",
                                'content_available' => true
                            );
                            send_notification($fcmMsg, $user_fcm_id);
                        }
                        update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');
                    }
                }
            } else {
                log_message('error', 'instamojo Order id not found --> ' . var_export($request, true));
                /* No order ID found */
            }

            $response['error'] = false;
            $response['transaction_status'] = $request['event'];
            $response['message'] = "Transaction successfully done";
            echo json_encode($response);
            return false;
        } elseif ($_POST['status'] == 'Failed' || $_POST['status'] == 'failed') {
            //$order = fetch_orders($order_id, false, false, false, false, false, false, false);

            if (!empty($order_id)) {
                // update_stock($order['order_data'][0]['product_variant_ids'], $order['order_data'][0]['quantity'], 'plus');

                update_details(['active_status' => 'received'], ['id' => $order_id], 'orders');
                update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                update_details(['status' => $status], ['order_id' => $order_id], 'order_items', false);
                update_details(['status' => $status], ['id' => $order_id], 'orders', false);
            }
            /* No need to add because the transaction is already added just update the transaction status */
            if (!empty($transaction)) {
                $transaction_id = $transaction[0]['id'];
                update_details(['status' => 'failed'], ['id' => $transaction_id], 'transactions');
            }
            $response['error'] = true;
            $response['transaction_status'] = $_POST['status'];
            $response['message'] = "Transaction is failed. ";

            echo json_encode($response);
            return false;
        } else {
            $response['error'] = true;
            $response['transaction_status'] = $_POST['status'];
            $response['message'] = "Transaction could not be detected.";
            echo json_encode($response);
            return false;
        }
    }

    // ------------------------------------------------ PHONEPE PAYMENT GATEWAY ------------------------------------------

    public function phonepe_webhook()
    {
        $this->load->library(['Phonepe']);
        $system_settings = get_settings('system_settings', true);
        $request = file_get_contents('php://input');

        $request = (json_decode($request, 1));
        $request = (isset($request['response'])) ? $request['response'] : "";
        log_message('error', 'phonepe file webhook--> ' . var_export($request, true));
        if (!empty($request)) {

            $request = base64_decode($request);
            $request = json_decode($request, 1);
            log_message('error', 'phonepe server webhook--> ' . var_export($_SERVER, true));

            $txn_id = (isset($request['data']['merchantTransactionId'])) ? $request['data']['merchantTransactionId'] : "";
            if (!empty($txn_id)) {
                $transaction = fetch_details('transactions', ['txn_id' => $txn_id], '*');
                $amount = $request['data']['amount'] / 100;
            } else {
                $amount = 0;
            }

            if (!empty($transaction)) {
                $user_id = $transaction[0]['user_id'];
                $transaction_type = (isset($transaction[0]['transaction_type'])) ? $transaction[0]['transaction_type'] : "";
                $order_id = (isset($transaction[0]['order_id'])) ? $transaction[0]['order_id'] : "";
                log_message('error', 'Phonepe Webhook | transaction_type --> ' . var_export($transaction_type, true));
                log_message('error', 'Phonepe Webhook | transaction order id --> ' . var_export($order_id, true));
            } else {
                log_message('error', 'Phonepe transaction id not found in local database--> ' . var_export($request, true));
                die;
            }

            $status = (isset($request['code'])) ? $request['code'] : "";

            $this->load->model('transaction_model');

            $check_status = $this->phonepe->check_status($txn_id);
            if ($check_status) {
                if ($status == 'PAYMENT_SUCCESS') {
                    $data['status'] = "success";
                    if ($transaction_type == "wallet") {
                        $data['status'] = "success";
                        $data['message'] = "Wallet refill successful";
    
                        $this->transaction_model->update_transaction($data, $txn_id);

                        $this->load->model('customer_model');
                        if (!$this->customer_model->update_balance($amount, $user_id, 'add')) {

                            log_message('error', 'Phonepe Webhook | couldn\'t update in wallet balance  --> ' . var_export($request, true));
                            die;
                        }

                        return false;
                    } elseif ($transaction_type == "transaction") {
                        $data['message'] = "Payment received successfully";
                        
                        update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                        $order_status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $order_status], ['order_id' => $order_id], 'order_items', false);
                        
                        update_details(['active_status' => 'received'], ['id' => $order_id], 'orders');
                        $order_status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $order_status], ['id' => $order_id], 'orders', false);
                    }
                    $this->transaction_model->update_transaction($data, $txn_id);
                } elseif ($status == "BAD_REQUEST"  || $status == "AUTHORIZATION_FAILED" || $status == "PAYMENT_ERROR" || $status == "TRANSACTION_NOT_FOUND" || $status == "PAYMENT_DECLINED" || $status == "TIMED_OUT") {
                    $data['status'] = "failed";
                    if ($transaction_type == "wallet") {
                        $data['status'] = "failed";
                        $data['message'] = "Wallet could not be recharged!";
    
                        $this->transaction_model->update_transaction($data, $txn_id);
                    } elseif ($transaction_type == "transaction") {
                        update_details(['active_status' => 'cancelled'], ['order_id' => $order_id], 'order_items');
                        $order_status = json_encode(array(array('cancelled', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $order_status], ['order_id' => $order_id], 'order_items', false);

                        update_details(['active_status' => 'cancelled'], ['id' => $order_id], 'orders');
                        $order_status = json_encode(array(array('cancelled', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $order_status], ['id' => $order_id], 'orders', false);
                        $data['message'] = "Payment couldn't be processed!";
                    }
                    $this->transaction_model->update_transaction($data, $txn_id);
                }
            } else {
                log_message('error', 'Phonepe transaction id not found in phonepe--> ' . var_export($request, true));
            }
        } else {
            log_message('error', 'No Request Found--> ' . var_export($request, true));
        }
    }

    public function test_wabhook()
    {

        $request = '{"response":"eyJzdWNjZXNzIjp0cnVlLCJjb2RlIjoiUEFZTUVOVF9TVUNDRVNTIiwibWVzc2FnZSI6IllvdXIgcGF5bWVudCBpcyBzdWNjZXNzZnVsLiIsImRhdGEiOnsibWVyY2hhbnRJZCI6IlBHVEVTVFBBWVVBVCIsIm1lcmNoYW50VHJhbnNhY3Rpb25JZCI6IjE2OTYyMTk4Mzk5MzEiLCJ0cmFuc2FjdGlvbklkIjoiVDIzMTAwMjA5NDA0MDE2NDg0Mjk2MTEiLCJhbW91bnQiOjEwMjAwLCJzdGF0ZSI6IkNPTVBMRVRFRCIsInJlc3BvbnNlQ29kZSI6IlNVQ0NFU1MiLCJwYXltZW50SW5zdHJ1bWVudCI6eyJ0eXBlIjoiTkVUQkFOS0lORyIsInBnVHJhbnNhY3Rpb25JZCI6IjE5OTU0NjQ3NzMiLCJwZ1NlcnZpY2VUcmFuc2FjdGlvbklkIjoiUEcyMjEyMjkxNjA3MDgzMzQ0OTM0MzAwIiwiYmFua1RyYW5zYWN0aW9uSWQiOm51bGwsImJhbmtJZCI6IiJ9fX0="}';
        $request = (json_decode($request, 1));
        $request = (isset($request['response'])) ? $request['response'] : "";
        $request =  base64_decode($request);
        $request =  json_decode($request, 1);
        echo "<pre>";
        print_r($request);
    }
}
