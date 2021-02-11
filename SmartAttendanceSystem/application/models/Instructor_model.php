<?php
class Instructor_model extends CI_Model {
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}

	public function fetch_instructor($email) {
		$this->db->from('instructor');
		$this->db->where('instructor_email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['instructor_pass'];
			return $value;
		}
	}

	public function get_ins($email) {
		$this->db->from('instructor');
		$this->db->where('instructor_email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['instructor_id'];
			return $value;
		}
	}

	public function check_email($email) {
		$this->db->from('instructor');
		$this->db->where('instructor_email', $email);
		$query = $this->db->get();
		return $query->result();
	}

	public function check_active($email) {
		$this->db->from('instructor');
		$this->db->where('instructor_email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['is_active'];
			return $value;
		}
	}

	public function update_pass_active($email, $data) {
		$this->db->where('instructor_email', $email);
        $query = $this->db->update('instructor', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function fetch_classes($instructor_id) {
		$this->db->select('*');
        $this->db->from('assigned_classes as cls');
        $this->db->join('courses as cour', 'cls.course_id = cour.course_id', 'INNER');
        $this->db->join('instructor as ins', 'cls.instructor_id = ins.instructor_id', 'INNER');
        $this->db->join('class as cl', 'cls.class_id = cl.class_id', 'INNER');
        $this->db->join('department as dept', 'cl.depart_id = dept.dept_id', 'INNER');
        $this->db->where('cls.instructor_id', $instructor_id);
        $query = $this->db->get();

        return $query->result();
	}


	public function fetch_number_classes($id) {
        $this->db->from('class');
        $this->db->where('inst_id', $id);
        $query = $this->db->get();
		return $query->num_rows();
	}

	public function save_qr($data) {
		$this->db->insert('attendance', $data);
		if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_attendance_assigned($id, $ins_id) {
		$this->db->select('distinct(st_id) as std, st.student_name, st.student_lastname, st.cms_id, st.student_id, st.student_semester, st.student_dept');
        $this->db->from('stud_attendance as stad');
        $this->db->join('students as st', 'stad.st_id = st.student_id', 'INNER');
        $this->db->join('assigned_classes as acl', 'acl.asgn_id = stad.assign_id', 'INNER');
        // $this->db->join('instructor as ins', 'asc.instructor_id = ins.instructor_id', 'INNER');
        $this->db->where('stad.assign_id', $id);
        $this->db->where('instructor_id', $ins_id);
		$query = $this->db->get();
        return $query;
	}

	public function count_rows_classes($assigned_id) {
		return $this->db->query('SELECT COUNT(att_id) as ct from attendance where assigned_id = '.$assigned_id)->result();
	} 

	public function fetch_student_att($student, $assigned) {
		return $this->db->query('SELECT COUNT(att_id) as at from stud_attendance where assign_id = '.$assigned. ' and st_id = '.$student)->result();
	}

	public function get_type($id) {
		$query = $this->db->from('assigned_classes')->where('asgn_id', $id)->get()->result_array()[0]['elective'];

		return $query;
	}

	public function fetch_elective_data($id) {
		$query = $this->db->from('electives')->where('assigned_id', $id)->get()->result();

		return $query;
	}

	public function fetch_elective_student($id) {
		$query = $this->db->from('students')->where('student_id', $id)->get()->result();

		return $query;
	}

	public function fetch_class_assigned($id) {
		$query = $this->db->from('assigned_classes')->where('asgn_id', $id)->get()->result_array()[0]['class_id'];
		return $query;
	}

	public function class_data($id) {
		$query = $this->db->from('class')->where('class_id', $id)->get()->result_array()[0];
		return $query;
	}

	public function fetch_students($sem, $dept) {
		$query = $this->db->from('students')->where('student_semester', $sem)->where('student_dept', $dept)->get()->result();
		return $query;
	}

	public function check_exists_qr($date, $assigned_id) {
		$this->db->from('attendance');
		$this->db->where('date', $date);
		$this->db->where('assigned_id', $assigned_id);

		$query = $this->db->get();
		return $query->result();
	}
}

?>