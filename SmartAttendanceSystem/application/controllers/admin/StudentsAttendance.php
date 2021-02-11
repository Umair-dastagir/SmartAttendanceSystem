<?php

class StudentsAttendance extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->view('includes/nav_header');
		$this->load->model('Admin_model');

	}

	public function index() {
		$this->load->view('admin/attendance/attendance_list');
	}

	public function StudentClass() {
		$this->load->view('admin/attendance/individual_class');
	}
}

?>