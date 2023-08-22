<?php

namespace App\SMS;


class SendWhatsApp
{

    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    public function sendWhatsApp()
    {
        // Account details
    	$apiKey = urlencode(config('app.txtlcl_api_key'));

    	// Message details
    	$numbers = array(config('app.country_code').$this->content['phone']);
    	$sender = urlencode(config('app.sender'));
    	$message = rawurlencode($this->content['sms']);

    	$numbers = implode(',', $numbers);

    	// Prepare data for POST request
    	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message, 'test' => config('app.test'));
    // 	dd($data);

    	// Send the POST request with cURL
    	$ch = curl_init('https://wapi.powerstext.in/api/send');
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($ch);
    	curl_close($ch);
    }

    public function sendWhatsAppInfo () {
        try{

            $access_token = '64d9b07da0b72';
            $phone = $this->content['phone_number'];
            $msg = $this->content['wahtsApp'];
            $uri = 'https://wapi.powerstext.in/api/send';
            $data = array(
                'number'=> $phone_number,
                'type'=> "text",
                'message'=> $msg,
                'instance_id' => '64E361E5A2C58',
                'access_token'=> $access_token,
            );

            dd($data);

            $ch = curl_init($uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            $resp = curl_exec($ch);
            $error = curl_error($ch);
            curl_close ($ch);
            echo json_encode(compact('resp', 'error'));
        } catch (\Exception $e) {
            print_r($e);
        }
    }
}
