<?php
/* 
    1. get_credentials()
    2. create_order($amount,$receipt='')
    3. fetch_payments($id ='')
    4. capture_payment($amount, $id, $currency = "INR")
    5. verify_payment($order_id, $razorpay_payment_id, $razorpay_signature)

    0. curl($url, $method = 'GET', $data = [])
*/
class Phonepe
{
    private $salt_index = "";
    private $salt_key = "";
    private $merchant_id = "";
    private $url = "";

    function __construct()
    {
        $settings = get_settings('payment_method', true);
        $system_settings = get_settings('system_settings', true);

        $this->salt_index = (isset($settings['phonepe_salt_index'])) ? $settings['phonepe_salt_index'] : " ";
        $this->salt_key = (isset($settings['phonepe_salt_key'])) ? $settings['phonepe_salt_key'] : " ";
        $this->merchant_id = (isset($settings['phonepe_marchant_id'])) ? $settings['phonepe_marchant_id'] : " ";
        $this->url = (isset($settings['phonepe_payment_mode']) && $settings['phonepe_payment_mode'] == "live") ? "https://api.phonepe.com/apis/hermes" : "https://api-preprod.phonepe.com/apis/pg-sandbox";
    }

    public function get_credentials()
    {
        $data['salt_index'] = $this->salt_index;
        $data['salt_key'] = $this->salt_key;
        $data['merchant_id'] = $this->merchant_id;
        $data['url'] = $this->url;
        return $data;
    }

    public function pay($data)
    {
        $data['merchantId'] = $this->merchant_id;
        $data['paymentInstrument'] = array(
            'type' => 'PAY_PAGE',
        );
        $url = $this->url . '/pg/v1/pay';
        $method = 'POST';

        /** generating a X-VERIFY header */
        $encode = base64_encode(json_encode($data));
        $saltKey = $this->salt_key;
        $saltIndex = $this->salt_index;
        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;

        $header = [
            "Content-Type: application/json",
            "accept: application/json",
            "X-VERIFY: $finalXHeader"
        ];
        $response = $this->curl($url, $method, json_encode(['request' => $encode]), $header);
        $res = json_decode($response['body'], true);
        return $res;
    }

    public function phonepe_payment($data)
    {
        $data['merchantId'] = $this->merchant_id;
        // $data['paymentInstrument'] = array(
        //     // 'type' => 'PAY_PAGE',
        //     // "type"=> "UPI_INTENT",
        //     // "targetApp"=> "com.phonepe.app"
        // );
        $data['deviceContext'] = array(
            "deviceOS" => "ANDROID",
        );
        $url = $this->url . '/pg/v1/pay';
        $method = 'POST';

        /** generating a X-VERIFY header */
        $encode = base64_encode(json_encode($data));
        $saltKey = $this->salt_key;
        $saltIndex = $this->salt_index;
        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;

        $header = [
            "Content-Type: application/json",
            "accept: application/json",
            "X-VERIFY: $finalXHeader"
        ];
        $response = $this->curl($url, $method, json_encode(['request' => $encode]), $header);
        $res = json_decode($response['body'], true);
        return $res;
    }

    public function check_status($id = '')
    {
        $data['merchantId'] = $this->merchant_id;
        $data['paymentInstrument'] = array(
            'type' => 'PAY_PAGE',
        );
        $endpoint = "/pg/v1/status/$this->merchant_id/$id";
        $url = $this->url . $endpoint;
        $method = 'GET';

        /** generating a X-VERIFY header */
        $saltKey = $this->salt_key;
        $saltIndex = $this->salt_index;
        $string = $endpoint . "" . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;

        $header = [
            "Content-Type: application/json",
            "X-VERIFY: $finalXHeader",
            "X-MERCHANT-ID: $this->merchant_id",
        ];
        $response = $this->curl($url, $method, [], $header);
        $res = json_decode($response['body'], true);
        return $res;
    }
    public function curl($url, $method = 'GET', $data = [], $header = [])
    {
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => $header
        );
        if (strtolower($method) == 'post') {
            $curl_options[CURLOPT_POST] = 1;
            if (!empty($data)) {
                $curl_options[CURLOPT_POSTFIELDS] = $data;
            }
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
