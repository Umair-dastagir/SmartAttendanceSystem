<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Department</title>

</head>
<body style="background-color: ghostwhite">
	<div class="wrapper">
	<br>
  <div class="card border border-0 mr-5 ml-5 bg-white border border-0 rounded-0 shadow">
  <div class="card-body table-responsive">
    <h3 style="color: #05386B;" class="text-center">ADD DEPARTMENT</h3>
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
            <p class="mt-3 text-dark" style="font-size: 17px">Department Name:
            <input class="form-control mt-1 rounded-0" type="text" name="name" style="width: 100%"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Faculty:
            <select class="form-control mt-1 rounded-0" name="faculty" style="width: 100%">
            	<option value="">Select Faculty</option>
              <?php
              $faculty = $this->Admin_model->fetch_faculty();
              foreach($faculty as $f) {
              ?>
              <option value=<?php echo $f->faculty_id?>><?php echo $f->fac_name;?></option>
              <?php } ?>
            </select>
            </p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Chair Person:
            <input class="form-control mt-1 rounded-0" type="text" name="chair" style="width: 100%">
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
      echo '<script type="text/javascript">window.alert("Department name is required")</script>';
  } else if($this->input->post('chair') == '') {
      echo '<script type="text/javascript">window.alert("Department Chair Person is required")</script>';
  } else if($this->input->post('faculty') == '') {
      echo '<script type="text/javascript">window.alert("Faculty is required")</script>';
  } else {
    $name = htmlspecialchars(trim($this->input->post('name')));
    $faculty = htmlspecialchars(trim($this->input->post('faculty')));
    $chair = htmlspecialchars(trim($this->input->post('chair')));

    $data = array(
      'dept_name' => $name,
      'faculty_id' => $faculty,
      'chair_person' => $chair
    );

    $check = $this->Admin_model->check_if_dept_exists($name);
    if($check) {
      echo '<script type="text/javascript">window.alert("Department Already Exists")</script>';
    } else {

    $insertdept = $this->Admin_model->insert_dept($data);
    if($insertdept) {
        echo '<script type="text/javascript">window.alert("Department Added Successfully")</script>';
    } else {
        echo '<script type="text/javascript">window.alert("Department Could Not Be Added. Try Again")</script>';
    }
  }
  }
}
?>


<?php } ?>