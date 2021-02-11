<?php
class Admin_model extends CI_Model {
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}

	public function get_studentslist(){

          	$classno = $this->input->post('data');

          	$query1 = $this->db->from('class')->where('class_id', $classno)->get()->result();
          	if($query1) {
          		foreach($query1 as $qr) {
          			$semester = $qr->semester;
          			$dept = $qr->depart_id;

          			$this->db->select('student_id, student_name, student_lastname, cms_id');
            	$this->db->from('students');
            	$this->db->where('student_dept',$dept);
            	$this->db->where('student_semester',$semester);
            	$query=$this->db->get();
            	if($query->num_rows() > 0){
               		foreach ($query->result() as $name) {
                    	echo'<option value="'.$name->student_id.'">'.$name->student_name.' '.$name->student_lastname.' - '.$name->cms_id.'</option>';
                	} 
            	}else{
                	echo '<option value="">No Student Found</option>';
            	}
          		}

          		
          	} else {
          		die('no class present');
          	}         
    }

    public function delete_elective($id) {
    	$this->db->where('assigned_id', $id);
		$query = $this->db->delete('electives');
		if($query) {
			return true;			
		} else {
			return false;
		}
    }

    public function insert_elective($data) {
    	$this->db->insert('electives', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function fetch_assign_class_student($class_id) {
    	$this->db->from('assigned_classes');
    	$this->db->where('asgn_id', $class_id);
    	$query = $this->db->get();

    	return $query;
    }	

    public function fetch_class_from_id($class_id) {
    	$this->db->from('class');
    	$this->db->where('class_id', $class_id);
    	$query = $this->db->get();

    	return $query;
    }

    public function fetch_students_deptsem($dept, $sem) {
    	$this->db->from('students');
    	$this->db->where('student_dept',$dept);
    	$this->db->where('student_semester',$sem);
    	$query = $this->db->get();

    	return $query->result();
    }	

    public function fetch_elective_students($assigned_id) {
    	$query = $this->db->from('electives')->where('assigned_id', $assigned_id)->get()->result();
    	return $query;
    }

    public function fetch_elective_students_detail($student_id) {
    	$query = $this->db->from('students')->where('student_id', $student_id)->get()->result();
    	return $query;
    }

	public function fetch_admin_detail($id) {
		$this->db->from('admin');
		$this->db->where('admin_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function register_admin($data) {
		$this->db->insert('admin', $data);
		if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_admin($email) {
		$this->db->from('admin');
		$this->db->where('admin_email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['admin_pass'];
			return $value;
		}
	}

	public function get_admin($email) {
		$this->db->from('admin');
		$this->db->where('admin_email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['admin_id'];
			return $value;
		}
	}

	// insert departments
	public function insert_dept($data) {
		$this->db->insert('department', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_faculty() {
		$this->db->from('faculty');
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_depts() {
		$this->db->select('*');
        $this->db->from('department as dep');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $query = $this->db->get();

        return $query->result();
	}

	public function fetch_selected_dept($id) {
		$this->db->select('*');
        $this->db->from('department as dep');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $this->db->where('dept_id', $id);
        $query = $this->db->get();

        return $query->result();
	}

	public function update_dept($data, $dept_id) {
		$this->db->where('dept_id', $dept_id);
        $query = $this->db->update('department', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}
	//// STUDENTS /////

	public function fetch_students() {
		$this->db->select('*');
        $this->db->from('department as dep');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $this->db->join('students as stu', 'dep.dept_id = stu.student_dept', 'INNER');
        $query = $this->db->get();

        return $query->result();
	}

	public function fetch_dept() {
		$this->db->from('department');
		$query = $this->db->get();
		return $query->result();
	}

	public function check_if_student_exists($cms) {
		$this->db->from('students');
		$this->db->where('cms_id', $cms);
		$query = $this->db->get();
		return $query->result();
	}

	public function register_student($data) {
		$this->db->insert('students', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function delete_student($id) {
		$this->db->where('student_id', $id);
		$query = $this->db->delete('students');
		if($query) {
			return true;			
		} else {
			return false;
		}
	}

	public function fetch_student_details($id) {
		$this->db->select('*');
        $this->db->from('students as stu');
        $this->db->join('department as dep', 'stu.student_dept = dep.dept_id', 'INNER');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $this->db->where('student_id', $id);
        $query = $this->db->get();

        return $query->result();
	}

	public function update_student($data, $st_id) {
		$this->db->where('student_id', $st_id);
        $query = $this->db->update('students', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	// add courses
	public function add_course($data) {
		$this->db->insert('courses', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_courses() {
		$this->db->from('courses');
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_selected_course($id) {
		$this->db->from('courses');
		$this->db->where('course_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_course($data, $cs_id) {
		$this->db->where('course_id', $cs_id);
        $query = $this->db->update('courses', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	/// classes
	public function add_class($data) {
		$this->db->insert('class', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_classes() {
		$this->db->select('*');
        $this->db->from('class as cls');
        $this->db->join('department as dep', 'cls.depart_id = dep.dept_id', 'INNER');
        // $this->db->join('courses as crs', 'cls.course_id = crs.course_id', 'INNER');
        // $this->db->join('instructor as ins', 'cls.inst_id = ins.instructor_id', 'INNER');
        $query = $this->db->get();

        return $query->result();
	}

	public function fetch_selected_class($id) {
		$this->db->select('*');
        $this->db->from('class as cls');
        $this->db->join('department as dep', 'cls.depart_id = dep.dept_id', 'INNER');
        // $this->db->join('courses as crs', 'cls.course_id = crs.course_id', 'INNER');
        // $this->db->join('instructor as ins', 'cls.inst_id = ins.instructor_id', 'INNER');
        $this->db->where('class_id', $id);
        $query = $this->db->get();

        return $query->result();
	}

	public function update_class($data, $cs_id) {
		$this->db->where('class_id', $cs_id);
        $query = $this->db->update('class', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function check_if_ins_exists($email) {
		$this->db->from('instructor');
		$this->db->where('instructor_email', $email);
		$query = $this->db->get();
		return $query->result();
	}

	public function register_instructor($data) {
		$this->db->insert('instructor', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_ins() {
		$this->db->from('instructor');
		$this->db->order_by('instructor_name', 'asc');
		$query = $this->db->get();

		return $query->result();
	}

	public function fetch_instructors() {
		$this->db->select('*');
        $this->db->from('instructor as ins');
        $this->db->join('department as dep', 'ins.instructor_dept = dep.dept_id', 'INNER');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $query = $this->db->get();

        return $query->result();
	}

	public function fetch_selected_ins($id) {
		$this->db->select('*');
        $this->db->from('instructor as ins');
        $this->db->join('department as dep', 'ins.instructor_dept = dep.dept_id', 'INNER');
        $this->db->join('faculty as fac', 'dep.faculty_id = fac.faculty_id', 'INNER');
        $this->db->where('instructor_id', $id);

        $query = $this->db->get();

        return $query->result();
	}

	public function update_ins($data, $ins_id) {
		$this->db->where('instructor_id', $ins_id);
        $query = $this->db->update('instructor', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function delete_instructor($id) {
		$this->db->where('instructor_id', $id);
		$query = $this->db->delete('instructor');
		if($query) {
			return true;			
		} else {
			return false;
		}
	}

	// assigned classes
	public function fetch_class() {
		$this->db->from('class');
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_course() {
		$this->db->from('courses');
		$query = $this->db->get();
		return $query->result();
	}

	public function add_assigned($data) {
		$this->db->insert('assigned_classes', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	public function fetch_assigned_classes() {
		$this->db->select('*');
        $this->db->from('assigned_classes as asc');
        $this->db->join('class as cls', 'asc.class_id = cls.class_id', 'INNER');
        $this->db->join('department as dept', 'cls.depart_id = dept.dept_id', 'INNER');
        $this->db->join('courses as cs', 'asc.course_id = cs.course_id', 'INNER');
        $this->db->join('instructor as ins', 'asc.instructor_id = ins.instructor_id', 'INNER');
        // $this->db->join('students as stu', 'asc.student_id = stu.student_id', 'INNER');
        $query = $this->db->get();

        return $query->result();
	}

	public function fetch_selected_assigned($id) {
		$this->db->select('*');
        $this->db->from('assigned_classes as asc');
        // $this->db->join('class as cls', 'asc.classs_id = cls.class_id', 'INNER');
        // $this->db->join('courses as cs', 'cls.course_id = cs.course_id', 'INNER');
        // $this->db->join('instructor as ins', 'cls.inst_id = ins.instructor_id', 'INNER');
        // $this->db->join('students as stu', 'asc.student_id = stu.student_id', 'INNER');
        $this->db->join('class as cls', 'asc.class_id = cls.class_id', 'INNER');
        $this->db->join('department as dept', 'cls.depart_id = dept.dept_id', 'INNER');
        $this->db->join('courses as cs', 'asc.course_id = cs.course_id', 'INNER');
        $this->db->join('instructor as ins', 'asc.instructor_id = ins.instructor_id', 'INNER');
        $this->db->where('asgn_id', $id);
        $query = $this->db->get();

        return $query->result();
	}

	public function update_assigned($data, $asn_id) {
		$this->db->where('asgn_id', $asn_id);
        $query = $this->db->update('assigned_classes', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function fetch_admin_info($id) {
		$this->db->from('admin');
		$this->db->where('admin_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_info($data, $id) {
		$this->db->where('admin_id', $id);
        $query = $this->db->update('admin', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
	}

	public function get_students() {
		$this->db->from('students');
		$this->db->order_by('student_name', 'asc');
		$query = $this->db->get();

		return $query->result();
	}

	public function fetch_all_assigned() {
		$this->db->select('*');
        $this->db->from('assigned_classes as asc');
        $this->db->join('class as cl', 'asc.class_id = cl.class_id', 'INNER');
        $this->db->join('courses as cs', 'asc.course_id = cs.course_id', 'INNER');
        $this->db->join('instructor as ins', 'asc.instructor_id = ins.instructor_id', 'INNER');
		$query = $this->db->get();
        return $query->result();
	}

	public function fetch_attendance_assigned($id) {
		$this->db->select('distinct(st_id) as std, st.student_name, st.student_lastname, st.cms_id, st.student_dept, st.student_semester');
        $this->db->from('stud_attendance as stad');
        $this->db->join('students as st', 'stad.st_id = st.student_id', 'INNER');
        // $this->db->join('courses as cs', 'asc.course_id = cs.course_id', 'INNER');
        // $this->db->join('instructor as ins', 'asc.instructor_id = ins.instructor_id', 'INNER');
        $this->db->where('stad.assign_id', $id);
		$query = $this->db->get();
        return $query;
	}

	public function check_in_att($id, $st_id) {
		return $this->db->from('stud_attendance')->where('assign_id', $id)->where('st_id', $st_id)->get()->result();
	}

	public function check_course_type($id) {
		return $this->db->from('assigned_classes')->where('asgn_id', $id)->get()->result_array()[0]['elective'];
	}

	public function fetch_studentsss($sem_id, $dept_id) {
		$this->db->from('students');
		$this->db->where('student_dept', $dept_id);
		$this->db->where('student_semester', $sem_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_class_id($id) {
		$query = $this->db->from('assigned_classes')->where('asgn_id', $id)->get()->result_array()[0]['class_id'];
		return $query;
	}

	public function fetch_class_det($id) {
		$query = $this->db->from('class')->where('class_id', $id)->get();
		return $query;
	}

	public function count_rows_classes($assigned_id) {
		return $this->db->query('SELECT COUNT(att_id) as ct from attendance where assigned_id = '.$assigned_id)->result();
	} 

	public function fetch_student_att($student, $assigned) {
		return $this->db->query('SELECT COUNT(att_id) as at from stud_attendance where assign_id = '.$assigned. ' and st_id = '.$student)->result();
	}

	public function student_name($student) {
		$this->db->from('students');
		$this->db->where('student_id', $student);
		$query = $this->db->get();

		return $query->result();

	}

		public function student_cms($student) {
		$this->db->from('students');
		$this->db->where('student_id', $student);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$value = $data['cms_id'];
			return $value;
		}
	}

	public function fetch_st_from_elective($id) {
		$this->db->select('distinct(att.st_id) as std, st.student_name, st.student_lastname, st.cms_id, st.student_dept, st.student_semester');
        $this->db->from('stud_attendance as att');
        $this->db->join('students as st', 'st.student_id = att.st_id', 'INNER');
        $this->db->where('att.assign_id', $id);
		$query = $this->db->get();
        return $query->result();
	}

	public function get_elective_assigned($id) {
		$this->db->select('*');
		$this->db->from('electives as el');
		$this->db->join('students as st', 'st.student_id = el.student_id', 'INNER');
		$this->db->where('el.assigned_id', $id);
		return $this->db->get()->result();
	}

	public function check_if_dept_exists($dept) {
		$query = $this->db->from('department')->where('dept_name', $dept)->get()->result();
		return $query;
	}

	public function check_if_course_exists($course, $hrs) {
		$query = $this->db->from('courses')->where('course_code', $course)->where('cred_hours', $hrs)->get()->result();
		return $query;
	}

	public function check_if_class_exists($class) {
		$query = $this->db->from('class')->where('class_no', $class)->get()->result();
		return $query;
	}
}
?>