<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        auth_login();
    }

	public function index()
	{
		$data['title'] = 'List Users';
		$data['page']  = 'user/index';
		$data['data']  = $this->db->get('users')->result();
		$this->load->view('backend/layout',$data);
	}

	public function add()
	{
		$data['title'] = 'Tambah User';
		$data['page']  = 'user/add';
		$this->load->view('backend/layout',$data);
	}

	public function add_save()
	{
		$email		= $this->input->post('email');
		$input      = $this->input->post();
		$check      = $this->db->where('email',$email)->get('users')->result();
		if(count($check)>0)
		{
			$this->session->set_flashdata('error', 'Data dengan email <b>'.$email.'</b> sudah ada. gunakan data lain');
			redirect('panel/users/add');
		}else{
			foreach ($input as $key => $value) {
				if($key=='password'){
					$save[$key] = sha1($value);
				}else{
					$save[$key] = $value;
				}
			}
			$this->db->insert('users',$save);

			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect('panel/users');
		}
	}

	public function edit($id)
	{
		$data['title'] = 'Edit User';
		$data['page']  = 'user/edit';
		$data['data']  = $this->db->where('id',$id)->get('users')->row();
		$this->load->view('backend/layout',$data);
	}

	public function edit_save($id)
	{
		$email 		= $this->input->post('email');
		$input      = $this->input->post();
		$check      = $this->db->where('id !=',$id)->where('email',$email)->get('users')->result();
		if(count($check)>0)
		{
			$this->session->set_flashdata('error', 'Data dengan email <b>'.$email.'</b> sudah ada. gunakan data lain');
			redirect('panel/users/edit/'.$id);
		}else{
			foreach ($input as $key => $value) {
				if($key=='password'){
					if(!empty($value)){
						$save[$key] = sha1($value);
					}
				}elseif($key=='status'){
					$save[$key] = (empty($value) ? 'non active' : 'active');
				}else{
					$save[$key] = $value;
				}
			}
			$this->db->where('id',$id)->update('users',$save);

			$this->session->set_flashdata('success', 'Data berhasil diperbaharui');
			redirect('panel/users');
		}
	}

	public function delete($id='')
	{
		if($id == '')
		{
			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('panel/users');
		}else{
			if($id==1)
			{
				$this->session->set_flashdata('error', 'Data gagal dihapus. Superadmin tidak dapat dihapus');
				redirect('panel/users');
			}else{

					$this->db->where('id',$id)->delete('users');
					$this->session->set_flashdata('success', 'Data berhasil dihapus');
					redirect('panel/users');
			}
		}
	}

}