<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Assign Class</title>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
  <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">ASSIGN CLASS</h3>
  </div>
</div>
<e style="font-size: 14px; color: #000">

<form enctype="multipart/form-data" method="POST">
  <div class="card border border-0 rounded-0 pt-5 pb-5 mr-5 ml-5 mb-3 mt-3">
  <div class="card border border-0 rounded-0 shadow ml-5 mr-5">
    <div class="container">
      <div class="row">
      <div class="col">
      <div class="card-body">
        <div class="container ml-2">
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Class Number:
            <select class="form-control mt-1 rounded-0 cls" name="class" style="width: 100%">
              <option value="">Select Class</option>
              <?php
              $class = $this->Admin_model->fetch_class();
              foreach($class as $cl) {
              ?>
              <option value="<?php echo $cl->class_id?>"><?php echo $cl->class_no;?></option>
              <?php } ?>
            </select>
            </p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Instructor:
              <select class="form-control mt-1 rounded-0" type="text" name="instructor" style="width: 100%">
                <option>Select Instructor</option>
                <?php
                $instructor = $this->Admin_model->fetch_ins();
                foreach($instructor as $s) {
                ?>
                <option value=<?php echo $s->instructor_id?>><?php echo $s->instructor_name.' '.$s->instructor_lname;?></option>
                <?php } ?>
              </select>
              </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course:
              <select class="form-control mt-1 rounded-0" type="text" name="course" style="width: 100%">
                <option>Select Course</option>
                <?php
                $course = $this->Admin_model->fetch_course();
                foreach($course as $s) {
                ?>
                <option value=<?php echo $s->course_id?>><?php echo $s->course_name.' - '.$s->course_code;?></option>
                <?php } ?>
              </select>
              </p>
          </div>
        </div>

        <div class="row">
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Subject Type:
             <select class="form-control elec-type" id="type" name="type">
                <option value="0">Compulsory</option>
                <option value="1">Elective</option>
             </select>
            </p>
          </div>

          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px" id="list">Students List:
              <select class="form-control" id="st_list" name="list[]" multiple>
                  
              </select>
            </p>
          </div>

        </div>

        <br>
        <div class="row">
          <div class="col col-sm">
          <button style="float:right" class="btn btn-primary rounded-0" name="save"><i class="fa fa-check-square" aria-hidden="true"></i> Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>

<?php
if(isset($_POST['save'])) {
  if($this->input->post('class') == '') {
      echo '<script type="text/javascript">window.alert("Class is required")</script>';
  } else if($this->input->post('instructor') == '') {
      echo '<script type="text/javascript">window.alert("Instructor is required")</script>';
  } else if($this->input->post('course') == '') {
      echo '<script type="text/javascript">window.alert("Course is required")</script>';
  } else {
    $class = htmlspecialchars(trim($this->input->post('class')));
    $instructor_id = htmlspecialchars(trim($this->input->post('instructor')));
    $course_id = htmlspecialchars(trim($this->input->post('course')));
    $elective = htmlspecialchars($this->input->post('type'));

    $data = array(
      'class_id' => $class,
      'instructor_id' => $instructor_id,
      'course_id' => $course_id,
      'elective' => $elective
    );

    $insertassign = $this->Admin_model->add_assigned($data);
    if($insertassign) {
        echo '<script type="text/javascript">window.alert("Assigned Class Added Successfully")</script>';
        $assigned_id = $this->db->insert_id();
    } else {
        echo '<script type="text/javascript">window.alert("Assigned Class Could Not Be Added. Try Again")</script>';
    }

    if($elective == 1) {



      $list = $this->input->post('list');
      foreach($list as $l) {
          $data1 = array(
            'class_id' => $class,
            'student_id' => $l,
            'instructor_id' => $instructor_id,
            'course_id' => $course_id,
            'assigned_id' => $assigned_id
          );

          $this->Admin_model->insert_elective($data1);
      }

      // $query_add = $this->Admin_model->insert_elective($data1);
    }
  }
}
?>


<?php } ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#list').hide();

      $('.elec-type').change(function() {
          $val = $(this).val();

          if($val == "1") {
              $("#list").show();

              $('.cls').change(function() {
                get_students();
              });
             
          } else {
              $("#list").hide();
          }
      });

      $('.cls').change(function() {
       
        $('.elec-type').change(function() {
          $val = $(this).val();

          if($val == "1") {
             get_students();
          } 
        });
      });


      function get_students() {
          var classs = $('.cls').val();
          $.ajax({
              url: "<?php echo base_url();?>admin/AssignedClasses/getStudents",
              method: "POST",
              data: {data:classs},
              success:function(data){
                // alert(data);
                $('#st_list').html(data);
            }
          });
        }
  });
</script>