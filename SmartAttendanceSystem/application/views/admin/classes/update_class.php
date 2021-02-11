<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Class</title>

</head>
<body style="background-color: ghostwhite">
  <div class="wrapper">
  <br>
    <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">UPDATE CLASS INFORMATION</h3>
  </div>
</div>
<e style="font-size: 14px; color: #000">

<form enctype="multipart/form-data" method="POST">
  <div class="card border border-0 pt-5 pb-5 mr-5 ml-5 mb-3 mt-3">
  <div class="card border border-0 rounded-0 shadow ml-5 mr-5">
    <div class="container">
      <div class="row">
      <div class="col">
      <div class="card-body">
        <div class="container ml-2">
        <?php
        foreach($class as $cls) {
          
        ?>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Class Number:
            <input class="form-control mt-1 rounded-0" name="class" value="<?php echo $cls->class_no; ?>" style="width: 100%" />
            </p>
          </div>
        </div>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Department:
            <select class="form-control mt-1 rounded-0" name="dept" value="" style="width: 100%">
              <option value="<?php echo $cls->depart_id; ?>"><?php echo $cls->dept_name; ?></option>
              <?php
              $department = $this->Admin_model->fetch_dept();
              foreach($department as $f) {
                if($f->dept_id != $cls->deppt_id) {
              ?>
              <option value=<?php echo $f->dept_id?>><?php echo $f->dept_name;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Semester:
              <select class="form-control mt-1 rounded-0" type="text" name="semester" style="width: 100%">
                <option value="<?php echo $cls->semester; ?>"><?php echo $cls->semester; ?></option>
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
              <option value="<?php echo $cls->course_id?>"><?php echo $cls->course_name;?></option>
              <?php
              $course = $this->Admin_model->fetch_course();
              foreach($course as $c) {
                if($c->course_id != $cls->course_id) {
              ?>
              <option value=<?php echo $c->course_id?>><?php echo $c->course_name;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Instructor:
              <select class="form-control mt-1 rounded-0" name="instructor" style="width: 100%">
              <option value="<?php echo $cls->instructor_id;?>"><?php echo $cls->instructor_name.' '.$cls->instructor_lname;?></option>
              <?php
              $instructor = $this->Admin_model->fetch_ins();
              foreach($instructor as $f) {
                if($f->instructor_id != $cls->inst_id) {
              ?>
              <option value=<?php echo $f->instructor_id?>><?php echo $f->instructor_name.' '.$f->instructor_lname;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
        </div> -->

        <br>
        <div class="row">
          <div class="col col-sm">
          <button class="btn btn-primary rounded-0" style="float: right;" name="save"><i class="fa fa-edit" aria-hidden="true"></i> Update Department</button>
          </div>
        </div>
      <?php } ?>
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
  // } else 
  if($this->input->post('semester') == '') {
      echo '<script type="text/javascript">window.alert("Semester is required")</script>';
  } else if($this->input->post('dept') == '') {
      echo '<script type="text/javascript">window.alert("Department is required")</script>';
  } else if($this->input->post('class') == '') {
      echo '<script type="text/javascript">window.alert("Class Number is required")</script>';
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

    $updateclass = $this->Admin_model->update_class($data, $this->input->get('id'));
    if($updateclass) {
        echo '<script type="text/javascript">window.alert("Class Updated Successfully")</script>';
        header( 'refresh:0.5;url=Update_Class?id='.$this->input->get('id'));
    } else {
        echo '<script type="text/javascript">window.alert("Class Could Not Be Updated. Try Again")</script>';
    }
  }
}
?>

<?php } ?>