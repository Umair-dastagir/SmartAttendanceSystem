<?php
class Signin extends CI_Controller {

	public function index() {
		$this->load->model('Admin_model');
		$input_email = $this->input->post('email');
		$input_pass = $this->input->post('password');

		$get_pass['pass'] = $this->Admin_model->fetch_admin($this->input->post('email'));
		// $authenticate['admin'] = $this->Admin_model->authenticate_admin($this->input->post('email'), $this->input->post('password'));
			$this->load->view('includes/header');
			$this->load->view('admin/sign_in', $get_pass);
	}

	// public function AdminSignIn() {
	// 	// $this->load->view('includes/header');
	// 	$this->load->model('Admin_model');
	// 	$input_email = $this->input->post('email');
	// 	$input_pass = $this->input->post('password');

	// 	$get_pass['pass'] = $this->Admin_model->fetch_admin($this->input->post('email'));
	// 	// $authenticate['admin'] = $this->Admin_model->authenticate_admin($this->input->post('email'), $this->input->post('password'));

	// 		$this->load->view('admin/sign_in', $get_pass);

		
	// }

	public function Home() {
		$this->load->model('Admin_model');
		$this->load->view('admin/home');
	} 

	public function sign_out() {
		session_destroy();
		// $this->load->view('select');
		redirect(base_url());
	}
}
?>