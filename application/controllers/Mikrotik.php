<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\Firebase;
class Mikrotik extends CI_Controller {	
	private $connect;	
	function __construct(){
		parent::__construct();	
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login'); 
		}	
        $this->load->config('fcm',TRUE); 				
		$this->connect = $this->routerapi->connect($this->config->item('mikrotik_ip'),$this->config->item('mikrotik_user'),$this->config->item('mikrotik_pass'));
   
		  
	}
			
	public function index()
	{		
		if($this->input->post('interface')){
			$this->session->set_userdata('interface',$this->input->post('interface'));
		}else{  
			$this->session->set_userdata('interface',$this->config->item('mikrotik_default_interface'));
			
			$data = array(
					'interface' =>  $this->routerapi->comm('/interface/print'), 
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
        $connect = $this->connect;	 
        $data = array();
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/hotspot_profile', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}
	public function hotspot_profile_update($id="")
	{		
         
        $data = array();
		$data['form_action'] = 'hotspot_profile_process';
		$connect = $this->connect;
		if ($connect){
			$this->routerapi->write("/ip/hotspot/user/profile/print", false);			
			$this->routerapi->write("=.proplist=.id", false); 
			$this->routerapi->write("=.proplist=name", false);
			$this->routerapi->write("=.proplist=idle-timeout", false);		
			$this->routerapi->write("=.proplist=keepalive-timeout", false);
			$this->routerapi->write("=.proplist=shared-users", false);
			$this->routerapi->write("=.proplist=rate-limit", false);		
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
				
				if (isset($row['idle-timeout'])){
					$idle_timeout = $row['idle-timeout'];			
				}else{
					$idle_timeout = '';
				}
				 
				
				if (isset($row['keepalive-timeout'])){
					$keepalive_timeout = $row['keepalive-timeout'];			
				}else{
					$keepalive_timeout = '';
				}
				 
				
				if (isset($row['shared-users'])){
					$shared_users = $row['shared-users'];			
				}else{
					$shared_users = '';
				}
				 
				
				if (isset($row['rate-limit'])){
					$rate_limit = $row['rate-limit'];
				}else{
					$rate_limit = '';
				}
				 
			}
			$this->routerapi->disconnect();			
			$this->session->set_userdata('id',$id);			
			$data['default']['server'] = $server;
			$data['default']['idle-timeout'] = $idle_timeout;			
			$data['default']['keepalive-timeout'] = $keepalive_timeout;
			$data['default']['rate-limit'] = $rate_limit;
			$data['default']['shared-users'] = $shared_users; 
		}
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/profile_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}

	public function hotspot_profile_process(){ 
		$data['form_action'] = site_url('mikrotik/hotspot_profile_process');	
		$connect = $this->connect;
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
			
			if ($connect){
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
				redirect('hotspot_user');				
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
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);				
	}	
	

	
				
	public function hotspot_user()
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
			$btn_update = @$user['disabled'] == 'false' ? 'class="btn btn-sm btn-sucess" href="'.base_url('mikrotik/user_enable').'"' :  'class="btn btn-sm btn-warning" href="'.base_url('mikrotik/user_disable').'"';
			
			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='".base_url('mikrotik/user_update')."'>Update</a>
			$btn_update
			<a class='btn btn-sm btn-danger' href='".base_url('mikrotik/user_delete')."'>Delete</a>
			</div>";
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
					'9' => $btn
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
			if($network[0]['rx-bits-per-second'] <= 0 &&  $network[0]['tx-bits-per-second'] <= 0){
				$name = '<span class="text-danger">'.$v['name'].'</span>';
			}elseif($network[0]['rx-bits-per-second'] <= 0 || $network[0]['tx-bits-per-second'] <= 0){
				$name = '<span class="text-warning">'.$v['name'].'</span>';
			}else{
				$name = '<span class="text-success">'.$v['name'].'</span>';
			}
			$warna = 
            $data_internet[] = array(
                    'no' => $no+1,
                    'name' => $name,
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
		$this->routerapi->disconnect();	
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

	
	public function dt_profile()
	{
		header('Content-Type: application/json');
		$connect = $this->connect;	   
		$log = $this->routerapi->comm("/ip/hotspot/user/profile/print");  
		 
        $no=1;  
		foreach($log as $v){        
			$btn_update = @$v['default'] == 'false' ? '<a class="btn btn-sm btn-sucess" href="'.base_url('mikrotik/hotspot_profile_enable/'.$v['.id']).'">Enable</a>' :  '<a class="btn btn-sm btn-warning" href="'.base_url('mikrotik/hotspot_profile_disable/'.$v['.id']).'">Disable</a>';
			
			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='".base_url('mikrotik/hotspot_profile_update/'.$v['.id'])."'>Update</a>
			$btn_update
			<a class='btn btn-sm btn-danger' href='".base_url('mikrotik/hotspot_profile_delete/'.$v['.id'])."'>Delete</a>
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
		$this->routerapi->disconnect();	
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
	public function dt_server()
	{
		header('Content-Type: application/json');
		$connect = $this->connect;	   
		$log = $this->routerapi->comm("/ip/hotspot/user/profile/getall");  
		 
        $no=1;  
		foreach($log as $v){        
			$btn_update = @$v['default'] == 'false' ? '<a class="btn btn-sm btn-sucess" href="'.base_url('mikrotik/hotspot_server_enable/'.$v['.id']).'">Enable</a>' :  '<a class="btn btn-sm btn-warning" href="'.base_url('mikrotik/hotspot_server_disable/'.$v['.id']).'">Disable</a>';
			
			$btn = "<div class='btn-group'>
			<a class='btn btn-sm btn-primary' href='".base_url('mikrotik/hotspot_server_update/'.$v['.id'])."'>Update</a>
			$btn_update
			<a class='btn btn-sm btn-danger' href='".base_url('mikrotik/hotspot_server_delete/'.$v['.id'])."'>Delete</a>
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
		$this->routerapi->disconnect();	
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
		
		$interface = $this->session->userdata('interface');
		$network = $this->routerapi->comm('/interface/monitor-traffic',array(
			'interface' => $interface,
			'once' =>''
		));
		  
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
		$this->connect;	
		$network = $this->routerapi->comm('/ip/dhcp-server/lease/print');
		$this->routerapi->disconnect();
		echo json_encode($network);	
	}

	public function json_device_offline()
	{
		$this->connect;	
		$device_on = array();
		foreach($this->routerapi->comm('/ip/dhcp-server/lease/print')  as $v){
			if(empty($v['host-name'])){
				$device_on[] = array($v['mac-address']);
			}
		} 
		// $this->routerapi->disconnect();
		echo json_encode(count($device_on));
	}

 

	public function dt_dhcp()
	{
		$connect = $this->connect;	   
		$log = $this->routerapi->comm("/ip/dhcp-server/lease/print");  
        $no=0;  
		// var_dump($log);
		foreach($log as $v){            
            $data_log[] = array(
					'no' => $no+1,
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
		array_multisort($data_log, SORT_ASC, $log);
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

	
	public function hotspot_user_add(){ 
		$data['form_action'] = site_url('mikrotik/hotspot_user_add');	 
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
			
			$connect = $this->connect;
			if ($connect){
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
				redirect('hotspot_user');
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
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);			
	}
	
	public function hotspot_user_edit($id){ 
		$data['form_action'] = site_url('mikrotik/process_update');		
		$connect = $this->connect;
		if ($connect){
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
				$password = @$row['password'];
				
				if (isset($row['mac-address'])){
					$mac_address = $row['mac-address'];			
				}else{
					$mac_address = '';
				}
				
				$profile = @$row['profile'];
				
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
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);
	}
	
	public function process_update(){ 
		$data['form_action'] = site_url('mikrotik/process_update');	
		$connect = $this->connect;
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
			
			if ($connect){
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
				redirect('hotspot_user');				
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
		$this->load->view('template_sbadmin/header', $data);
		$this->load->view('template_sbadmin/sidebar', $data);
		$this->load->view('template_sbadmin/menu', $data);
		$this->load->view('mikrotik/user_form', $data);
		$this->load->view('template_sbadmin/footer', $data);				
	}	
	
	public function user_remove($id){
		$connect = $this->connect;
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/remove',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dihapus!');
			redirect('hotspot_user');
		}	
	}
	
	public function user_disable($id){	
		$connect = $this->connect;	
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/disable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dinonaktifkan!');
			redirect('hotspot_user');
		}
	}
	
	public function user_enable($id){
		$connect = $this->connect;	
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/enable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil diaktifkan!');
			redirect('hotspot_user');
		}
	}
	
	public function hotspot_profile_remove($id){
		$connect = $this->connect;
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/profile/remove',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data profil tersebut berhasil dihapus!');
			redirect('hotspot_profile');
		}	
	}
	
	public function hotspot_profile_disable($id){	
		$connect = $this->connect;	
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/profile/disable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data profil tersebut berhasil dinonaktifkan!');
			redirect('hotspot_profile');
		}
	}
	
	public function hotspot_profile_enable($id){
		$connect = $this->connect;	
		if ($connect){
			$this->routerapi->write('/ip/hotspot/user/profile/enable',false);
			$this->routerapi->write('=.id='.$id);
			$hotspot_users = $this->routerapi->read();
			$this->routerapi->disconnect();	
			$this->session->set_flashdata('message','Data profil tersebut berhasil diaktifkan!');
			redirect('hotspot_profile');
		}
	}
}