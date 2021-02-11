<?php
class Students extends CI_Controller {

	public function index() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$this->load->view('admin/students/student_list');
	}

	public function Add_Student() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$data['depts'] = $this->Admin_model->fetch_dept();
		$this->load->view('admin/students/student_add', $data);
	}

	public function Update_Student() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$data['students'] = $this->Admin_model->fetch_student_details($this->input->get('id'));
		$this->load->view('admin/students/edit_student', $data);
	}

}
?>