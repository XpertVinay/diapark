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

    public function sendWhatsAppInfo()
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

}
