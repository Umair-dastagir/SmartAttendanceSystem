<?php
class Signin extends CI_Controller {

	public function index() {
		$this->load->model('Instructor_model');
		$input_email = $this->input->post('email');
		$input_pass = $this->input->post('password');

		$get_pass['pass'] = $this->Instructor_model->fetch_instructor($this->input->post('email'));
		$this->load->view('includes/header');
		$this->load->view('instructor/signin', $get_pass);
	}

	public function sign_out() {
		session_destroy();
		redirect(base_url());
	}
}
?>