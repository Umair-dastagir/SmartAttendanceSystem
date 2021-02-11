<?php 

class SpecialProcedureReport extends CI_Controller {

	public function __construct() {
		parent:: __construct();

		$this->load->model('App_info_model');
		$this->load->model('Others');
		$this->load->helper('form');
		$this->load->helper('string');
	}

	public function index() {

		$settings_id = 1;
		$this->App_info_model->get_app_name($settings_id);
		$this->App_info_model->get_app_favicon($settings_id);
		$this->App_info_model->get_app_logo($settings_id);
		$this->App_info_model->get_app_icon($settings_id);
		$this->App_info_model->get_app_welcome_image($settings_id);
		$this->App_info_model->get_app_key($settings_id);

		$this->load->view('templates/header');
		$this->load->view('specialprocedure/procedurereport');
	} 
}

?>