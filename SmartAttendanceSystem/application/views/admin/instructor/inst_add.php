<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Instructor</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
<div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">REGISTER INSTRUCTOR</h3>
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
            <input class="form-control mt-1 rounded-0" type="email" name="email" style="width: 100%">
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Password:
            <input class="form-control mt-1 rounded-0" type="password" name="pass" style="width: 100%">
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
            <p class="mt-3 text-dark" style="font-size: 17px">Position:
              <input class="form-control mt-1 rounded-0" type="text" name="pos" style="width: 100%"></p>
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
        </div>
        
        <br>
        <div class="row">
          <div class="col col-sm">
          <button class="btn btn-primary rounded-0" style="float:right" name="save"><i class="fa fa-check-square" aria-hidden="true"></i> Register Instructor</button>
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
  } else if($this->input->post('pass') == '') {
      echo '<script type="text/javascript">window.alert("Password is required")</script>';
  } else if($this->input->post('fname') == '') {
      echo '<script type="text/javascript">window.alert("First Name is required")</script>';
  } else if($this->input->post('lname') == '') {
      echo '<script type="text/javascript">window.alert("Last Name is required")</script>';
  } else if($this->input->post('pos') == '') {
      echo '<script type="text/javascript">window.alert("CMS ID is required")</script>';
  } else if($this->input->post('dept') == '') {
      echo '<script type="text/javascript">window.alert("Department is required")</script>';
  } else {
    $email = htmlspecialchars(trim($this->input->post('email')));
    $fname = htmlspecialchars(trim($this->input->post('fname')));
    $lname = htmlspecialchars(trim($this->input->post('lname')));
    $pass = htmlspecialchars(trim($this->input->post('pass')));
    $pos = htmlspecialchars(trim($this->input->post('pos')));
    $dept = htmlspecialchars(trim($this->input->post('dept')));
   

    $data = array(
      'instructor_name' => $fname,
      'instructor_lname' => $lname,
      'instructor_pass' => $pass,
      'instructor_dept' => $dept,
      'instructor_position' => $pos,
      'instructor_email' => $email
    );

    $check = $this->Admin_model->check_if_ins_exists($email);
    if($check) {
      echo '<script type="text/javascript">window.alert("Instructor Already Exists")</script>';
    } else {
    $register = $this->Admin_model->register_instructor($data);
    if($register) {
        echo '<script type="text/javascript">window.alert("Instructor Registered Successfully")</script>';
    } else {
        echo '<script type="text/javascript">window.alert("Instructor Could Not Be Registered. Try Again")</script>';
    }
}
    
  }
}
?>

<?php } ?>