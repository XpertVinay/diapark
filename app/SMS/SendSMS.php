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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://9r4km3.api.infobip.com/sms/2/text/advanced',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"messages":[{"destinations":[{"to":"'.config('app.country_code').$this->content['phone'].'"}],"from":"InfoSMS","text":"'.$this->content['sms'].'"}]}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App 3f570cfa399f53f9e2ca4448fd4ebea3-c6e59d7c-bff6-4eed-87ed-7508fcf3c273',
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        // dd($response);
    }
}
