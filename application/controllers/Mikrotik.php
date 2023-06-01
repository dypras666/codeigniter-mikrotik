<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\Firebase;
class Mikrotik extends CI_Controller {	
	private $connect;	
	function __construct(){
		parent::__construct();		
        $this->load->config('fcm'); 				
		$this->connect = $this->routerapi->connect($this->config->item('mikrotik_ip'),$this->config->item('mikrotik_user'),$this->config->item('mikrotik_pass'));
   
		  
	}
			
	public function index()
	{		  
		$data = array(
				'interface' =>  $this->routerapi->comm('/interface/print'),
				'total' => count($this->interface()),
				'useronline' => count($this->routerapi->comm("/ip/hotspot/active/print")
			));
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/index', $data);
		$this->load->view('template_sbadmin/footer', $data);
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
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('mikrotik/bandwidth', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}
			
	public function user()
	{		
        $connect = $this->connect;		
        $data['hotspot_users'] = array();	
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/getall');
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();		  
            $data['hotspot_users'] = $hotspot_users;
		} 	 
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function dt_users()
	{
		$connect = $this->connect;	   
        $this->routerapi->write('/ip/hotspot/user/getall');
		$hotspot_users = $this->routerapi->read();
		$this->routerapi->disconnect();		   
 
        $no=0;  
		foreach($hotspot_users as $user){  
            $data_internet[] = array(
                    '0' => $no+1,
                    '1' => @$user['server'],
                    '2' => @$user['name'],
                    '3' => @$user['password'],
					'4'	=> @$user['mac-address'],
					'5' => @$user['profile'],
					'6' => @$user['comment'],
					'7' => $GET['start'],
					'8' => $GET['length'],
            );
            $no++;
        }
        $data['recordsTotal'] = count($data_internet);
        $data['recordsFiltered'] = count($data_internet);
        $data['data'] =  $data_internet;
        echo json_encode($data);
	}

	public function interface()
	{
		$connect = $this->connect;	   
        $interface = $this->routerapi->comm('/interface/print');
		$no=0;  
		foreach($interface as $v){
            $network = $this->routerapi->comm('/interface/monitor-traffic',array(
                'interface' => $v['name'],
                'once' =>''
            ));
            $data_internet[] = array(
                    'no' => $no+1,
                    'name' => $v['name'],
                    'rx' => formatBytes($network[0]['rx-bits-per-second']),
                    'tx' => formatBytes($network[0]['tx-bits-per-second']) ,
					 
            );
            $no++;
        }
		return $data_internet;
	}
	
    public function live_stat()
    {
        // header('Content-Type: application/json');
        $connect = $this->connect;	   
        $interface = $this->routerapi->comm('/interface/print');
       
        $no=0;  
		foreach($interface as $v){
            $network = $this->routerapi->comm('/interface/monitor-traffic',array(
                'interface' => $v['name'],
                'once' =>''
            ));
            $data_internet[] = array(
                    'no' => $no+1,
                    'name' => $v['name'],
                    'rx' => formatBytes($network[0]['rx-bits-per-second']),
                    'tx' => formatBytes($network[0]['tx-bits-per-second']) ,
					 
            );
            $no++;
        }
        $data['recordsTotal'] = count($data_internet);
        $data['recordsFiltered'] = count($data_internet);

		$page = ! empty( $_GET['start'] ) ? (int) $_GET['start'] : 1;
		$total = count($data_internet);  
		$limit = $_GET['length']; 
		$totalPages = ceil( $total/ $limit );  
		$page = max($page, 1);  
		$page = min($page, $totalPages);  
		$offset = ($page - 1) * $limit;
		if( $offset < 0 ) $offset = 0;
		$data_internet = array_slice( $data_internet, $offset, $limit );
		if($_GET['search']['value']){
			$data_internet= $this->searchData($_GET['search']['value'] ,$data_internet);
			 
		} 
        $data['data'] =  $data_internet;
        echo json_encode($data);
    }

	public function dt_log()
	{
		$connect = $this->connect;	   
		$log = $this->routerapi->comm("/log/print");  
        $no=0;  
		foreach($log as $v){            
            $data_log[] = array(
                    'id' => $v['.id'],
                    'time' => $v['time'], 
                    'topics' => $v['topics'], 
                    'message' => $v['message'], 
					 
            );
            $no++;
        }
		array_multisort($data_log, SORT_DESC, $log);
        $data['recordsTotal'] = count($data_log);
        $data['recordsFiltered'] = count($data_log);

		$page = ! empty( $_GET['start'] ) ? (int) $_GET['start'] : 1;
		$total = count($data_log);  
		$limit = $_GET['length']; 
		$totalPages = ceil( $total/ $limit );  
		$page = max($page, 1);  
		$page = min($page, $totalPages);  
		$offset = ($page - 1) * $limit;
		if( $offset < 0 ) $offset = 0;
		$data_log = array_slice( $data_log, $offset, $limit );
		if($_GET['search']['value']){
			$data_log= $this->searchData($_GET['search']['value'] ,$data_log);
			 
		} 
        $data['data'] =  $data_log;
        echo json_encode($data);
		 
	}

	
	public function json_traffic()
	{ 
		$network = $this->routerapi->comm('/interface/monitor-traffic',array(
			'interface' => 'INTERNET',
			'once' =>''
		));
		  
		$rows = 
		[
			
			array(
				'name' => 'Tx',
				'data' => $network[0]['tx-bits-per-second']
			),
			array(
				'name' => 'Rx',
				'data' => $network[0]['rx-bits-per-second']
			)
		];

		echo json_encode($rows);
	}
	 public function json_dhcp()
	{ 
		$network = $this->routerapi->comm('/ip/dhcp-server/lease/print');
		echo json_encode($network);
	}

	public function dt_dhcp()
	{
		$connect = $this->connect;	   
		$log = $this->routerapi->comm("/ip/dhcp-server/lease/print");  
        $no=0;  
		// var_dump($log);
		foreach($log as $v){            
            $data_log[] = array(
					'no' => $no,
                    'address' => $v['address'],
                    'mac-address' => $v['mac-address'], 
                    'server' => $v['server'], 
                    'last-seen' => $v['last-seen'], 
                    'host-name' => @$v['host-name'], 
                    'status' => $v['status'], 
                    'dynamic' => $v['dynamic'], 
					 
            );
            $no++;
        }
		array_multisort($data_log, SORT_DESC, $log);
        $data['recordsTotal'] = count($data_log);
        $data['recordsFiltered'] = count($data_log);

		$page = ! empty( $_GET['start'] ) ? (int) $_GET['start'] : 1;
		$total = count($data_log);  
		$limit = $_GET['length']; 
		$totalPages = ceil( $total/ $limit );  
		$page = max($page, 1);  
		$page = min($page, $totalPages);  
		$offset = ($page - 1) * $limit;
		if( $offset < 0 ) $offset = 0;
		$data_log = array_slice( $data_log, $offset, $limit );
		if($_GET['search']['value']){
			$data_log= $this->searchData($_GET['search']['value'] ,$data_log);
			 
		} 
        $data['data'] =  $data_log;
        echo json_encode($data);
		 
	}
	 
	function searchData($id, $array) {
	 
		foreach ($array as $key => $val) {
			//  var_dump($id);
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
        $fetch = $this->routerapi->comm('/interface/monitor-traffic',array(
            'interface' => 'INTERNET',
            'once' =>''
        ));        
        $data = array(
            'interface' => "INTERNET",
            'datetime' => date('Y-m-d h:i:s'),
            'rx' => $fetch[0]["rx-bits-per-second"] ,
            'tx' =>  $fetch[0]["tx-bits-per-second"]
        );        

        $fb = Firebase::initialize($this->config->item('firebase_database'), $this->config->item('firebase_api')); 
	    $a = $fb->push('/data', $data);
		echo json_encode($a);
    }
	public function get_data()
	{
		$fb = Firebase::initialize($this->config->item('firebase_database'),$this->config->item('firebase_api'));
	    $a = $fb->get('/data');
		echo json_encode($a);
		
	}
	//  ==================================================

	
	public function add(){
		$data['container'] = 'hotspot/hotspot_form';
		$data['form_action'] = site_url('hotspot/add');				
				
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('profile', 'Profile', 'required');		
		$this->form_validation->set_rules('disabled', 'Disabled', 'required');	
				
		if ($this->form_validation->run() == TRUE)
		{
			$server = $this->input->post('server');			
			$name = $this->input->post('name');
			$password = $this->input->post('password');
			$mac_address = $this->input->post('mac_address');
			$profile = $this->input->post('profile');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerapi->write('/ip/hotspot/user/add',false);				
				$this->routerapi->write('=server='.$server, false);							
				$this->routerapi->write('=name='.$name, false);
				if (!empty($password)){
					$this->routerapi->write('=password='.$password, false);     				
				}
				if (!empty($mac_address)){
					$this->routerapi->write('=mac-address='.$mac_address, false);	
				}				
				$this->routerapi->write('=profile='.$profile, false);
				if (!empty($comment)){
					$this->routerapi->write('=comment='.$comment, false);	
				}		
				$this->routerapi->write('=disabled='.$disabled);				
				$hotspot_users = $this->routerapi->read();
				$this->routerapi->disconnect();	
				$this->session->set_flashdata('message','Data user hotspot tersebut berhasil ditambahkan!');
				redirect('hotspot');
			}
		}else{
			$data['default']['server'] = $this->input->post('server');
			$data['default']['name'] = $this->input->post('name');
			$data['default']['password'] = $this->input->post('password');
			$data['default']['mac_address'] = $this->input->post('mac_address');
			$data['default']['profile'] = $this->input->post('profile');
			$data['default']['comment'] = $this->input->post('comment');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template', $data);				
	}
	
	public function update($id){
		$data['container'] = 'hotspot/hotspot_form';
		$data['form_action'] = site_url('hotspot/process_update');		
		
		if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerapi->write("/ip/hotspot/user/print", false);			
			$this->routerapi->write("=.proplist=.id", false);
			$this->routerapi->write("=.proplist=server", false);
			$this->routerapi->write("=.proplist=name", false);
			$this->routerapi->write("=.proplist=password", false);		
			$this->routerapi->write("=.proplist=mac-address", false);
			$this->routerapi->write("=.proplist=profile", false);
			$this->routerapi->write("=.proplist=comment", false);		
			$this->routerapi->write("=.proplist=disabled", false);		
			$this->routerapi->write("?.id=$id");
					
			$hotspot_user = $this->routerapi->read();

			foreach ($hotspot_user as $row)
			{
				if (isset($row['server'])){
					$server = $row['server'];
				}else{
					$server = '';
				}
				
				$name = $row['name'];			
				$password = $row['password'];
				
				if (isset($row['mac-address'])){
					$mac_address = $row['mac-address'];			
				}else{
					$mac_address = '';
				}
				
				$profile = $row['profile'];
				
				if (isset($row['server'])){
					$comment = $row['comment'];
				}else{
					$comment = '';
				}
				$disabled = $row['disabled'];

				if ($disabled == 'true')
				{
					$disabled='yes';
				}else{
					$disabled='no';
				}
			}
			$this->routerapi->disconnect();
			
			$this->session->set_userdata('id',$id);
			
			$data['default']['server'] = $server;
			$data['default']['name'] = $name;			
			$data['default']['password'] = $password;
			$data['default']['mac_address'] = $mac_address;
			$data['default']['profile'] = $profile;
			$data['default']['comment'] = $comment;
			$data['default']['disabled'] = $disabled;
		}
		$this->load->view('template', $data);
	}
	
	public function process_update(){
		$data['container'] = 'hotspot/hotspot_form';
		$data['form_action'] = site_url('hotspot/process_update');	

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('profile', 'Profile', 'required');		
		$this->form_validation->set_rules('disabled', 'Disabled', 'required');	
		
		if ($this->form_validation->run() == TRUE)
		{
			$server = $this->input->post('server');			
			$name = $this->input->post('name');			
			$password = $this->input->post('password');
			if (empty($password)){
				$password = '';
			}			
			$mac_address = $this->input->post('mac_address');
			if (empty($mac_address)){
				$mac_address = '00:00:00:00:00:00';
			}
			$profile = $this->input->post('profile');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerapi->write('/ip/hotspot/user/set',false);				
				$this->routerapi->write('=.id='.$this->session->userdata('id'),false);
				$this->routerapi->write('=server='.$server,false);										
				$this->routerapi->write('=name='.$name, false);				
				$this->routerapi->write('=password='.$password, false);    				
				$this->routerapi->write('=mac-address='.$mac_address, false);								
				$this->routerapi->write('=profile='.$profile, false);				
				$this->routerapi->write('=comment='.$comment, false);						
				$this->routerapi->write('=disabled='.$disabled);				
								
				$hotspot_users = $this->routerapi->read();
				$this->routerapi->disconnect();	
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message','Data user hotspot tersebut berhasil diubah!');
				redirect('hotspot');				
			}	
		}else{
			$data['default']['server'] = $this->input->post('server');
			$data['default']['name'] = $this->input->post('name');
			$data['default']['password'] = $this->input->post('password');
			$data['default']['mac_address'] = $this->input->post('mac_address');
			$data['default']['profile'] = $this->input->post('profile');
			$data['default']['comment'] = $this->input->post('comment');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template', $data);		
	}	
	
	public function remove($id){
		if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerapi->write('/ip/hotspot/user/remove',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dihapus!');
			redirect('hotspot');
		}	
	}
	
	public function disable($id){		
		if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerapi->write('/ip/hotspot/user/disable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dinonaktifkan!');
			redirect('hotspot');
		}
	}
	
	public function enable($id){
		if ($this->routerapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerapi->write('/ip/hotspot/user/enable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil diaktifkan!');
			redirect('hotspot');
		}
	}
}