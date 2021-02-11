<?php
class AccountSettings extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('Admin_model');
		$this->load->view('includes/nav_header');

	}

	public function index() {
		// $this->load->model('Admin_model');
		// $this->load->view('includes/nav_header');

		$admin_id = $_SESSION['id'];
		$query = $this->Admin_model->fetch_admin_info($admin_id);
		foreach($query as $qry) {
			$data = array(
				'admin_email' => $qry->admin_email,
				'admin_name' => $qry->admin_name,
				'admin_lastname' => $qry->admin_lastname
			);
		}
		$this->load->view('admin/acc_settings', $data);
	}

	public function ChangePassword() {
		$admin_id = $_SESSION['id'];
		$query = $this->Admin_model->fetch_admin_info($admin_id);
		foreach($query as $qry) {
			$data = array(
				'password' => $qry->admin_pass
			);
		}
		$this->load->view('admin/change_pass', $data);
	}
}
?>