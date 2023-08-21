<?php

namespace App\Listeners;

use App\Events\SendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\SendMail;
use Mail;

use App\SMS\SendSMS;

class SendNotificationFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private function sendMail ($data) {
        try{
            Mail::to($data['email'])->send(new SendMail($data));  
	    // echo "Times    ";
        } catch (\Exception $e) {
            dd($e->getMessage());
            return;
        }
    }

    private function sendSMS ($data) {
        // sms api integration
        try{
            $sendSMS = new SendSMS($data);
            $sendSMS->sendSMSInfo();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return;
        }
    }

    private function sendWhatsApp ($data) {
        // whatsapp api integration
        try{
	//
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendNotification  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
        // dd($event->data);
        forEach($event->data['type'] as $type){
            switch ($type) {
                case 'email':
                    $this->sendMail($event->data);
                    break;
                case 'sms':
                    $this->sendSMS($event->data);
                    break;
                case 'whatsapp':
                    $this->sendWhatsApp($event->data);
                    break;
                default:
                    break;
            }
        }
	// dd('print');
    }
}
