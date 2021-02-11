<?php
class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
	}

	public function register_admin() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$name = $this->input->post('name');

		$result = array();

		$options = array('cost' => 12);
        $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);

        $data = array(
        	'admin_email' => $email,
        	'admin_pass' => $password_hash, 
        	'admin_name' => $name
        );

        $register = $this->Admin_model->register_admin($data);
        if($register) {
        	$result = array(
        		'status' => 1,
        		'message' => 'working'
        	);

        } else {
        	$result = array(
        		'status' => 0,
        		'message' => 'not working'
        	);
        }

        echo json_encode($result);
        exit();
	}
}
?>