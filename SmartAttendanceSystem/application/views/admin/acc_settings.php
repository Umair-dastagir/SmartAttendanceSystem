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
          <button class="btn btn-block text-dark rounded-0 border-dark" name="basic" style="background-color: #F8F8F8">Basic Information</button>
          <button class="btn btn-block btn-default text-dark rounded-0 border-dark" name="ch_pass">Change Password</button>
        </div>
      <div class="col col-9">
      <div class="card-body">
        <div class="container ml-2">
        <div class="row"> 

          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Email:
            <input class="form-control mt-1 rounded-0" type="text" name="email" value="<?php echo $admin_email; ?>" style="width: 100%" disabled></p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">First Name:
            <input class="form-control mt-1 rounded-0" type="text" name="fname" value="<?php echo $admin_name; ?>" style="width: 100%">
            </p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Last Name:
            <input class="form-control mt-1 rounded-0" type="text" name="lname" value="<?php echo $admin_lastname; ?>" style="width: 100%">
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

<?php } 

if(isset($_POST['save'])) {
  if($this->input->post('fname') == '') {
      echo '<script type="text/javascript">window.alert("First Name is required")</script>';
  } else if($this->input->post('lname') == '') {
      echo '<script type="text/javascript">window.alert("Last Name is required")</script>';
  } else {
    $fname = $this->input->post('fname');
    $lname = $this->input->post('lname');
    $id = $_SESSION['id'];

    $data = array(
      'admin_name' => $fname,
      'admin_lastname' => $lname
    );

    $update = $this->Admin_model->update_info($data, $id);
    if($update) {
      echo '<script type="text/javascript">window.alert("Information updated successfully")</script>';
      header( 'refresh:0.5;url=AccountSettings');
    } else {
      echo '<script type="text/javascript">window.alert("Update Failed. Try again")</script>';
    }
  } 
}

?>


<?php
if(isset($_POST['ch_pass'])) {
   header( 'location: AccountSettings/ChangePassword');
}
?>