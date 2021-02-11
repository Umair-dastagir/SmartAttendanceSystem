<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Account extends REST_Controller {

	public function __construct() {
       parent::__construct();   
       $this->load->config('email');
       $this->load->model('Student_model');

    }

	public function output($Return=array()) {
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
    }

    public function sign_in_post() {
        if($this->input->post('email') == '') {
            
            $Return['status'] = "false";
            $Return['message'] = 'Email is required';
            $Return['data']= array();

        } else if($this->input->post('password') == '') {

            $Return['status'] = "false";
            $Return['message'] = 'Password is required';
            $Return['data']= array();

        } else {    
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $active_state = $this->Student_model->check_active_state($email);
            if($active_state == 0) {
                $check_user = $this->Student_model->check_user($email, $password);
                if($check_user == true) {
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $data = array(
                        'is_active' => 1,
                        'student_password' => $password_hash
                    );

                    $update = $this->Student_model->update_state($data, $email, $password);
                    if($update) {
                        $fetchuser = $this->Student_model->verify_pass($email);
                        foreach($fetchuser as $user) {

                            $data = array(
                            'id' => $user->student_id,
                            'name' => $user->student_name,
                            'email' => $user->student_email,
                            'semester' => $user->student_semester,
                            'dept' => $user->student_dept
                        );
                        }

                        $Return['status'] = "true";
                        $Return['message'] = 'User Logged in Successfully';
                        $Return['data']= $data;
                    } else {
                        $Return['status'] = "false";
                        $Return['message'] = 'User could not be activated. Try again';
                        $Return['data']= array();
                    }

                } else {
                    $Return['status'] = "false";
                    $Return['message'] = 'Unable to login. Enter valid credentials';
                    $Return['data']= array();
                }


            } else if($active_state == 1) {
                $verify_pass = $this->Student_model->verify_pass($email);
                if($verify_pass) {
                    foreach($verify_pass as $vf) {
                        $pass = $vf->student_password;
                        if(password_verify($password, $pass)) {
                        $data = array(
                            'id' => $vf->student_id,
                            'name' => $vf->student_name,
                            'email' => $vf->student_email,
                            'semester' => $vf->student_semester,
                            'dept' => $vf->student_dept
                        );

                            $Return['status'] = "true";
                            $Return['message'] = 'User Logged in Successfully';
                            $Return['data']= $data;
                        } else {
                            $Return['status'] = "false";
                            $Return['message'] = 'Incorrect password. Try again';
                            $Return['data']= array();
                        }
                    }
                } else {    
                    $Return['status'] = "false";
                    $Return['message'] = 'User not registered. Contact the administrator for further details';
                    $Return['data']= array();
                }
            }
     }

        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit(); 
    }

    // fetch classes of each user
    public function enrolled_classes_get() {

        $user_id = $this->input->get('user_id');
        $semester = $this->input->get('semester');
        $department = $this->input->get('department'); 

        $getclasses = $this->Student_model->fetch_assigned_classes($department, $semester);
        if($getclasses) {
            foreach($getclasses as $gc) {
                $data[] = array(
                    'assigned_id' => $gc->asgn_id,
                    'class_id' => $gc->class_id,
                    'course_name' => $gc->course_name,
                    'course_id' => $gc->course_id,
                    'instructor_id' => $gc->instructor_id,
                    'instructor_name' => $gc->instructor_name.' '.$gc->instructor_lname
                );
            }

            $Return['status'] = "true";
            $Return['message'] = 'Classes fetched successfully';
            $Return['data']= $data;

        } else {
            $Return['status'] = "false";
            $Return['message'] = 'you are not enrolled in any classes';
            $Return['data']= array();
        }

        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit(); 
    }

    public function mark_attendance_post() {
        $user_id = $this->input->post('user_id');
        if($this->input->post('instructor_id') == '') {
            $Return['status'] = "false";
            $Return['message'] = 'enter instructor id';
            $Return['data']= array();
        } else if($this->input->post('class_id') == '') {
            $Return['status'] = "false";
            $Return['message'] = 'enter class id';
            $Return['data']= array();
        } else if($this->input->post('qr_code') == '') {
            $Return['status'] = "false";
            $Return['message'] = 'enter qr code';
            $Return['data']= array();
        } else if($this->input->post('course_id') == '') {
            $Return['status'] = "false";
            $Return['message'] = 'enter course id';
            $Return['data']= array();
        } else {
            $instructor_id = $this->input->post('instructor_id');
            $class_id = $this->input->post('class_id');
            $qr_code = $this->input->post('qr_code');
            $assigned_id = $this->input->post('assigned_id');
            $course_id = $this->input->post('course_id');
            $date = date("Y-m-d");

            $check_qr_code = $this->Student_model->match_qr_code($instructor_id, $class_id, $date, $qr_code, $course_id);

            if($check_qr_code) {
                $check_attendance = $this->Student_model->check_marked_attendance($user_id, $check_qr_code);
                if($check_attendance) {
                    $Return['status'] = "false";
                    $Return['message'] = "your attendance is already marked";
                    $Return['data']= array();
                } else {
                    $student_email = $this->Student_model->fetch_student_email($user_id);
                    $data = array(
                        'att_id' => $check_qr_code,
                        'st_id' => $user_id,
                        'statuss' => 1, // marked
                        'assign_id' => $assigned_id,
                        'student_email' => $student_email
                    );
                    $Return['status'] = "true";
                    $Return['message'] = 'QR matches!';
                    $Return['data']= $data;
                }

            } else {
                $Return['status'] = "false";
                $Return['message'] = 'QR does not match';
                $Return['data']= array();
            }
        }
        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit(); 
    }


    public function save_details_post() {
        $attendance_id = $this->input->post('attendance_id');
        $student_id = $this->input->post('student_id');
        $status = 1;
        $assigned_id = $this->input->post('assigned_id');

        $data = array(
            'att_id' => $attendance_id,
            'st_id' => $student_id,
            'status' => $status, // marked
            'assign_id' => $assigned_id
        );

         $mark_attendance = $this->Student_model->mark_attendance($data);
                if($mark_attendance) {
                    $Return['status'] = "true";
                    $Return['message'] = 'Your Attendance is marked!';
                    $Return['data']= array();
                } else {
                    $Return['status'] = "false";
                    $Return['message'] = 'Attendance not marked due to some error. Try again';
                    $Return['data']= array();
                }
        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit();
    }



    public function check_qr_code_post() {
        $qr_code = $this->input->post('qr_code');
        $check = $this->Student_model->check_code($qr_code);

        if($check) {
            $Return['status'] = "true";
            $Return['message'] = 'codes match';
            $Return['data']= array();
        } else {
            $Return['status'] = "false";
            $Return['message'] = 'dont match';
            $Return['data']= array();
        }

        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit();

    }

    public function fetch_user_courses_get() {
        $student_id = $this->input->get('student_id');

        if($student_id == '') {
            $Return['status'] = "false";
            $Return['message'] = 'user id required';
            $Return['data']= array();
        } else {
            $semester = $this->Student_model->fetch_student_class_data($student_id)['student_semester'];
            $department = $this->Student_model->fetch_student_class_data($student_id)['student_dept'];

            $classid = $this->Student_model->fetch_class_id($semester, $department);

            $student_enrolled_classes = $this->Student_model->fetch_enrolled_student_classes($classid);
            if($student_enrolled_classes) {
                foreach($student_enrolled_classes as $enr) {
                    if($enr->elective == 1) {
                        $check_student = $this->Student_model->check_elective($student_id, $enr->asgn_id);
                        if(!$check_student) {
                            continue;
                        } 
                    }

                    $fetch_total_classes = $this->Student_model->count_rows_classes($enr->asgn_id);
                    if($fetch_total_classes) {
                        foreach($fetch_total_classes as $ft) {
                            $total = $ft->ct;
                        }
                    } else {
                        $total = 0;
                    }


                    $fetch_student_attendance = $this->Student_model->fetch_student_att($student_id, $enr->asgn_id);
                    if($fetch_student_attendance) {
                        foreach($fetch_student_attendance as $attendance) {
                            $att = $attendance->at;
                        }
                    } else {
                        $att = 0;
                    }

                    if($att == 0 || $total == 0) {
                        $percentage = '0';
                    } else {
                        $percentage = floor(($att/$total)*100);
                    }

                    $ins_name = $this->Student_model->fetch_instructor_name($enr->instructor_id)['instructor_name'];
                    $ins_lname = $this->Student_model->fetch_instructor_name($enr->instructor_id)['instructor_lname'];
                    $type = $enr->elective;
                    if($type == 0) { $val = 'Compulsory'; } else { $val = 'Elective'; }
                    $data[] = array(
                        'class_number' => $this->Student_model->fetch_class_name($classid),
                        'instructor_name' => $ins_name.' '.$ins_lname,
                        'course_name' => $this->Student_model->fetch_course($enr->course_id)['course_name'],
                        'course_code' => $this->Student_model->fetch_course($enr->course_id)['course_code'],
                        'instructor_id' => $enr->instructor_id,
                        'class_id' => $enr->class_id,
                        'assigned_id' => $enr->asgn_id,
                        'type' => $val,
                        'total_classes' => $total,
                        'attended_classes' => $att,
                        'percentage' => $percentage,
                        'course_id' => $enr->course_id
                    );

            $Return['status'] = "true";
            $Return['message'] = 'success';
            $Return['data']= $data;

                }
            } else {
                $Return['status'] = "false";
                $Return['message'] = 'student not enrolled in any class';
                $Return['data']= array();
            }
        }

        $data=$this->output($Return);
        $this->response($data, REST_Controller::HTTP_OK);
        exit();
    }
}

?>