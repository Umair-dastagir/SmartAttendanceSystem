<?php
class Home extends CI_Controller {

	public function index() {
		$this->load->model('Instructor_model');
		$this->load->view('includes/header_ins');
		if(!empty($_SESSION['id'])) {
			$id = $_SESSION['id'];
			$courses['course'] = $this->Instructor_model->fetch_classes($id);
			$this->load->view('instructor/home', $courses);
		}
	}

}
?>