<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Setting extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->config('fcm');
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	public function read_token()
	{
		$filename = 'token_push.txt';
		$f = fopen($filename, 'r');

		if ($f) {
			$contents = fread($f, filesize($filename));
			fclose($f);
			echo nl2br($contents);
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
		if ($this->input->post()) {
			$file = FCPATH . '/application/config/fcm.php';
			$content = file_get_contents($file);
			$newcontent = "<?php
defined('BASEPATH') or exit('No direct script access allowed'); \n\n";

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
}
