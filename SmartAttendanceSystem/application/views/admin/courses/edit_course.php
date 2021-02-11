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
    <h3 style="color: #05386B;" class="text-center">UPDATE COURSE INFORMATION</h3>
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
          <?php foreach($course as $cs) { ?>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course Name:
            <input class="form-control mt-1 rounded-0" type="text" name="name" value="<?php echo $cs->course_name?>" style="width: 100%"></p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Course Code:
            <input class="form-control mt-1 rounded-0" type="text" name="code" value="<?php echo $cs->course_code?>" style="width: 100%">
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Credit Hours:
            <input class="form-control mt-1 rounded-0" type="text" name="hours" value="<?php echo $cs->cred_hours?>" style="width: 100%">
            </p>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col col-sm">
          <button style="float:right" class="btn btn-primary rounded-0" name="save"><i class="fa fa-edit" aria-hidden="true"></i> Update Course</button>
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
  if($this->input->post('name') == '') {
      echo '<script type="text/javascript">window.alert("Course Name is required")</script>';
  } else if($this->input->post('code') == '') {
      echo '<script type="text/javascript">window.alert("Department Code is required")</script>';
  } else if($this->input->post('hours') == '') {
      echo '<script type="text/javascript">window.alert("Department Code is required")</script>';
  } else {
    $name = htmlspecialchars(trim($this->input->post('name')));
    $code = htmlspecialchars(trim($this->input->post('code')));
    $hour = htmlspecialchars(trim($this->input->post('hours')));

    $data = array(
      'course_name' => $name,
      'course_code' => $code,
      'cred_hours' => $hour
    );

    $editcourse = $this->Admin_model->update_course($data, $this->input->get('id'));
    if($editcourse) {
        echo '<script type="text/javascript">window.alert("Course Updated Successfully")</script>';
        header( 'refresh:0.5;url=Update_Course?id='.$this->input->get('id'));
    } else {
        echo '<script type="text/javascript">window.alert("Course Could Not Be Updated. Try Again")</script>';
    }
  }
}
?>


<?php } ?>