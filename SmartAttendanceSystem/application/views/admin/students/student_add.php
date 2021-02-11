<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
<div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">REGISTER STUDENT</h3>
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
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Email:
            <input class="form-control mt-1 rounded-0" type="text" name="email" style="width: 100%">
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Password:
            <input class="form-control mt-1 rounded-0" type="text" name="password" style="width: 100%">
            </p>
          </div>
        </div>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">First Name:
            <input class="form-control mt-1 rounded-0" type="text" name="fname" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Last Name:
              <input class="form-control mt-1 rounded-0" type="text" name="lname" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">CMS ID:
              <input class="form-control mt-1 rounded-0" type="text" name="cms" style="width: 100%"></p>
          </div>
        </div>
         <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Department:
            <select class="form-control mt-1 rounded-0" type="text" name="dept" style="width: 100%">
              <option value="">Select Department</option>
              <?php 
                foreach($depts as $dp) {
              ?>
              <option value="<?php echo $dp->dept_id?>"><?php echo $dp->dept_name;?></option>
              <?php } ?>
            </select></p>
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
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Admit Term:
              <input class="form-control mt-1 rounded-0" type="text" name="admit" style="width: 100%"></p>
          </div>
        </div>
        
        <br>
        <div class="row">
          <div class="col col-sm">
          <button class="btn btn-primary rounded-0" style="float:right" name="save"><i class="fa fa-check-square" aria-hidden="true"></i> Register Student</button>
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
  if($this->input->post('email') == '') {
      echo '<script type="text/javascript">window.alert("Email is required")</script>';
  } else if($this->input->post('password') == '') {
      echo '<script type="text/javascript">window.alert("Password is required")</script>';
  } else if($this->input->post('fname') == '') {
      echo '<script type="text/javascript">window.alert("First Name is required")</script>';
  } else if($this->input->post('lname') == '') {
      echo '<script type="text/javascript">window.alert("Last Name is required")</script>';
  } else if($this->input->post('cms') == '') {
      echo '<script type="text/javascript">window.alert("CMS ID is required")</script>';
  } else if($this->input->post('dept') == '') {
      echo '<script type="text/javascript">window.alert("Department is required")</script>';
  } else if($this->input->post('semester') == '') {
      echo '<script type="text/javascript">window.alert("Semester is required")</script>';
  } else if($this->input->post('admit') == '') {
      echo '<script type="text/javascript">window.alert("Admit Term is required")</script>';
  } else {
    $email = htmlspecialchars(trim($this->input->post('email')));
    $password = htmlspecialchars(trim($this->input->post('password')));
    $fname = htmlspecialchars(trim($this->input->post('fname')));
    $lname = htmlspecialchars(trim($this->input->post('lname')));
    $cms = htmlspecialchars(trim($this->input->post('cms')));
    $dept = htmlspecialchars(trim($this->input->post('dept')));
    $semester = htmlspecialchars(trim($this->input->post('semester')));
    $admit = htmlspecialchars(trim($this->input->post('admit')));

    $data = array(
      'student_name' => $fname,
      'cms_id' => $cms,
      'student_password' => $password,
      'student_lastname' => $lname,
      'student_email' => $email,
      'student_dept' => $dept,
      'student_semester' => $semester,
      'admit_term' => $admit 
    );

    $check = $this->Admin_model->check_if_student_exists($cms);
    if($check) {
      echo '<script type="text/javascript">window.alert("Student Already Exists")</script>';
    } else {
    $register = $this->Admin_model->register_student($data);
    if($register) {
        echo '<script type="text/javascript">window.alert("Student Registered Successfully")</script>';
    } else {
        echo '<script type="text/javascript">window.alert("Student Could Not Be Registered. Try Again")</script>';
    }
}
    
  }
}
?>

<?php } ?>