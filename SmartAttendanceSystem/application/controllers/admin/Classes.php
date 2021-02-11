<?php
class Classes extends CI_Controller {
	public function index() {
		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');
		$this->load->view('admin/classes/class_list');
	}

	public function Add_Class() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$this->load->view('admin/classes/class_add');
	}

	public function Update_Class() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$id = $this->input->get('id');
		$data['class'] = $this->Admin_model->fetch_selected_class($id);
		$this->load->view('admin/classes/update_class', $data);
	}
}
?>