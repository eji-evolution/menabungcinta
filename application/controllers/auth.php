<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function index()
	{
		$session = $this->session->userdata('admin');
		if(!empty($session))
		{
			redirect('panel/dashboard');
		}else{
			$this->load->view('auth/login');
		}
	}

	public function login()
	{
		$email = $this->input->post('email');
		$pass  = sha1($this->input->post('password'));
		$check = $this->db->where('email',$email)->where('status','active')->get('users')->row();
		if(empty($check))
		{
			$this->session->set_flashdata('error', 'Akun tidak terdaftar');
			redirect('auth');
		}else{
			if($check->password != $pass)
			{
				$this->session->set_flashdata('error', 'Password tidak valid');
				redirect('auth');
			}else{
				$userdata = array( 
					'id'       => $check->id, 
					'group_id' => $check->group_id );
				$this->session->set_userdata('admin',$userdata);
				$this->session->set_flashdata('success', 'Selamat datang di halaman admin');
				redirect('panel/dashboard');
			}
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('admin');
		$this->session->set_flashdata('success', 'Berhasil keluar system');
		redirect('auth');
	}
}
