<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\Firebase;
class Mikrotik extends CI_Controller {	
	private $connect;	
	function __construct(){
		parent::__construct();						
		$this->connect = 		$this->routerapi->connect('192.168.88.1','admin','masuk123');
        $this->firebase_url = "https://mikrotik-98046-default-rtdb.asia-southeast1.firebasedatabase.app/";
        $this->firebase_api = "bb6duQ2qXHwjYzp1Umm9Fs8WzLcegwUXUMXGFN6a";
		 
	}
			
	public function index()
	{		
        $connect =$this->connect  ;	 
        $data = array();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('mikrotik/index', $data);
		$this->load->view('template/footer', $data);
	}
	
    public function monitoring()
	{		
        $connect = $this->connect;	   
        $interface = $this->routerapi->comm('/interface/print');
        foreach($interface as $v){
            $network = $this->routerapi->comm('/interface/monitor-traffic',array(
                'interface' => $v['name'],
                'once' =>''
            ));
            $data['live_stat'][] = array(
                    'interface' => $v['name'],
                    'rx' =>  $network[0]['rx-bits-per-second'],
                    'tx' => $network[0]['tx-bits-per-second']
            );
        }

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('mikrotik/monitoring', $data);
		$this->load->view('template/footer', $data);
	}
    public function bandwidth()
	{		
        $connect = $this->connect;	 
        $data = array();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('mikrotik/index', $data);
		$this->load->view('template/footer', $data);
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
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('mikrotik/user', $data);
		$this->load->view('template/footer', $data);
	}

    public function live_stat()
    {
        // header('Content-Type: application/json');
        $connect = $this->connect;	   
        $interface = $this->routerapi->comm('/interface/print');
       
        $no=0;  foreach($interface as $v){
            $network = $this->routerapi->comm('/interface/monitor-traffic',array(
                'interface' => $v['name'],
                'once' =>''
            ));
            $data_internet[] = array(
                    '0' => $no+1,
                    '1' => $v['name'],
                    '2' => formatBytes($network[0]['rx-bits-per-second']),
                    '3' => formatBytes($network[0]['tx-bits-per-second'])
            );
            $no++;
        }
        $data['recordsTotal'] = count($data_internet);
        $data['recordsFiltered'] = count($data_internet);
        $data['data'] =  $data_internet;
        echo json_encode($data);
    }

    public function get_data()
	{
		$fb = Firebase::initialize($this->firebase_url, $this->firebase_api);
	    $a = $fb->get('/data');
		echo json_encode($a);
		
	}
	

    // public function save_stast()
    // { 
    //     $connect = $this->connect;	  
    //     $fetch = $this->routerapi->comm('/interface/monitor-traffic',array(
    //         'interface' => 'INTERNET',
    //         'once' =>''
    //     ));        
    //     $data = array(
    //         'interface' => "INTERNET",
    //         'datetime' => date('Y-m-d h:i:s'),
    //         'rx' => $fetch[0]["rx-bits-per-second"] ,
    //         'tx' =>  $fetch[0]["tx-bits-per-second"]
    //     );        
    //     $this->mikrotik_m->save($data);        
    // }

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

        $fb = Firebase::initialize($this->firebase_url, $this->firebase_api); 
	    $a = $fb->push('/data', $data);
		echo json_encode($a);
    }
	
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