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
    <h3 style="color: #05386B;" class="text-center">UPDATE DEPARTMENT INFORMATION</h3>
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
       	foreach($dept as $d) {
       		
       	?>
        <div class="row"> 

          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Department Name:
            <input class="form-control mt-1 rounded-0" type="text" name="name" style="width: 100%" value="<?php echo $d->dept_name;?>"></p>
          </div>
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Faculty:
            <select class="form-control mt-1 rounded-0" name="faculty" style="width: 100%">

            	<option value = "<?php echo $d->faculty_id;?>"><?php echo $d->fac_name;?></option>
              <?php
              $faculty = $this->Admin_model->fetch_faculty();
              foreach($faculty as $f) {
              	if($f->faculty_id != $d->faculty_id) {
              ?> 
              <option value=<?php echo $f->faculty_id?>><?php echo $f->fac_name;?></option>
              <?php }} ?>
            </select>
            </p>
          </div>
        </div>
        <!-- next row -->
        <div class="row"> 
          <div class="col col-sm">
            <p class="mt-3 text-dark" style="font-size: 17px">Chair Person:
            <input class="form-control mt-1 rounded-0" type="text" name="chair" style="width: 100%" value="<?php echo $d->chair_person;?>">
            </p>
          </div>
        </div>

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
	$id = $this->input->get('id');
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

    	$update = $this->Admin_model->update_dept($data, $id);
    	if($update) {
    		// redirect(base_url()."admin/Departments/Update_Department?id=".$id);
    		echo '<script type="text/javascript">window.alert("Department Updated Successfully")</script>';
        header( 'refresh:0.5;url=Update_Department?id='.$this->input->get('id'));
    	} else {
    		echo '<script type="text/javascript">window.alert("Department Could Not Be Updated. Try Again")</script>';
    	}
  }
}
?>

<?php } ?>