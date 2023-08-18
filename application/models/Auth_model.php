<?php

class Auth_model extends CI_Model
{
	const SESSION_KEY = 'user_id';
    
    function __construct(){
		parent::__construct();
        $this->load->config('fcm'); 
    }

	public function rules()
	{
		return [
			[
				'field' => 'username',
				'label' => 'Username ',
				'rules' => 'required'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|max_length[255]'
			]
		];
	}

	public function login($user, $password)
	{
		
		// cek apakah user sudah terdaftar?
		if (!$user || $user != $this->config->item('user')) {
			return FALSE;
		}

		// cek apakah passwordnya benar?
		if (!$password || $password != $this->config->item('pass')) {
			return FALSE;
		}

		// bikin session
		$this->session->set_userdata([self::SESSION_KEY => $user]); 
		return $this->session->has_userdata(self::SESSION_KEY);
	}

	public function current_user()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}

		$user_id = $this->session->userdata(self::SESSION_KEY);
		return $user_id;
	}

	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		return !$this->session->has_userdata(self::SESSION_KEY);
	}

	 
}