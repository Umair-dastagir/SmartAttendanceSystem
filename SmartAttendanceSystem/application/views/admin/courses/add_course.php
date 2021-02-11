<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Course</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
  <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">ADD COURSE</h3>
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
            <p class="mt-3 text-dark" style="font-size: 17px">Course Name:
            <input class="form-control mt-1 rounded-0" type="text" name="name" style="width: 100%"></p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course Code:
            <input class="form-control mt-1 rounded-0" type="text" name="code" style="width: 100%">
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Credit Hours:
            <input class="form-control mt-1 rounded-0" type="text" name="hours" style="width: 100%">
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
  if($this->input->post('name') == '') {
      echo '<script type="text/javascript">window.alert("Course Name is required")</script>';
  } else if($this->input->post('code') == '') {
      echo '<script type="text/javascript">window.alert("Course Code is required")</script>';
  } else if($this->input->post('hours') == '') {
      echo '<script type="text/javascript">window.alert("Credit Hours is required")</script>';
  } else {
    $name = htmlspecialchars(trim($this->input->post('name')));
    $code = htmlspecialchars(trim($this->input->post('code')));
    $hour = htmlspecialchars(trim($this->input->post('hours')));

    $data = array(
      'course_name' => $name,
      'course_code' => $code,
      'cred_hours' => $hour
    );

    $check = $this->Admin_model->check_if_course_exists($code, $hour);
    if($check) {
        echo '<script type="text/javascript">window.alert("Course Already Exists")</script>';
    } else {
        $addcourse = $this->Admin_model->add_course($data);
        if($addcourse) {
            echo '<script type="text/javascript">window.alert("Course Added Successfully")</script>';
        } else {
            echo '<script type="text/javascript">window.alert("Course Could Not Be Added. Try Again")</script>';
        }
      }
  }
}
?>


<?php } ?>