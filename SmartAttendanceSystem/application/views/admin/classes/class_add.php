<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Class</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
  <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">ADD CLASS</h3>
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
            <input class="form-control mt-1 rounded-0" name="class" style="width: 100%" />
            </p>
          </div>
        </div>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Department:
            <select class="form-control mt-1 rounded-0" name="dept" style="width: 100%">
              <option value="">Select Department</option>
              <?php
              $department = $this->Admin_model->fetch_dept();
              foreach($department as $f) {
              ?>
              <option value=<?php echo $f->dept_id?>><?php echo $f->dept_name;?></option>
              <?php } ?>
            </select>
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Semester:
              <select class="form-control mt-1 rounded-0" type="text" name="semester" style="width: 100%">
                <option value="">Select Semester</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
                <option value=6>6</option>
                <option value=7>7</option>
                <option value=8>8</option>
                <option value=9>9</option>
                <option value=10>10</option>
              </select>
              </p>
          </div>
        </div>

<!--         <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course:
            <select class="form-control mt-1 rounded-0" name="course" style="width: 100%">
              <option value="">Select Course</option>
              <?php
              $course = $this->Admin_model->fetch_course();
              foreach($course as $f) {
              ?>
              <option value=<?php echo $f->course_id?>><?php echo $f->course_name;?></option>
              <?php } ?>
            </select>
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Instructor:
              <select class="form-control mt-1 rounded-0" name="instructor" style="width: 100%">
              <option value="">Select Instructor</option>
              <?php
              $instructor = $this->Admin_model->fetch_ins();
              foreach($instructor as $f) {
              ?>
              <option value=<?php echo $f->instructor_id?>><?php echo $f->instructor_name.' '.$f->instructor_lname;?></option>
              <?php } ?>
            </select>
            </p>
          </div>
        </div> -->

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
  // if($this->input->post('course') == '') {
  //     echo '<script type="text/javascript">window.alert("Course is required")</script>';
  // } if($this->input->post('instructor') == '') {
  //     echo '<script type="text/javascript">window.alert("Instructor is required")</script>';
  // } 
  // else 
    if($this->input->post('semester') == '') {
      echo '<script type="text/javascript">window.alert("Semester is required")</script>';
  } else if($this->input->post('dept') == '') {
      echo '<script type="text/javascript">window.alert("Department is required")</script>';
  } else if($this->input->post('class') == '') {
      echo '<script type="text/javascript">window.alert("Class is required")</script>';
  } else {
    // $course = htmlspecialchars(trim($this->input->post('course')));
    $dept = htmlspecialchars(trim($this->input->post('dept')));
    $semester = htmlspecialchars(trim($this->input->post('semester')));
    $class = htmlspecialchars(trim($this->input->post('class')));
    // $instructor = htmlspecialchars(trim($this->input->post('instructor')));

    $data = array(
      'class_no' => $class,
      'semester' => $semester,
      // 'inst_id' => $instructor,
      'depart_id' => $dept
    );

  $check = $this->Admin_model->check_if_class_exists($class);
  if($check) {
    echo '<script type="text/javascript">window.alert("Class Already Exists")</script>';
  } else {
      $insertdept = $this->Admin_model->add_class($data);
      if($insertdept) {
          echo '<script type="text/javascript">window.alert("Class Added Successfully")</script>';
      } else {
          echo '<script type="text/javascript">window.alert("Class Could Not Be Added. Try Again")</script>';
      }
    }
  }
}
?>


<?php } ?>