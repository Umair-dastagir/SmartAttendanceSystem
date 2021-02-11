<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>
<br><br>
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">INSTRUCTORS LIST</h3>
	</div>
</div>
<e style="font-size: 14px; color: #000">

<br>
<form method="POST">
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">

	<div class="card-body table-responsive">
		<button style="float:right; background-color: #05386B; color: white" class="btn btn-sm rounded-0 mb-4" name="add">Add Instructor</button>
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th style="width: 140px;" class="text-center"><i class="fas fa-tasks"></i>&nbsp;Actions&nbsp;&nbsp;</th>
				<th class="text-center"><i class="fas fa-user"></i>&nbsp;Instructor</th>
				<th class="text-center"><i class="fas fa-envelope"></i>&nbsp;Email</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Faculty</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Department</th>
				<th class="text-center"><i class="fa fa-level-up-alt"></i>&nbsp;Position</th>
				<th class="text-center"><i class="fas fa-check"></i>&nbsp;Status</th>
			</tr>
		</thead>
		<?php
		$fetch_instructors = $this->Admin_model->fetch_instructors();
		if($fetch_instructors) {
			foreach($fetch_instructors as $ins) {
		?>
		<tr>
			<td class="text-center">
				<a href="<?php echo base_url();?>admin/Instructor/Update_Instructor?id=<?php echo $ins->instructor_id?>" title="update"><i class="fas fa-edit text-primary" style="font-size: 18px"></i></a>&nbsp;
				<button title="delete" tooltip="delete" class="btn btn-sm btn-white" value="<?php echo $ins->instructor_id?>" name="delete"><i class="fas fa-trash text-danger" style="font-size: 18px"></i></a></button></td>
			<td class="text-center"><?php echo $ins->instructor_name.' '.$ins->instructor_lname;?></td>
			<td class="text-center"><?php echo $ins->instructor_email;?></td>
			<td class="text-center"><?php echo $ins->fac_name;?></td>
			<td class="text-center"><?php echo $ins->dept_name;?></td>
			<td class="text-center"><?php echo $ins->instructor_position;?></td>
			<?php if($ins->is_active == 0) { ?>
			<td class="text-center text-danger">Not Active</td>
			<?php } else if($ins->is_active == 1) { ?>
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
	redirect(base_url().'admin/Instructor/Add_Instructor');
}

if($this->input->post('delete')) {
	$id = $this->input->post('delete');
	$delete = $this->Admin_model->delete_instructor($id);
	if($delete) {
		echo '<script type="text/javascript">window.alert("Instructor Successfully Deleted")</script>';
		header('refresh:0.5;url=Instructor');
	} else {
		echo '<script type="text/javascript">window.alert("Instructor Could Not Be Deleted. Try Again")</script>';
	}
}
?>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>