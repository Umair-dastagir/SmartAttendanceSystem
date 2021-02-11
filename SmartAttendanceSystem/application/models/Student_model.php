<?php
class Student_model extends CI_Model {
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}

	public function check_active_state($email) {
		$this->db->from('students');
		$this->db->where('student_email', $email);	
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['is_active'];
			return $value;
		}
	}	

	public function check_user($email, $password) {
		$this->db->from('students');
		$this->db->where('student_email', $email);	
		$this->db->where('student_password', $password);	
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update_state($data, $email, $password) {
		$this->db->where('student_email', $email);
		$this->db->where('student_password', $password);
        $query = $this->db->update('students', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function verify_pass($email) {
		$this->db->from('students');
		$this->db->where('student_email', $email);	
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_assigned_classes($depart_id, $sem) {
		$this->db->select('*');
        $this->db->from('assigned_classes as enroll');
        $this->db->join('class as cls', 'enroll.class_id = cls.class_id', 'INNER');
        $this->db->join('courses as crs', 'crs.course_id = enroll.course_id', 'INNER');
        $this->db->join('instructor as ins', 'ins.instructor_id = enroll.instructor_id', 'INNER');
        $this->db->join('department as dept', 'dept.dept_id = cls.depart_id', 'INNER');
        $this->db->where('cls.depart_id', $depart_id);
        $this->db->where('cls.semester', $sem);
        $query = $this->db->get();

        return $query->result();
	}

	public function mark_attendance($data) {
		$this->db->insert('stud_attendance', $data);
		if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function match_qr_code($ins_id, $cls_id, $date, $qrcode, $course_id) {
		$this->db->select('*');
        $this->db->from('attendance as att');
        $this->db->join('assigned_classes as asn', 'asn.asgn_id = att.assigned_id', 'INNER');
		$this->db->where('instructor_id', $ins_id);
		$this->db->where('class_id', $cls_id);
		$this->db->where('date', $date);
		$this->db->where('qr_code', $qrcode);
		$this->db->where('course_id', $course_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['att_id'];
			return $value;
		}
	}

	public function check_code($code) {

		$this->db->from('attendance');
		$this->db->where('qr_code', $code);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['qr_code'];
			return $value;
		}
	}
	
	public function fetch_student_class_data($student_id) {
		$query = $this->db->from('students')->where('student_id', $student_id)->get()->result_array()[0];
		return $query;
	}

	public function fetch_class_id($semester, $department) {
		$query = $this->db->from('class')->where('depart_id', $department)->where('semester', $semester)->get()->result_array()[0]['class_id'];
		return $query;
	}

	public function fetch_enrolled_student_classes($class_id) {
		$query = $this->db->from('assigned_classes')->where('class_id', $class_id)->get()->result();
		return $query;
	}

	public function check_elective($student_id, $assigned_id) {
		$query = $this->db->from('electives')->where('student_id', $student_id)->where('assigned_id', $assigned_id)->get()->result();
		return $query;
	}

	public function fetch_class_name($class_id) {
		$query = $this->db->from('class')->where('class_id', $class_id)->get()->result_array()[0]['class_no'];
		return $query;
	}

	public function fetch_instructor_name($instructor_id) {
		$query = $this->db->from('instructor')->where('instructor_id', $instructor_id)->get()->result_array()[0];
		return $query;
	}

	public function fetch_course($course_id) {
		$query = $this->db->from('courses')->where('course_id', $course_id)->get()->result_array()[0];
		return $query;
	}

	public function count_rows_classes($assigned_id) {
		return $this->db->query('SELECT COUNT(att_id) as ct from attendance where assigned_id = '.$assigned_id)->result();
	} 

	public function fetch_student_att($student, $assigned) {
		return $this->db->query('SELECT COUNT(att_id) as at from stud_attendance where assign_id = '.$assigned. ' and st_id = '.$student)->result();
	}

	public function fetch_student_email($student_id) {
		$query = $this->db->from('students')->where('student_id', $student_id)->get()->result_array()[0]['student_email'];
		return $query;
	}

	public function check_marked_attendance($id, $att_id) {
		$this->db->from('stud_attendance');
		$this->db->where('st_id', $id);
		$this->db->where('att_id', $att_id);

		$query = $this->db->get();
		return $query->result();
	}
} 
?>