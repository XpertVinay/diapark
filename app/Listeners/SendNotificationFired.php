<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use App\Mail\SendMail;
use Mail;

use App\SMS\SendSMS;
use App\WhatsApp\SendWhatsApp;

use App\Notification\Notifications;

class SendNotificationFired extends Notification implements ShouldQueue
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
            // print_r('print1'); 
        } catch (\Exception $e) {
            print_r($e->getMessage());
            return;
        }
    }

    private function sendSMS ($data) {
        // sms api integration
        try{
            $sendSMS = new SendSMS($data);
            $sendSMS->sendSMSInfo();
            // print_r('print2');
	    return;
        } catch (\Exception $e) {
             dd($e->getMessage());
            return;
        }
    }

    private function sendWhatsApp ($data) {
        // whatsapp api integration
        try{
            $whatsApp = new SendWhatsApp($data);
            $whatsApp->sendWhatsAppInfo();
            // print_r('print3');
        } catch (\Exception $e) {
  	    print_r($e->getMessage());
            return;
        }
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Notifications  $event
     * @return void
     */
    public function handle(Notifications $event)
    {
        // echo "<pre>";
        // print_r($event->data);
        forEach($event->data['type'] as $type){
            switch ($type) {
                case 'email':
                    $this->sendMail($event->data);
                    // echo "\nEMAIL\n";
                    break;
                case 'sms':
                    $this->sendSMS($event->data);
                    // echo "\nSMS\n";
                    break;
                case 'whatsapp':
                    $this->sendWhatsApp($event->data);
                    // echo "\nWHATSAPP\n";
                    break;
                default:
                    break;
            }
        }
	    // dd('print');
    }
}
