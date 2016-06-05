<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	private $cid;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Info_model');
		$this->load->model('Company_model');
		$this->cid = session_conf('id');
	}
	public function index()
	{
		$cid = session_conf('id');
		if ($_POST) {
			$title = $this->input->post('title');
			$link  = $this->input->post('link');
			$this->Info_model->add_info($cid, $title, $link);
			redirect('home');
		}
		$ret = $this->Info_model->get_info($cid);
		$company = $this->Company_model->get_company_by_cid($cid);
		$this->load->view('home', array('title' => '添加内容', 'ret' => $ret, 'company' => $company));
	}
	public function edit($id = NULL)
	{
		if ($_POST) {
			$title   = $this->input->post('title');
			$link    = $this->input->post('link');
			$info_id = $this->input->post('id');
			$data = array(
				'title' => $title,
				'link' => $link
			);
			$ret = $this->Info_model->update($data, $this->cid, $info_id);
			redirect('/');
			return; 
		}
		if (empty($id)) { show_error('缺少参数'); }
		$cid = session_conf('id');
		$ret = $this->Info_model->get_edit_info($cid, $id);
		if ($ret) {
			$this->load->view('edit', array('title' => '编辑内容', 'ret' => $ret));
		} else {
			show_error('无数据');
		}
	}
	public function del($id)
	{
		$cid = session_conf('id');
		$ret = $this->Info_model->delete_info($cid, $id);
		if ($ret) {
			redirect('home');
		} else {
			show_error('删除失败');
		}
	}
}
