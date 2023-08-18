<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\Firebase;
use \RouterOS\Client;
use \RouterOS\Query;
use RouterOS\Config;

class Router extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	function connect()
	{
		$config =
			(new Config())
			->set('host', $this->config->item('mikrotik_ip'))
			->set('port', $this->config->item('mikrotik_port'))
			->set('pass', $this->config->item('mikrotik_pass'))
			->set('user', $this->config->item('mikrotik_user'));
		return  new Client($config);
	}


	public function index()
	{
		if ($this->input->post('interface')) {
			$this->session->set_userdata('interface', $this->input->post('interface'));
		} else {
			$this->session->set_userdata('interface', $this->config->item('mikrotik_default_interface'));

			$data = array(
				'interface' =>  $this->connect()->query('/interface/print')->read(),
				'gangguan_internet' => 0,
				'total' => count($this->interface())
			);
			$this->load->view('template_sbadmin/header', $data);
			$this->load->view('template_sbadmin/sidebar', $data);
			$this->load->view('template_sbadmin/menu', $data);
			$this->load->view('mikrotik/index', $data);
			$this->load->view('template_sbadmin/footer', $data);
		}
	}


	public function log()
	{
		$data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/log', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function monitoring()
	{
		$data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/monitoring', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}


	public function dhcp_leases()
	{
		$data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/dhcp_leases', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function bandwidth()
	{
		$connect = $this->connect;
		$data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/bandwidth', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}



	public function hotspot_profile()
	{
		$data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/hotspot_profile', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_profile_add()
	{

		$data['form_action'] = site_url('router/hotspot_profile_process');
		$data['default']['idle-timeout'] = 'none';
		$data['default']['keepalive-timeout'] = '00:02:00';
		$data['default']['rate-limit'] = '5M/5M';
		$data['default']['shared-users'] = 5;
		$data['jenis'] = 'tambah';
		$this->session->unset_userdata('id');
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/profile_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_profile_update($id = "")
	{

		$data['form_action'] = site_url('router/hotspot_profile_process');
		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/profile/print'))->where('.id', $id);
			$hotspot_user = $this->connect()->query($query)->read();

			foreach ($hotspot_user as $row) {


				if (isset($row['name'])) {
					$name = $row['name'];
				} else {
					$name = '';
				}

				if (isset($row['idle-timeout'])) {
					$idle_timeout = $row['idle-timeout'];
				} else {
					$idle_timeout = '';
				}


				if (isset($row['keepalive-timeout'])) {
					$keepalive_timeout = $row['keepalive-timeout'];
				} else {
					$keepalive_timeout = '';
				}


				if (isset($row['shared-users'])) {
					$shared_users = $row['shared-users'];
				} else {
					$shared_users = '';
				}


				if (isset($row['rate-limit'])) {
					$rate_limit = $row['rate-limit'];
				} else {
					$rate_limit = '';
				}
			}
			$this->session->set_userdata('id', $id);
			$data['default']['name'] = $name;
			$data['default']['idle-timeout'] = $idle_timeout;
			$data['default']['keepalive-timeout'] = $keepalive_timeout;
			$data['default']['rate-limit'] = $rate_limit;
			$data['default']['shared-users'] = $shared_users;
			$data['jenis'] = 'update';
		}
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/profile_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_profile_process()
	{
		$data['form_action'] = site_url('router/hotspot_profile_process');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('idle-timeout', 'Iddle Timeout', 'required');
		$this->form_validation->set_rules('keepalive-timeout', 'Keep Alive Timeout', 'required');
		$this->form_validation->set_rules('rate-limit', 'rate limit', 'required');
		$this->form_validation->set_rules('shared-users', 'Shared Users', 'required');

		if ($this->form_validation->run() == TRUE) {
			$name = $this->input->post('name');
			$idle_timeout = $this->input->post('idle-timeout');
			$keepalive_timeout = $this->input->post('keepalive-timeout');
			$rate_limit = $this->input->post('rate-limit');
			$shared_users = $this->input->post('shared-users');

			if ($this->connect()) {
				if ($this->input->post('jenis') == 'update') {
					$run = $query = (new Query('/ip/hotspot/user/profile/set'))
						->equal('.id', $this->session->userdata('id'));
				} else {
					$run = $query = (new Query('/ip/hotspot/user/profile/add'));
				}

				$run->equal('name', $name)
					->equal('idle-timeout', $idle_timeout)
					->equal('keepalive-timeout', $keepalive_timeout)
					->equal('rate-limit', $rate_limit)
					->equal('shared-users', $shared_users);
				$this->connect()->query($query)->read();
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message', 'Data user hotspot tersebut berhasil diubah!');
				redirect('hotspot_profile');
			}
		} else {
			$data['default']['name'] = $this->input->post('name');
			$data['default']['idle-timeout'] = $this->input->post('idle-timeout');
			$data['default']['keepalive-timeout'] = $this->input->post('keepalive-timeout');
			$data['default']['rate-limit'] = $this->input->post('rate-limit');
			$data['default']['shared-users'] = $this->input->post('shared-users');
		}
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/profile_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}




	public function hotspot_user()
	{
		$data['hotspot_users'] = array();
		$query = (new Query('/ip/hotspot/user/getall'));
		$log = $this->connect()->query($query)->read();
		$data['hotspot_users'] = $log;

		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}


	public function dt_users()
	{


		$query = (new Query('/ip/hotspot/user/print'));
		$hotspot_users = $this->connect()->query($query)->read();

		$no = 0;
		foreach ($hotspot_users as $user) {
			$btn_update = $user['disabled'] == 'true' ? '<a class="btn btn-sm btn-success" href="' . base_url('router/hotspot_user_enable/' . $user['.id']) . '">Enable</a>' : '<a class="btn btn-sm btn-warning" href="' . base_url('router/hotspot_user_disable/' . $user['.id']) . '"> Disable</a>';


			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='" . base_url('router/hotspot_user_edit/' . $user['.id']) . "'>Update</a>
			$btn_update 
			<a class='btn btn-sm btn-danger' href='" . base_url('router/hotspot_user_delete/' . $user['.id']) . "'>Delete</a>
			</div>";


			$data_internet[] = array(
				'no' => $no + 1,
				'server' => @$user['server'],
				'name' => @$user['name'],
				'password' => @$user['password'],
				'mac-address'	=> @$user['mac-address'],
				'profile' => @$user['profile'],
				'comment' => @$user['comment'],
				'opsi' => $btn
			);
			$no++;
		}
		$data['recordsTotal'] = count($data_internet);
		$data['recordsFiltered'] = count($data_internet);

		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_internet);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_internet = array_slice($data_internet, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_internet = $this->searchData($_GET['search']['value'], $data_internet);
		}
		$data['data'] =  $data_internet;
		echo json_encode($data);
	}

	public function interface()
	{
		$interface = $this->connect()->query('/interface/print')->read();
		$no = 0;
		foreach ($interface as $v) {
			$eth = (new Query('/interface/monitor-traffic'))
				->equal('interface', $v['name'])
				->equal('once');
			$network = $this->connect()->query($eth)->read();
			$data_internet[] = array(
				'no' => $no + 1,
				'name' => $v['name'],
				'rx' => formatBytes($network[0]['rx-bits-per-second']),
				'tx' => formatBytes($network[0]['tx-bits-per-second']),

			);
			$no++;
		}
		return $data_internet;
	}

	public function live_stat()
	{
		// header('Content-Type: application/json');  
		$query = (new Query('/interface/print'));
		$interface = $this->connect()->query($query)->read();
		$no = 0;
		foreach ($interface as $v) {
			$eth = (new Query('/interface/monitor-traffic'))
				->equal('interface', $v['name'])
				->equal('once');
			$network = $this->connect()->query($eth)->read();
			if ($network[0]['rx-bits-per-second'] <= 0 &&  $network[0]['tx-bits-per-second'] <= 0) {
				$name = '<span class="text-danger">' . $v['name'] . '</span>';
			} elseif ($network[0]['rx-bits-per-second'] <= 0 || $network[0]['tx-bits-per-second'] <= 0) {
				$name = '<span class="text-warning">' . $v['name'] . '</span>';
			} else {
				$name = '<span class="text-success">' . $v['name'] . '</span>';
			}
			$warna =
				$data_internet[] = array(
					'no' => $no + 1,
					'name' => $name,
					'rx' => formatBytes($network[0]['rx-bits-per-second']),
					'tx' => formatBytes($network[0]['tx-bits-per-second']),

				);
			$no++;
		}
		$data['recordsTotal'] = count($data_internet);
		$data['recordsFiltered'] = count($data_internet);

		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_internet);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_internet = array_slice($data_internet, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_internet = $this->searchData($_GET['search']['value'], $data_internet);
		}
		$data['data'] =  $data_internet;
		echo json_encode($data);
	}

	public function dt_log()
	{
		$query = (new Query('/log/print'));
		$log = $this->connect()->query($query)->read();
		$no = 0;
		foreach ($log as $v) {
			$data_log[] = array(
				'id' => $no,
				'time' => $v['time'],
				'topics' => $v['topics'],
				'message' => $v['message'],

			);
			$no++;
		}
		array_multisort($data_log, SORT_DESC, $log);
		$data['recordsTotal'] = count($data_log);
		$data['recordsFiltered'] = count($data_log);
		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_log);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_log = array_slice($data_log, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_log = $this->searchData($_GET['search']['value'], $data_log);
		}
		$data['data'] =  $data_log;
		echo json_encode($data);
	}


	public function dt_profile()
	{
		header('Content-Type: application/json');
		$query = (new Query('/ip/hotspot/user/profile/print'));
		$log = $this->connect()->query($query)->read();
		$no = 1;
		foreach ($log as $v) {

			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='" . base_url('router/hotspot_profile_update/' . $v['.id']) . "'>Update</a> 
			<a class='btn btn-sm btn-danger' href='" . base_url('router/hotspot_profile_delete/' . $v['.id']) . "'>Delete</a>
			</div>";
			$data_log[] = array(
				'id' => $no,
				'name' => @$v['name'],
				'idle-timeout' => @$v['idle-timeout'],
				'keepalive-timeout' => @$v['keepalive-timeout'],
				'shared-users' => @$v['shared-users'],
				'rate-limit' => @$v['rate-limit'],
				// 'smtp-server' => @$v['smtp-server'], 
				// 'login-by' => @$v['login-by'], 
				// 'http-cookie-lifetime' => @$v['http-cookie-lifetime'], 
				// 'split-user-domain' => @$v['split-user-domain'], 
				// 'use-radius' => @$v['use-radius'], 
				// 'default' => @$v['default'], 
				'button' => $btn

			);
			$no++;
		}
		array_multisort($data_log, SORT_DESC, $log);
		$data['recordsTotal'] = count($data_log);
		$data['recordsFiltered'] = count($data_log);
		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_log);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_log = array_slice($data_log, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_log = $this->searchData($_GET['search']['value'], $data_log);
		}
		$data['data'] =  $data_log;
		echo json_encode($data);
	}
	public function dt_server()
	{
		header('Content-Type: application/json');
		$query = (new Query('/ip/hotspot/user/profile/getall'));
		$log = $this->connect()->query($query)->read();
		$no = 1;
		foreach ($log as $v) {
			$btn_update = @$v['default'] == 'false' ? '<a class="btn btn-sm btn-sucess" href="' . base_url('router/hotspot_server_enable/' . $v['.id']) . '">Enable</a>' :  '<a class="btn btn-sm btn-warning" href="' . base_url('router/hotspot_server_disable/' . $v['.id']) . '">Disable</a>';

			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='" . base_url('router/hotspot_server_update/' . $v['.id']) . "'>Update</a>
			$btn_update
			<a class='btn btn-sm btn-danger' href='" . base_url('router/hotspot_server_delete/' . $v['.id']) . "'>Delete</a>
			</div>";
			$data_log[] = array(
				'id' => $no,
				'name' => @$v['name'],
				// 'hotspot-address' => @$v['hotspot-address'], 
				'dns-name' => @$v['dns-name'],
				'html-directory' => @$v['html-directory'],
				// 'html-directory-override' => @$v['html-directory-override'], 
				'rate-limit' => @$v['rate-limit'],
				// 'http-proxy' => @$v['http-proxy'], 
				// 'smtp-server' => @$v['smtp-server'], 
				// 'login-by' => @$v['login-by'], 
				// 'http-cookie-lifetime' => @$v['http-cookie-lifetime'], 
				// 'split-user-domain' => @$v['split-user-domain'], 
				// 'use-radius' => @$v['use-radius'], 
				// 'default' => @$v['default'], 
				'button' => $btn

			);
			$no++;
		}
		array_multisort($data_log, SORT_DESC, $log);
		$data['recordsTotal'] = count($data_log);
		$data['recordsFiltered'] = count($data_log);
		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_log);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_log = array_slice($data_log, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_log = $this->searchData($_GET['search']['value'], $data_log);
		}
		$data['data'] =  $data_log;
		echo json_encode($data);
	}



	public function json_traffic()
	{

		$interface = $this->session->userdata('interface');
		$eth = (new Query('/interface/monitor-traffic'))
			->equal('interface', $interface)
			->equal('once');
		$network = $this->connect()->query($eth)->read();

		$rows =
			[

				array(
					'name' => 'Tx',
					'data' => $network[0]['tx-bits-per-second'],
					'interface' => $interface
				),
				array(
					'name' => 'Rx',
					'data' => $network[0]['rx-bits-per-second'],
					'interface' => $interface
				)
			];

		echo json_encode($rows);
	}
	public function json_dhcp()
	{
		$eth = (new Query('/ip/dhcp-server/lease/print'));
		$data = $this->connect()->query($eth)->read();
		echo json_encode($data);
	}

	public function json_device_offline()
	{
		$device_on = array();
		$eth = (new Query('/ip/dhcp-server/lease/print'));
		$data = $this->connect()->query($eth)->read();

		foreach ($data  as $v) {
			if (empty($v['host-name'])) {
				$device_on[] = array($v['mac-address']);
			}
		}
		// $this->routerapi->disconnect();
		echo json_encode(count($device_on));
	}



	public function dt_dhcp()
	{
		$query = (new Query('/ip/dhcp-server/lease/print'));
		$log = $this->connect()->query($query)->read();

		$no = 0;
		// var_dump($log);
		foreach ($log as $v) {
			$data_log[] = array(
				'no' => $no + 1,
				'address' => $v['address'],
				'mac-address' => $v['mac-address'],
				// 'server' => $v['server'],
				'last-seen' => $v['last-seen'],
				'host-name' => @$v['host-name'],
				'status' => $v['status'],
				'dynamic' => $v['dynamic'],
				'opsi' => '<a class="btn btn-sm btn-primary add-monitoring" data-ip="' . $v['address'] . '"><i class="fa fa-plus-circle"></i> monitoring</a>'

			);
			$no++;
		}
		array_multisort($data_log, SORT_ASC, $log);
		$data['recordsTotal'] = count($data_log);
		$data['recordsFiltered'] = count($data_log);
		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_log);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_log = array_slice($data_log, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_log = $this->searchData($_GET['search']['value'], $data_log);
		}
		$data['data'] =  $data_log;
		echo json_encode($data);
	}




	function searchData($id, $array)
	{

		foreach ($array as $key => $val) {
			if ($val['name'] === $id) {
				return array(
					array(
						'no' => 1,
						'name' => $val['name'],
						'rx' => $val['rx'],
						'tx' => $val['tx']
					)
				);
			}
		}
		return null;
	}



	// Insert to firebase
	public function save_stat()
	{
		$connect = $this->connect;
		$fetch = $this->routerapi->comm('/interface/monitor-traffic', array(
			'interface' => 'INTERNET',
			'once' => ''
		));
		$data = array(
			'interface' => "INTERNET",
			'datetime' => date('Y-m-d h:i:s'),
			'rx' => $fetch[0]["rx-bits-per-second"],
			'tx' =>  $fetch[0]["tx-bits-per-second"]
		);

		$fb = Firebase::initialize($this->config->item('firebase_database'), $this->config->item('firebase_api'));
		$a = $fb->push('/data', $data);
		echo json_encode($a);
	}
	public function get_data()
	{
		$fb = Firebase::initialize($this->config->item('firebase_database'), $this->config->item('firebase_api'));
		$a = $fb->get('/data');
		echo json_encode($a);
	}
	//  ==================================================


	public function hotspot_user_add()
	{
		$data['form_action'] = site_url('router/process_update');
		$data['default']['mac_address'] = '00:00:00:00:00:00';
		$data['default']['disabled'] = 'no';
		$data['jenis'] = 'tambah';
		$profile_list = (new Query('/ip/hotspot/user/profile/print'));
		$data['profile'] = $this->connect()->query($profile_list)->read();

		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_user_edit($id)
	{
		$data['form_action'] = site_url('router/process_update');

		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/print'))->where('.id', $id);
			$hotspot_user = $this->connect()->query($query)->read();
			foreach ($hotspot_user as $row) {
				if (isset($row['server'])) {
					$server = $row['server'];
				} else {
					$server = '';
				}

				$name = $row['name'];
				$password = @$row['password'];

				if (isset($row['mac-address'])) {
					$mac_address = $row['mac-address'];
				} else {
					$mac_address = '';
				}

				$profile = @$row['profile'];

				if (isset($row['comment'])) {
					$comment = $row['comment'];
				} else {
					$comment = '';
				}
				$disabled = $row['disabled'];

				if ($disabled == 'true') {
					$disabled = 'yes';
				} else {
					$disabled = 'no';
				}
			}
			$this->session->set_userdata('id', $id);
			$data['default']['server'] = $server;
			$data['default']['name'] = $name;
			$data['default']['password'] = $password;
			$data['default']['mac_address'] = $mac_address;
			$data['default']['profile'] = $profile;
			$data['default']['comment'] = $comment;
			$data['default']['disabled'] = $disabled;
			$data['jenis'] = 'update';

			$profile_list = (new Query('/ip/hotspot/user/profile/print'));
			$data['profile'] = $this->connect()->query($profile_list)->read();
		}
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function process_update()
	{
		$data['form_action'] = site_url('router/process_update');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('profile', 'Profile', 'required');
		$this->form_validation->set_rules('disabled', 'Disabled', 'required');

		if ($this->form_validation->run() == TRUE) {
			$server = $this->input->post('server');
			$name = $this->input->post('name');
			$password = $this->input->post('password');
			if (empty($password)) {
				$password = '';
			}
			$mac_address = $this->input->post('mac_address');
			if (empty($mac_address)) {
				$mac_address = '00:00:00:00:00:00';
			}
			$profile = $this->input->post('profile');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');

			if ($this->connect()) {
				if ($this->input->post('jenis') == 'update') {
					$run = $query = (new Query('/ip/hotspot/user/set'))
						->equal('.id', $this->session->userdata('id'));
				} else {
					$run = $query = (new Query('/ip/hotspot/user/add'));
				}

				$run->equal('name', $name)
					->equal('server', $server)
					->equal('password', $password)
					->equal('mac-address', $mac_address)
					->equal('profile', $profile)
					->equal('comment', $comment)
					->equal('disabled', $disabled);
				$this->connect()->query($query)->read();
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message', 'Data user hotspot tersebut berhasil diubah!');
				redirect('hotspot_user');
			}
		} else {
			$data['default']['server'] = $this->input->post('server');
			$data['default']['name'] = $this->input->post('name');
			$data['default']['password'] = $this->input->post('password');
			$data['default']['mac_address'] = $this->input->post('mac_address');
			$data['default']['profile'] = $this->input->post('profile');
			$data['default']['comment'] = $this->input->post('comment');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_user_delete($id)
	{
		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/remove'))->equal('.id', $id);
			$hotspot_user = $this->connect()->query($query)->read();
			$this->session->set_flashdata('message', 'Data user tersebut berhasil dihapus!');
			redirect('hotspot_user');
		}
	}

	public function hotspot_user_disable($id)
	{
		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/set'))
				->equal('.id', $id)
				->equal('disabled', 'true');
			$this->connect()->query($query)->read();
			$this->session->set_flashdata('message', 'Data user tersebut berhasil dinonaktifkan!');
			redirect('hotspot_user');
		}
	}

	public function hotspot_user_enable($id)
	{
		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/set'))
				->equal('.id', $id)
				->equal('disabled', 'false');
			$this->connect()->query($query)->read();
			$this->session->set_flashdata('message', 'Data user tersebut berhasil diaktifkan!');
			redirect('hotspot_user');
		}
	}

	public function hotspot_profile_remove($id)
	{

		if ($this->connect()) {
			$query = (new Query('/ip/hotspot/user/profile/remove'))->equal('.id', $id);
			$hotspot_user = $this->connect()->query($query)->read();
			$this->session->set_flashdata('message', 'Data profil tersebut berhasil dihapus!');
			redirect('hotspot_profile');
		}
	}




	function send_notif()
	{
		$this->connect();
		$interface = $this->routerapi->comm('/interface/print');

		$no = 0;
		foreach ($interface as $v) {
			$network = $this->routerapi->comm('/interface/monitor-traffic', array(
				'interface' => $v['name'],
				'once' => ''
			));
			if ($network[0]['rx-bits-per-second'] <= 0 &&  $network[0]['tx-bits-per-second'] <= 0) {
				$name = '<span class="text-danger">' . $v['name'] . '</span>';
			} elseif ($network[0]['rx-bits-per-second'] <= 0 || $network[0]['tx-bits-per-second'] <= 0) {
				$name = '<span class="text-warning">' . $v['name'] . '</span>';
			} else {
				$name = '<span class="text-success">' . $v['name'] . '</span>';
			}
			$warna =
				$data_internet[] = array(
					'no' => $no + 1,
					'name' => $name,
					'rx' => formatBytes($network[0]['rx-bits-per-second']),
					'tx' => formatBytes($network[0]['tx-bits-per-second']),

				);
			$no++;
		}
	}

	public function netwatch()
	{

		if ($this->input->post('id')) {
			header('Content-Type: application/json');
			$id  = $this->input->post('id');
			$query = (new Query('/tool/netwatch/print'))->where('.id', $id);
			$fetch = $this->connect()->query($query)->read();
			echo json_encode($fetch);
		} else {
			$data = array();
			$this->load->view('template_sbadmin/header', $data);
			$this->load->view('template_sbadmin/sidebar', $data);
			$this->load->view('template_sbadmin/menu', $data);
			$this->load->view('mikrotik/netwatch', $data);
			$this->load->view('template_sbadmin/footer', $data);
		}
	}

	function netwatch_save()
	{
		header('Content-Type: application/json');
		$this->form_validation->set_rules('comment', 'Comment', 'required');
		$this->form_validation->set_rules('host', 'Host', 'required');
		$this->form_validation->set_rules('interval', 'interval', 'required');
		$this->form_validation->set_rules('timeout', 'timeout', 'required');
		$response = false;
		if ($this->form_validation->run() == TRUE) {
			if ($this->connect()) {
				$host 			= $this->input->post('host');
				$timeout 		= $this->input->post('timeout') ? $this->input->post('timeout') : '00:00:10';
				$interval 		= $this->input->post('interval') ? $this->input->post('interval') : '00:00:10';
				$comment 		= $this->input->post('comment');

				$up_script 		= '/tool fetch "http://' . $this->config->item('ip_aplikasi') . '/' . $this->config->item('folder_aplikasi') . '/send?title=UP_' . $host . '&text=PERANGKAT_' . $host . '_UP"';
				$down_script 	= '/tool fetch "http://' . $this->config->item('ip_aplikasi') . '/' . $this->config->item('folder_aplikasi') . '/send?title=DOWN_' . $host . '&text=PERANGKAT_' . $host . '_DOWN"';

				$query = (new Query('/tool/netwatch/add'));
				$query->equal('host', $host)
					->equal('timeout', $timeout)
					->equal('interval', $interval)
					->equal('comment', $comment)
					->equal('up-script', $up_script)
					->equal('down-script', $down_script);
				$response = $this->connect()->query($query)->read();
			}
		} else {
			$response = false;
		}
		echo json_encode($response);
	}

	function netwatch_change()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$query = (new Query('/tool/netwatch/set'));
		$query->equal('.id', $id)
			->equal('disabled', $status);
		$response = $this->connect()->query($query)->read();
		echo json_encode($response);
	}

	function netwatch_remove()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$query = (new Query('/tool/netwatch/remove'));
		$query->equal('.id', $id)
			->equal('disabled', $status);
		$response = $this->connect()->query($query)->read();
		echo json_encode($response);
	}

	public function dt_netwatch()
	{
		$query = (new Query('/tool/netwatch/print'));
		$log = $this->connect()->query($query)->read();
		$no = 0;
		foreach ($log as $v) {

			$btn = $v['disabled'] == "true" ? ["btn-success change-status", 'Enable', 'false'] : ["btn-warning change-status", 'Disable', 'true'];
			$data_log[] = array(
				'no' => $no + 1,
				'host' => '<a class="edit" style="cursor:pointer" data-id="' . $v['.id'] . '"><i class="fa fa-edit"></i> ' . $v['host'] . '</a>',
				'interval' => $v['interval'],
				'timeout' => $v['timeout'],
				'status' => $v['status'],
				'since' => @$v['since'],
				'opsi' => '<div class="btn-group"><a class="btn btn-sm ' . $btn[0] . '" data-id="' . $v['.id'] . '" data-status="' . $btn[2] . '"> ' . $btn[1] . '</a><a class="btn btn-sm btn-danger delete"> Hapus</a></div>'

			);
			$no++;
		}
		array_multisort($data_log, SORT_ASC, $log);
		$data['recordsTotal'] = count($data_log);
		$data['recordsFiltered'] = count($data_log);

		$page = !empty($_GET['start']) ? (int) $_GET['start'] : 1;
		$total = count($data_log);
		$limit = $_GET['length'];
		$totalPages = ceil($total / $limit);
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if ($offset < 0) $offset = 0;
		$data_log = array_slice($data_log, $offset, $limit);
		if ($_GET['search']['value']) {
			$data_log = $this->searchData($_GET['search']['value'], $data_log);
		}
		$data['data'] =  $data_log;
		echo json_encode($data);
	}
}
