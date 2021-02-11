<?php
class Departments extends CI_Controller {

	public function index() {
		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');
		$this->load->view('admin/department/dept_list');
	}

	public function Add_Department() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$this->load->view('admin/department/dept_add');
	}

	public function Update_Department() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$id = $this->input->get('id');
		$data['dept'] = $this->Admin_model->fetch_selected_dept($id);
		$this->load->view('admin/department/update_dept', $data);
	}
}
?>