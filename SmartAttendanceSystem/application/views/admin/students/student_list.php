<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>
<br><br>
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">STUDENTS LIST</h3>
	</div>
</div>
<e style="font-size: 14px; color: #000">

<br>
<form method="POST">
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">

	<div class="card-body table-responsive">
		<button style="float:right; background-color: #05386B; color: white" class="btn btn-sm rounded-0 mb-4" name="add">Add Student</button>
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th style="width: 140px;" class="text-center"><i class="fas fa-tasks"></i>&nbsp;Actions&nbsp;&nbsp;</th>
				<th class="text-center"><i class="fas fa-user"></i>&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-envelope"></i>&nbsp;Email</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Faculty</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Department</th>
				<!-- <th class="text-center"><i class="fas fa-book-open"></i>&nbsp;Semester</th> -->
				<th class="text-center"><i class="fas fa-user-tag"></i>&nbsp;CMS ID</th>
				<th class="text-center"><i class="fas fa-calendar"></i>&nbsp;Admit Term</th>
				<th class="text-center"><i class="fas fa-check"></i>&nbsp;Status</th>
			</tr>
		</thead>
		<?php
		$fetch_students = $this->Admin_model->fetch_students();
		if($fetch_students) {
			foreach($fetch_students as $students) {
		?>
		<tr>
			<td class="text-center">
				<a href="<?php echo base_url();?>admin/Students/Update_Student?id=<?php echo $students->student_id?>" title="update"><i class="fas fa-edit text-primary" style="font-size: 18px"></i></a>&nbsp;
				<button title="delete" tooltip="delete" class="btn btn-sm btn-white" value="<?php echo $students->student_id?>" name="delete"><i class="fas fa-trash text-danger" style="font-size: 18px"></i></a></button></td>
			<td class="text-center"><?php echo $students->student_name.' '.$students->student_lastname;?></td>
			<td class="text-center"><?php echo $students->student_email;?></td>
			<td class="text-center"><?php echo $students->fac_name;?></td>
			<td class="text-center"><?php echo $students->dept_name;?></td>
			<!-- <td class="text-center"><?php //echo $students->student_semester;?></td> -->
			<td class="text-center"><?php echo $students->cms_id;?></td>
			<td class="text-center"><?php echo $students->admit_term;?></td>
			<?php if($students->is_active == 0) { ?>
			<td class="text-center text-danger">Not Active</td>
			<?php } else if($students->is_active == 1) { ?>
			<td class="text-center text-success">Active</td>
			<?php } ?>							
		</tr>
		<?php }} ?>
		</table>
	</div>
	</div>
</div>
</div>
</form>

<?php
if(isset($_POST['add'])) {
	redirect(base_url().'admin/Students/Add_Student');
}

if($this->input->post('delete')) {
	$id = $this->input->post('delete');
	$delete = $this->Admin_model->delete_student($id);
	if($delete) {
		echo '<script type="text/javascript">window.alert("Student Successfully Deleted")</script>';
		header('refresh:0.5;url=Students');
	} else {
		echo '<script type="text/javascript">window.alert("Student Could Not Be Deleted. Try Again")</script>';
	}
}
?>

<?php

?>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>