<?php
include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/config/global_config.php");

// https://www.weichieprojects.com/blog/curl-api-calls-with-php/

class arcaRestAPI {
    private $global_url;

    function __construct(){
        $this->global_url = CONFIG::$SERVER_IP.":".CONFIG::$SERVER_PORT."/api/".CONFIG::$API_VERSION."/";
    }

    public function get($subUrl, $queryUrl){
        $url = $this->global_url.$subUrl;
        if($queryUrl){
            $url = $url.'?'.$queryUrl;
        }
	//print($url);
        $get_data = $this->callAPI('GET', $url, false);
        return $this->buildResult($get_data);        
    }

    public function post($subUrl, $data_array){
        // $data_array =  array(
        //     "customer"        => $user['User']['customer_id'],
        //     "payment"         => array(
        //             "number"         => $this->request->data['account'],
        //             "routing"        => $this->request->data['routing'],
        //             "method"         => $this->request->data['method']
        //     ),
        // );
        $url = $this->global_url.$subUrl;
        $make_call = callAPI('POST', $url, json_encode($data_array));
        return $this->buildResult($make_call);
    }


    // PRIVATE FUNCTION
    // ---------------------------------
    private function callAPI($method, $url, $data = false){
        $curl = curl_init();
	$url = str_replace(' ', '%20', $url);

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    private function buildResult($response){
        $data = json_decode($response, true);
        $result = array(
            'data' => $data['success'],
            "error" => $data['errMessage']
        );
        return $result;
    }
}