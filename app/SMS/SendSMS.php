<?php

namespace App\SMS;


class SendSMS
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

    public function sendSMS()
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
    	$ch = curl_init('https://api.textlocal.in/send/');
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($ch);
    	curl_close($ch);

    	// Process your response here
    	dd($response);
    }

    public function sendSMSInfo () {
        try{
            $sender_id = 'AHMDZS';
            $template_id = '1501662400000058538';
            $phone = rawurlencode($this->content['sms']);
            $msg = $this->content['sms'];
            $username = 'Adminrudras';
            $apikey = 'BF39D-5BAE2';
            $uri = 'http://powerstext.in/sms-panel/api/http/index.php?username=Adminrudras&apikey=BF39D-5BAE2&apirequest=Text&sender='.$sender_id.'&mobile='.$this->content['phone_number'].'&message='.$this->content['sms'].'&route=TRANS&TemplateID='.$template_id.'&format=JSON';

            dd($uri);
        // create curl resource

        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $uri);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
            echo json_encode(compact('resp', 'error'));
        } catch (\Exception $e) {
            print_r($e);
        }
    }
}
