<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\Firebase;

class Api extends CI_Controller
{
	private $connect;
	function __construct()
	{
		parent::__construct();
		$this->connect = $this->routerapi->connect($this->config->item('mikrotik_ip'), $this->config->item('mikrotik_user'), $this->config->item('mikrotik_pass'));
	}

	function send($token = "")
	{
		$token = "d4cKCsltj1k8FuI9NFH3DG:APA91bHWUGWLPeOOGA61HUe4BJlYXlR2p3EUQ5f2ve7vOJCLyz1prMxzbJwwBRtIdimaylS4E6DVfcBrcKR1I0QijP5uyLTZH_2u9VhrqJYt_S4LKGPkHvVysT_gTN89WGVE-muz_BGw";
		$SERVER_API_KEY = 'AAAAiGH35Sc:APA91bFJ3_C9BF6HBY8nuJnZtAQFqkZg5chrSVTVxIIt0IcJUPqzxAgqBU_y5p-QoF9hrmWmeCpNEx5boAM7Oon8xzYQus88bRYTJVlQf2MCLQDzaICXYB30fkA4P-k02GmJoRfQddDu';

		$data = [
			"registration_ids" => [$token],
			"notification" => [
				"title" => $this->input->get('title'),
				"body" => $this->input->get('text'),
			]
		];
		$dataString = json_encode($data);

		$headers = [
			'Authorization: key=' . $SERVER_API_KEY,
			'Content-Type: application/json',
		];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

		$response = curl_exec($ch);
		return json_encode($response);
	}
}
