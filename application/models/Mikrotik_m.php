<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mikrotik_m extends CI_Model{
  
	public function save($data){ 
		$query = $this->db->insert('live_stat',$data);
		return $query;
	}
	 
}
 