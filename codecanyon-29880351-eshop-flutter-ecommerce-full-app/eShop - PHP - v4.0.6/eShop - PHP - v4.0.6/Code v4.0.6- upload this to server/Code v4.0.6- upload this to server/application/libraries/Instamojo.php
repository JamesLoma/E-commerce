<?php
/* 
    1. get_credentials()
    2. create_order($amount,$receipt='')
    3. fetch_payments($id ='')
    4. capture_payment($amount, $id, $currency = "INR")
    5. verify_payment($order_id, $razorpay_payment_id, $razorpay_signature)

    0. curl($url, $method = 'GET', $data = [])
*/
class Instamojo
{
    private $client_id = "";
    private $client_secret = "";
    private $url = "";

    function __construct()
    {
        $settings = get_settings('payment_method', true);
        $system_settings = get_settings('system_settings', true);

        $this->client_id = (isset($settings['instamojo_client_id'])) ? $settings['instamojo_client_id'] : "";
        $this->client_secret = (isset($settings['instamojo_client_secret'])) ? $settings['instamojo_client_secret'] : "";
        $this->url = (isset($settings['instamojo_payment_mode']) && $settings['instamojo_payment_mode'] == "sandbox") ? 'https://test.instamojo.com/' : 'https://www.instamojo.com/';
    }
    public function generate_token()
    {

        $client_id = $this->client_id;
        $client_secret = $this->client_secret;
        $url = $this->url . 'oauth2/token/';
        $method = 'POST';
        $payload = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];

        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
        );
        if (strtolower($method) == 'post') {
            $curl_options[CURLOPT_POST] = 1;
            $curl_options[CURLOPT_POSTFIELDS] = http_build_query($payload);
        } else {
            $curl_options[CURLOPT_CUSTOMREQUEST] = 'GET';
        }
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        $data = json_decode($result['body'], true);
        $token = $data['access_token'];
        return $token;
    }
    public function payment_requests($data)
    {
        $url = $this->url . 'v2/payment_requests/';
        $method = 'POST';
        $payload = [
            'purpose' => $data['purpose'],
            'amount' => $data['amount'],
            'buyer_name' => $data['buyer_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'redirect_url' => $data['redirect_url'],
            'webhook' => base_url('admin/webhook/instamojo_webhook'),
            'allow_repeated_payments' => 'False',
        ];

       
        $response = $this->curl($url, $method, $payload);
        $res = json_decode($response['body'],true);
        $res['http_code'] = $response['http_code'];
        return $res;
    }

    public function payment_requests_detail($id)
    {
        $url = $this->url . 'v2/payment_requests/'.$id.'/';
    
        $response = $this->curl($url);
        // $res = json_decode($response['body'], true);
        return $response;
    }

    public function curl($url, $method = 'GET', $data = [])
    {
        $token = $this->generate_token();

        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            )
        );
        if (strtolower($method) == 'post') {
            $curl_options[CURLOPT_POST] = 1;
            $curl_options[CURLOPT_POSTFIELDS] = http_build_query($data);
        } else {
            $curl_options[CURLOPT_CUSTOMREQUEST] = 'GET';
        }
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        return $result;
    }
}
