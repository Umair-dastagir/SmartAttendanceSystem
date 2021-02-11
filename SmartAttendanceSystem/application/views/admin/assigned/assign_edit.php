<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Assigned Class</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
  <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">EDIT ASSIGNED CLASS</h3>
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
        <?php foreach($assign as $asn) { ?>  
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Class Number:
            <select class="form-control mt-1 rounded-0 cls" name="class" style="width: 100%">
              <option value="<?php echo $asn->class_id?>"><?php echo $asn->class_no;?></option>
              <?php
              $class = $this->Admin_model->fetch_class();
              foreach($class as $cl) {
                if($cl->class_id != $asn->class_id) {
              ?>
              <option value=<?php echo $cl->class_id?>><?php echo $cl->class_no;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Instructor:
            <select class="form-control mt-1 rounded-0" name="instructor" style="width: 100%">
              <option value="<?php echo $asn->instructor_id?>"><?php echo $asn->instructor_name. ' '.$asn->instructor_lname;?></option>
              <?php
               $instructor = $this->Admin_model->fetch_ins();
              foreach($instructor as $f) {
                if($f->instructor_id != $asn->instructor_id) {
              ?>
              <option value=<?php echo $f->instructor_id?>><?php echo $f->instructor_name. ' '.$f->instructor_lname;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course:
            <select class="form-control mt-1 rounded-0" name="course" style="width: 100%">
              <option value="<?php echo $asn->course_id?>"><?php echo $asn->course_name. ' - '.$asn->course_code;?></option>
              <?php
               $course = $this->Admin_model->fetch_course();
              foreach($course as $f) {
                if($f->course_id != $asn->course_id) {
              ?>
              <option value=<?php echo $f->course_id?>><?php echo $f->course_name. ' - '.$f->course_code;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
        </div>

                <div class="row">
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Subject Type:
             <select class="form-control elec-type" id="type" name="type">
              <?php if($asn->elective == 0) {?>
                <option value="0">Compulsory</option>
                <option value="1">Elective</option>
              <?php } else { ?>
                <option value="1">Elective</option>
                <option value="0">Compulsory</option>
              <?php } ?>
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
          <button style="float:right" class="btn btn-primary rounded-0" name="save"><i class="fa fa-edit" aria-hidden="true"></i> Update Assigned Class</button>
          </div>
        </div>
      <?php }?>
      </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<br>

<div class="card border border-0 rounded-0 pt-5 pb-5 mr-5 ml-5 mb-3 mt-3">
  <div class="container">
    <table class="table table-bordered table-hover" style="width: 100%; color:black">
        <thead>
            <tr style="background-color: whitesmoke">
                <th class="text-center">Student Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">CMS ID</th>
                <th class="text-center">Email</th>
            </tr>
            <?php 
             $assigned_id = $this->input->get('id');
             $elective = $this->Admin_model->fetch_assign_class_student($assigned_id)->result_array()[0]['elective'];
             $class_id = $this->Admin_model->fetch_assign_class_student($assigned_id)->result_array()[0]['class_id'];
             if($elective == 0) {
                $dept = $this->Admin_model->fetch_class_from_id($class_id)->result_array()[0]['depart_id'];
                $semester = $this->Admin_model->fetch_class_from_id($class_id)->result_array()[0]['semester'];

                $students = $this->Admin_model->fetch_students_deptsem($dept, $semester);
                foreach($students as $st) {
            ?>
            <tr>
              <td class="text-center"><?php echo $st->student_name;?></td>
              <td class="text-center"><?php echo $st->student_lastname;?></td>
              <td class="text-center"><?php echo $st->cms_id;?></td>
              <td class="text-center"><?php echo $st->student_email;?></td>
            </tr>
            <?php }} else if($elective == 1) { 
              $students = $this->Admin_model->fetch_elective_students($assigned_id);
              foreach($students as $st) {
                  $st_id = $st->student_id;
                  $student_details = $this->Admin_model->fetch_elective_students_detail($st_id);
                  foreach($student_details as $details) {
              }
            ?>
            <tr>
              <td class="text-center"><?php echo $details->student_name;?></td>
              <td class="text-center"><?php echo $details->student_lastname;?></td>
              <td class="text-center"><?php echo $details->cms_id;?></td>
              <td class="text-center"><?php echo $details->student_email;?></td>
            </tr>  

            <?php }} ?>
        </thead>
    </table>
  </div>
</div>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    $current_type = $('.elec-type').val();
    // alert($current_type);
    if($current_type == "0") {
      $("#list").hide();
    } else if($current_type == "1") {
      $("#list").show();
      get_students();
    }


    $('.elec-type').change(function() {
         $current_type = $('.elec-type').val();
         if($current_type == "1") {
            $("#list").show();
            get_students();
         } else if($current_type == "0") {
            $("#list").hide();
         }
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
    $instructor = htmlspecialchars(trim($this->input->post('instructor')));
    $course = htmlspecialchars(trim($this->input->post('course')));
    $elective = $this->input->post('type');
    
    $data = array(
      'class_id' => $class,
      'course_id' => $course,
      'instructor_id' => $instructor,
      'elective' => $elective
    );

    $updateassign = $this->Admin_model->update_assigned($data, $this->input->get('id'));
    if($updateassign) {
        echo '<script type="text/javascript">window.alert("Assigned Class Updated Successfully")</script>';

         
    } else {
        echo '<script type="text/javascript">window.alert("Assigned Class Could Not Be Updated. Try Again")</script>';
    }

    if($elective == 1) {
      $this->Admin_model->delete_elective($this->input->get('id'));
      $list = $this->input->post('list');
      foreach($list as $l) {
          $data1 = array(
            'class_id' => $class,
            'student_id' => $l,
            'instructor_id' => $instructor,
            'course_id' => $course,
            'assigned_id' => $this->input->get('id')
          );
          
          $this->Admin_model->insert_elective($data1);
      }
    }

    header( 'refresh:0.5;url=Update_AssignedClass?id='.$this->input->get('id'));

  }
}
?>


<?php } ?>