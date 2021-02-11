<?php
class Instructor extends CI_Controller {
	public function index() {
		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');
		$this->load->view('admin/instructor/inst_list');
	}

	public function Add_Instructor() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$data['depts'] = $this->Admin_model->fetch_dept();
		$this->load->view('admin/instructor/inst_add', $data);
	}

	public function Update_Instructor() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$id = $this->input->get('id');
		$data['instructor'] = $this->Admin_model->fetch_selected_ins($id);
		$this->load->view('admin/instructor/update_inst', $data);
	}
}
?>