<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('auth_login'))
{
	function auth_login()
	{
		$CI =& get_instance();
		$session = $CI->session->userdata('admin');
		if(empty($session))
		{
			$CI->session->set_flashdata('error', 'Akses ditolak, Silahkan login terlebih dahulu!');
			redirect('auth');
		}
	}
}

if ( ! function_exists('user_by_id'))
{
	function user_by_id($id)
	{
		$CI =& get_instance();
		$data = $CI->db->where('id',$id)->get('users')->row();
		return $data;
	}
}

if ( ! function_exists('group_by_id'))
{
	function group_by_id($id)
	{
		$CI =& get_instance();
		$data = $CI->db->where('id',$id)->get('groups')->row();
		return $data;
	}
}

if ( ! function_exists('get_all_group'))
{
	function get_all_group($id)
	{
		$CI =& get_instance();
		$data = $CI->db->get('groups')->result();
		return $data;
	}
}