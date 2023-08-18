<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\Firebase;
use Firebase\Criteria;

class Setting extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->config('fcm');
	}

	public function read_token()
	{
		$filename = 'token_push.txt';
		$f = fopen($filename, 'r');

		if ($f) {
			$contents = fread($f, filesize($filename));
			fclose($f);
			return nl2br($contents);
		}
	}

	function save_token()
	{
		if ($this->input->post('firebase_token')) {
			$token = $this->session->set_userdata('firebase_token', $this->input->post('firebase_token'));
			$myfile = fopen("token_push.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $this->input->post('firebase_token'));
			fclose($myfile);

			echo json_encode(['token' =>  $this->session->userdata('firebase_token')]);
		}
	}
	public function index()
	{
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
		if ($this->input->post()) {
			$file = FCPATH . '/application/config/fcm.php';
			$content = file_get_contents($file);
			$newcontent = "<?php
defined('BASEPATH') or exit('No direct script access allowed'); \n\n";

			$newcontent .= "\n " . $this->input->post('timezone') . " \n";
			$newcontent .= "\n //firebase setting \n";
			if ($this->input->post('key')) {
				$newcontent .= '$config["key"] = "' . $this->input->post('key') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('server_api')) {
				$newcontent .= '$config["server_api"] = "' . $this->input->post('server_api') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('fcm_url')) {
				$newcontent .= '$config["fcm_url"] = "' . $this->input->post('fcm_url') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_domain')) {
				$newcontent .= '$config["firebase_domain"] = "' . $this->input->post('firebase_domain') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_database')) {
				$newcontent .= '$config["firebase_database"] = "' . $this->input->post('firebase_database') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_api')) {
				$newcontent .= '$config["firebase_api"] = "' . $this->input->post('firebase_api') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_projectID')) {
				$newcontent .= '$config["firebase_projectID"] = "' . $this->input->post('firebase_projectID') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_bucket')) {
				$newcontent .= '$config["firebase_bucket"] = "' . $this->input->post('firebase_bucket') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_sender')) {
				$newcontent .= '$config["firebase_sender"] = "' . $this->input->post('firebase_sender') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_appid')) {
				$newcontent .= '$config["firebase_appid"] = "' . $this->input->post('firebase_appid') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('firebase_measure')) {
				$newcontent .= '$config["firebase_measure"] = "' . $this->input->post('firebase_measure') . '" ; ';
				$newcontent .= "\n";
			}

			$newcontent .= "\n //mikrotik \n";
			if ($this->input->post('ip_aplikasi')) {
				$newcontent .= '$config["ip_aplikasi"] = "' . $this->input->post('ip_aplikasi') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('folder_aplikasi')) {
				$newcontent .= '$config["folder_aplikasi"] = "' . $this->input->post('folder_aplikasi') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('timezone')) {
				$newcontent .= '$config["timezone"] = "' . $this->input->post('timezone') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('mikrotik_ip')) {
				$newcontent .= '$config["mikrotik_ip"] = "' . $this->input->post('mikrotik_ip') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('mikrotik_port')) {
				$newcontent .= '$config["mikrotik_port"] = ' . $this->input->post('mikrotik_port') . ' ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('mikrotik_user')) {
				$newcontent .= '$config["mikrotik_user"] = "' . $this->input->post('mikrotik_user') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('mikrotik_pass')) {
				$newcontent .= '$config["mikrotik_pass"] = "' . $this->input->post('mikrotik_pass') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('mikrotik_default_interface')) {
				$newcontent .= '$config["mikrotik_default_interface"] = "' . $this->input->post('mikrotik_default_interface') . '" ; ';
				$newcontent .= "\n";
			}
			$newcontent .= "\n //login admin \n";
			if ($this->input->post('user')) {
				$newcontent .= '$config["user"] = "' . $this->input->post('user') . '" ; ';
				$newcontent .= "\n";
			}
			if ($this->input->post('pass')) {
				$newcontent .= '$config["pass"] = "' . $this->input->post('pass') . '" ; ';
				$newcontent .= "\n";
			}
			file_put_contents($file, "$newcontent");
			$this->session->set_flashdata('success', 'berhasil di simpan');
			redirect('setting');
		} else {
			$data = array();
			$this->load->view('template_sbadmin/header', $data);
			$this->load->view('template_sbadmin/sidebar', $data);
			$this->load->view('template_sbadmin/menu', $data);
			$this->load->view('mikrotik/setting', $data);
			$this->load->view('template_sbadmin/footer', $data);
		}
	}

	function send()
	{
		header('Content-Type: application/json');
		$stat = explode("_", $this->input->get('title'));
		$data_push = array(
			'ip' => $this->input->get('ip'),
			'comment' => $this->input->get('comment'),
			'status' => $stat[0],
			'body' => $this->input->get('text')
		);

		$this->save_status_monitoring($data_push);


		$firebaseToken = $this->read_token();
		$SERVER_API_KEY = $this->config->item('server_api');

		$data = [
			"registration_ids" => [$firebaseToken],
			"notification" => [
				"title" => $this->input->get('title'),
				"body" =>  $this->input->get('text'),
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
		echo json_encode($response);
	}

	function tes()
	{

		header('Content-Type: application/json');
		$data = array(
			'ip' => $data_push['ip'],
			'perangkat' => $data_push['comment'],
			'body' => $data_push['body'],
			'status' => $data_push['status'],
			'datetime' => date('Y-m-d h:i:s'),
		);
		echo json_encode($data);
	}

	// Insert to firebase
	public function save_status_monitoring($data_push = array())
	{

		$data = array(
			'ip' => $data_push['ip'],
			'perangkat' => $data_push['comment'],
			'body' => $data_push['body'],
			'status' => $data_push['status'],
			'datetime' => date('Y-m-d h:i:s'),
		);

		$fb = Firebase::initialize($this->config->item('firebase_database'), $this->config->item('firebase_api'));
		$a = $fb->push('/monitoring/' . $data_push['status'], $data);
		return json_encode($a);
	}

	public function get_data($status)
	{
		error_reporting(0);
		// header('Content-Type: application/json');
		$fb = Firebase::initialize($this->config->item('firebase_database'), $this->config->item('firebase_api'));
		$data = array();
		$fetch = $fb->get('/monitoring/' . $status);
		foreach ($fetch as $v) {
			$data[] = array(
				'ip' => $v['ip'],
				'perangkat' => $v['perangkat'],
				'status' => $v['status'],
				'body' => $v['body'],
				'datetime' => $v['datetime'],
			);
		}
		return $data;
	}

	function count_data($status)
	{
		header('Content-Type: application/json');
		$arr = array();
		$total = 0;
		foreach ($this->get_data($status) as $key => $item) {
			$arr[] = $item;
		}
		ksort($arr, SORT_NUMERIC);
		echo json_encode(count($arr));
	}
}
