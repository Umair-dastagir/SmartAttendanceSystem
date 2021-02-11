<?php 
	class ClassInformation extends CI_Controller {

		public function __construct() {
			parent::__construct();

			$this->load->model('Instructor_model');
			$this->load->model('Admin_model');
			$this->load->view('includes/header_ins');

		}

		public function index() {
			$this->load->view('instructor/class_info');

		}
	}
?>