<?php
class AssignedClasses extends CI_Controller {
	public function index() {
		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');
		$this->load->view('admin/assigned/assign_list');
	}

	public function Add_AssignedClass() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$data['depts'] = $this->Admin_model->fetch_dept();
		$this->load->view('admin/assigned/assign_add', $data);
	}

	public function Update_AssignedClass() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$id = $this->input->get('id');
		$data['assign'] = $this->Admin_model->fetch_selected_assigned($id);
		$this->load->view('admin/assigned/assign_edit', $data);
	}

	public function getStudents() {
		$this->load->model('Admin_model');
		// die('asduga');
		$this->Admin_model->get_studentslist();
	}
}
?>