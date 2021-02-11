<?php
if(empty(isset($_SESSION['id']))) {
	redirect('admin/Signin');
} else {
	$id = $_SESSION['id'];
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
    <h3 style="color: #05386B;" class="text-center">ACCOUNT SETTINGS</h3>
  </div>
</div>
<e style="font-size: 14px; color: #000">

<form method="POST" id="formm">
  <div class="card border border-0 rounded-0 pt-2 pb-5 mr-5 ml-5 mb-3 mt-3">
  <div class="card border border-0 rounded-0 shadow ml-5 mr-5">
    <div class="container">
      <div class="row">
        <div class="col col-3">
          <button class="btn btn-block text-dark rounded-0 border-dark" name="basic">Basic Information</button>
          <button class="btn btn-block text-dark rounded-0 border-dark" name="ch_pass" style="background-color: #F8F8F8">Change Password</button>
        </div>
      <div class="col col-9">
      <div class="card-body">
        <div class="container ml-2">
        <div class="row"> 

          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Current Password:
            <input class="form-control mt-1 rounded-0" type="text" name="currpass" style="width: 100%"></p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">New Password:
            <input class="form-control mt-1 rounded-0" type="text" name="pass" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Re-enter Password:
            <input class="form-control mt-1 rounded-0" type="text" name="repass" style="width: 100%">
            </p>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col col-sm">
          <button style="float:right" class="btn btn-primary rounded-0" name="save"><i class="fa fa-check-square" aria-hidden="true"></i> Update</button>
          </div>
        </div>
      </div>
    </div>
</div>
</form>
</div>
</div>
</div>
</body>
</html>

<?php
if (isset($_POST['basic'])) {
   header( 'location: ../AccountSettings');
} 
}
?>

<?php
if(isset($_POST['save'])) {
  if($this->input->post('currpass') == '') {
      echo '<script type="text/javascript">window.alert("Current Password required")</script>';
  } if($this->input->post('pass') == '') {
      echo '<script type="text/javascript">window.alert("New Password required")</script>';
  } else if($this->input->post('repass') == '') {
      echo '<script type="text/javascript">window.alert("Re enter Password required")</script>';
  } else if($this->input->post('pass') != $this->input->post('repass')) {
      echo '<script type="text/javascript">window.alert("Passwords are not the same")</script>';
  } else {
    $curr_pass = $this->input->post('currpass');
    $pass = $this->input->post('pass');
    $repass = $this->input->post('repass');

    if(!password_verify($curr_pass, $password)) {
      echo '<script type="text/javascript">window.alert("The current password that you have entered is incorrect. Try again")</script>';
    } else {
      $options = array('cost' => 12);
      $password_hash = password_hash($pass, PASSWORD_BCRYPT, $options);

      $data = array(
        'admin_pass' => $password_hash
      );

      $update = $this->Admin_model->update_info($data, $id);
    if($update) {
      echo '<script type="text/javascript">window.alert("Information updated successfully")</script>';
      header( 'refresh:0.5;url=AccountSettings/ChangePassword');
    } else {
      echo '<script type="text/javascript">window.alert("Update Failed. Try again")</script>';
    }
    }
  }
}
?>