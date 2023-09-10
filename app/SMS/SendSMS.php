<?php

namespace App\SMS;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendSMS extends Notification implements ShouldQueue
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

    public function sendSMSInfo () {
        try{
            $sender_id = 'AHMDZS';
            $template_id = '1501662400000058538';
            $phone = $this->content['phone'];
            $msg = $this->content['sms'];
            $username = 'Adminrudras';
            $apikey = 'BF39D-5BAE2';
            $uri = 'http://powerstext.in/sms-panel/api/http/index.php?username=Adminrudras&apikey=BF39D-5BAE2&apirequest=Text&sender='.$sender_id.'&mobile='.$this->content['phone'].'&message='.$this->content['sms'].'&route=TRANS&TemplateID='.$template_id.'&format=JSON';
//	echo "<br>".$uri."</br>";
	// return 0;
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
//	echo $output;
	// json_encode(compact('resp', 'error'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}