<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        auth_login();
    }

	public function index()
	{
		$data['title'] = 'List Groups';
		$data['page']  = 'group/index';
		$data['data']  = $this->db->get('groups')->result();
		$this->load->view('backend/layout',$data);
	}

	public function add()
	{
		$data['title'] = 'Tambah Group';
		$data['page']  = 'group/add';
		$this->load->view('backend/layout',$data);
	}

	public function add_save()
	{
		$group_name = $this->input->post('group_name');
		$input      = $this->input->post();
		$check      = $this->db->where('group_name',$group_name)->get('groups')->result();
		if(count($check)>0)
		{
			$this->session->set_flashdata('error', 'Data dengan nama <b>'.$group_name.'</b> sudah ada. gunakan data lain');
			redirect('panel/groups/add');
		}else{
			foreach ($input as $key => $value) {
				$save[$key] = $value;
			}
			$this->db->insert('groups',$save);

			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect('panel/groups');
		}
	}

	public function edit($id)
	{
		$data['title'] = 'Edit Group';
		$data['page']  = 'group/edit';
		$data['data']  = $this->db->where('id',$id)->get('groups')->row();
		$this->load->view('backend/layout',$data);
	}

	public function edit_save($id)
	{
		$group_name = $this->input->post('group_name');
		$input      = $this->input->post();
		$check      = $this->db->where('id !=',$id)->where('group_name',$group_name)->get('groups')->result();
		if(count($check)>0)
		{
			$this->session->set_flashdata('error', 'Data dengan nama <b>'.$group_name.'</b> sudah ada. gunakan data lain');
			redirect('panel/groups/edit/'.$id);
		}else{
			foreach ($input as $key => $value) {
				$save[$key] = $value;
			}
			$this->db->where('id',$id)->update('groups',$save);

			$this->session->set_flashdata('success', 'Data berhasil diperbaharui');
			redirect('panel/groups');
		}
	}

	public function delete($id='')
	{
		if($id == '')
		{
			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('panel/groups');
		}else{
			if($id==1)
			{
				$this->session->set_flashdata('error', 'Data gagal dihapus. Superadmin tidak dapat dihapus');
				redirect('panel/groups');
			}else{

				$check      = $this->db->where('group_id',$id)->get('users')->result();
				if(count($check)>0)
				{
					$this->session->set_flashdata('error', 'Data gagal dihapus. Data masih digunakan');
					redirect('panel/groups');
				}else{
					$this->db->where('id',$id)->delete('groups');
					$this->session->set_flashdata('success', 'Data berhasil dihapus');
					redirect('panel/groups');
				}
			}
		}
	}

}