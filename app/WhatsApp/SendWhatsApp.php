<?php

namespace App\WhatsApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SendWhatsApp extends Notification implements ShouldQueue
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

    public function sendWhatsAppInfoPost()
{
    try {
        $access_token = '65337fdc573c1';
        $phone = $this->content['phone'];
        $msg = $this->content['whatsapp'];
        $uri = 'https://wapp.powerstext.in/api/send';
        $data = array(
            'number' => $phone,
            'type' => "text",
            'message' => $msg,
            'instance_id' => '6546143CC0046',
            'access_token' => $access_token,
        );

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	#curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        #curl_setopt($ch, CURLOPT_HTTPHEADER, [
        #    'Content-Type: application/json'
        #]);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        $resp = curl_exec($ch);
        $error = curl_error($ch);

        if ($error) {
            // Handle cURL error
            throw new \Exception("cURL Error: $error");
        }

        // Check the HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            // Handle non-200 response codes
            throw new \Exception("HTTP Error: Received status code $httpCode");
        }

        curl_close($ch);

        echo json_encode(compact('resp', 'error'));
    } catch (\Exception $e) {
        // Handle exceptions
        print_r('WhatsApp Exception> ' . $e->getMessage());
    }
}

public function sendWhatsAppInfoGET()
{
    try {
        $access_token = '65337fdc573c1';
        $phone = $this->content['phone'];
        $msg = $this->content['whatsapp'];
        $uri = 'https://wapp.powerstext.in/api/send?number='.$phone.'&type=text&message='.$msg.'&instance_id=6546143CC0046&access_token=65337fdc573c1';

$curl = curl_init();
$curl_opt = array(
  CURLOPT_URL => $uri,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
);
print_r($curl_opt);
curl_setopt_array($curl, $curl_opt);

        $resp = curl_exec($curl);
        $error = curl_error($curl);
	echo "---->>".json_encode(compact('resp', 'error'));
	// exit();

        if ($error) {
            // Handle cURL error
            throw new \Exception("cURL Error: $error");
        }

        // Check the HTTP response code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            // Handle non-200 response codes
            throw new \Exception("HTTP Error: Received status code $httpCode");
        }

//        curl_close($curl);

        // echo "---->>".json_encode(compact('resp', 'error'));
    } catch (\Exception $e) {
        // Handle exceptions
        print_r('WhatsApp Exception> ' . $e->getMessage());
	// exit();
    }
}

function sendWhatsAppInfo () {
    $api_url = 'http://chatway.in/api/send-msg'; //if you sending with file use this send-file 
    $username = "Adminrudras";
    $number = $this->content['phone'];
    $message = $this->content['whatsapp'];
    $token = "K29ZNHBqVEJRU0Z5ZzVLc0hiUUtzZz09"; 

    // Construct the URL with properly encoded query parameters
    $query_params = http_build_query([
        'username' => $username,
        'number' => $number,
        'message' => $message,
        'token' => $token
    ]);

    $api_url .= '?' . $query_params;

    echo "API URL: $api_url<br>";

    $ch = curl_init($api_url);
    echo "cURL initialized<br>";

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if($response === false) {
        echo 'Curl error: ' . curl_error($ch) . '<br>';
    } else {
        echo 'Response: ' . $response . '<br>';
    }

    curl_close($ch);
    echo "cURL closed<br>";

}

}
