<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Instructor</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
<div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">UPDATE INSTRUCTOR</h3>
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
        <?php foreach($instructor as $ins) {?>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Email:
            <input class="form-control mt-1 rounded-0" type="text" name="email" value="<?php echo $ins->instructor_email ?>" style="width: 100%">
            </p>
          </div>
        </div>
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">First Name:
            <input class="form-control mt-1 rounded-0" type="text" name="fname" value="<?php echo $ins->instructor_name ?>" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Last Name:
              <input class="form-control mt-1 rounded-0" type="text" name="lname" value="<?php echo $ins->instructor_lname ?>" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Position:
              <input class="form-control mt-1 rounded-0" type="text" name="pos" value="<?php echo $ins->instructor_position ?>" style="width: 100%"></p>
          </div>
        </div>
         <div class="row"> 
            <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Department:
            <select class="form-control mt-1 rounded-0" type="text" name="dept" style="width: 100%">
              <option value="<?php echo $ins->instructor_dept?>"><?php echo $ins->dept_name;?></option>
              <?php 
                $depts = $this->Admin_model->fetch_dept();
                foreach($depts as $dp) {
                  if($dp->dept_id != $ins->instructor_dept) {
              ?>
              <option value="<?php echo $dp->dept_id?>"><?php echo $dp->dept_name;?></option>
              <?php }} ?>
            </select></p>
          </div>
        </div>
        
        <br>
        <div class="row">
          <div class="col col-sm">
          <button class="btn btn-primary rounded-0" style="float:right" name="save"><i class="fa fa-edit" aria-hidden="true"></i> Update Instructor</button>
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
  if($this->input->post('email') == '') {
      echo '<script type="text/javascript">window.alert("Email is required")</script>';
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
    $pos = htmlspecialchars(trim($this->input->post('pos')));
    $dept = htmlspecialchars(trim($this->input->post('dept')));
   

    $data = array(
      'instructor_name' => $fname,
      'instructor_lname' => $lname,
      'instructor_dept' => $dept,
      'instructor_position' => $pos,
      'instructor_email' => $email
    );

    $update_ins = $this->Admin_model->update_ins($data, $this->input->get('id'));
    if($update_ins) {
        echo '<script type="text/javascript">window.alert("Instructor Updated Successfully")</script>';
        header( 'refresh:0.5;url=Update_Instructor?id='.$this->input->get('id'));
    } else {
        echo '<script type="text/javascript">window.alert("Instructor Could Not Be Updated. Try Again")</script>';
    }
    
  }
}
?>

<?php } ?>