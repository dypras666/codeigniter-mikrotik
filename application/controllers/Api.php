<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Api extends CI_Controller {	
	private $connect;	
	function __construct(){
		parent::__construct();		
        $this->load->config('fcm'); 				
		$this->connect = $this->routerapi->connect($this->config->item('mikrotik_ip'),$this->config->item('mikrotik_user'),$this->config->item('mikrotik_pass'));		  
	}
    public function sendNotification()
    {
        $token = 'Registratin_id'; // push token
        $message = "Test notification message";

        $this->load->library('fcm');
        $this->fcm->setTitle('Test FCM Notification');
        $this->fcm->setMessage($message);

        /**
         * set to true if the notificaton is used to invoke a function
         * in the background
         */
        $this->fcm->setIsBackground(false);

        /**
         * payload is userd to send additional data in the notification
         * This is purticularly useful for invoking functions in background
         * -----------------------------------------------------------------
         * set payload as null if no custom data is passing in the notification
         */
        $payload = array('notification' => '');
        $this->fcm->setPayload($payload);

        /**
         * Send images in the notification
         */
        $this->fcm->setImage('https://firebase.google.com/_static/9f55fd91be/images/firebase/lockup.png');

        /**
         * Get the compiled notification data as an array
         */
        $json = $this->fcm->getPush();

        $p = $this->fcm->send($token, $json);

        print_r($p);
    }

    /**
     * Send to multiple devices
     */
    public function sendToMultiple()
    {
        $token = array('Registratin_id1', 'Registratin_id2'); // array of push tokens
        $message = "Test notification message";

        $this->load->library('fcm');
        $this->fcm->setTitle('Test FCM Notification');
        $this->fcm->setMessage($message);
        $this->fcm->setIsBackground(false);
        // set payload as null
        $payload = array('notification' => '');
        $this->fcm->setPayload($payload);
        $this->fcm->setImage('https://firebase.google.com/_static/9f55fd91be/images/firebase/lockup.png');
        $json = $this->fcm->getPush();

        /** 
         * Send to multiple
         * 
         * @param array  $token     array of firebase registration ids (push tokens)
         * @param array  $json      return data from getPush() method
         */
        $result = $this->fcm->sendMultiple($token, $json);
    }
}