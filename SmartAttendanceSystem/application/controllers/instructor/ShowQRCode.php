<?php
class ShowQRCode extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Ciqrcode');
	}

	public function index() {
		$this->load->model('Instructor_model');
		$this->load->view('includes/header_ins');
		$this->load->view('instructor/qr_code');

		$random_string = generateRandomString();
		$assign_id = $this->input->get('id');
		$data = array(
			'qr_code' => $random_string,
			'assigned_id' => $this->input->get('id'),
			'date' => date("Y-m-d")
		);


		$check = $this->Instructor_model->check_exists_qr(date("Y-m-d"), $this->input->get("id"));
		if($check) {
			foreach($check as $ch) {
				$qrcode = $ch->qr_code;
			}

			QRcode::png(
				$qrcode,
				$outfile = false,
				$level = QR_ECLEVEL_H,
				$size = 15,
				$margin = 2
			);

		} else {
			$this->Instructor_model->save_qr($data);
			QRcode::png(
				$random_string,
				$outfile = false,
				$level = QR_ECLEVEL_H,
				$size = 15,
				$margin = 2
			);
		}
		
	}

	public function QRCode() {
		
	}

}

function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>