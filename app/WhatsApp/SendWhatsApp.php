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

    /**
     * Send WhatsApp message.
     *
     * @return void
     */
    public function sendWhatsAppInfo()
    {
        $api_url = 'http://int.chatway.in/api/send-msg'; 
        $username = "Adminrudras";
        $number = $this->content['phone'];
        $message = $this->content['whatsapp'];
        $token = "L3QxSW5sVkJDRkx1QmswVWE2RVVDQT09"; 

        // Construct the URL with properly encoded query parameters
        $query_params = http_build_query([
            'username' => $username,
            'number' => $number,
            'message' => $message,
            'token' => $token
        ]);

        $api_url .= '?' . $query_params;

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            // Handle cURL error
            throw new \Exception('Curl error: ' . curl_error($ch));
        } else {
            // Optionally handle successful response
            // echo 'Response: ' . $response;
        }

        curl_close($ch);
    }
}
