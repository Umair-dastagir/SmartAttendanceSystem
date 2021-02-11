<?php
/*
---------------------------------------------------------------------------------------
Aurthor	:	{G}
Title	:	This class is a library for sending Push notification
---------------------------------------------------------------------------------------
*/

class Pushnotification
{
    private $CI;
 
    function __construct()
    {
        $this->CI = get_instance();
        $this->CI->load->model('App_settings','bwmapp');


    }
    public function push_notification_firebase_key()
    {
        $push_notification_firebase_key = $this->CI->bwmapp->push_notification_firebase_key(1);
        return $push_notification_firebase_key;

    }
 
    function push_notification_message($fcm_token, $title, $message)
    {

		// define('API_ACCESS_KEY', $this->push_notification_firebase_key());
		$msg = array(
			'title'	=>	$title,
			'body'	=>	$message
		);
        
        $fields = array(
    		'to'	=> $fcm_token,
    		'notification'	=> $msg
		);

		$headers = array(
    		'Authorization: key=' . $this->push_notification_firebase_key(),
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
        curl_close( $ch );
        $mydata = json_decode($result);
        // if($mydata->success == TRUE)
        // {
        //     return TRUE;
        // }else
        // {
        //     return FALSE;
        // }

        //return ($mydata->success === TRUE) ? success : FALSE;
		//var_dump($result);
		//echo ($mydata->success === 1) ? success : fail;
	}
}
