<?php
class Courses extends CI_Controller {

	public function index() {
		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');
		$this->load->view('admin/courses/course_list');
	}

	public function Add_Course() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$this->load->view('admin/courses/add_course');
	}

	public function Update_Course() {
		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');
		$id = $this->input->get('id');
		$data['course'] = $this->Admin_model->fetch_selected_course($id);
		$this->load->view('admin/courses/edit_course', $data);
	}
}
?>