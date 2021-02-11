<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>
<br><br>
<form method="POST">
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">COURSES LIST</h3>
	</div>
</div>
<br>
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<button style="float:right; background-color: #05386B; color: white"  class="btn btn-sm rounded-0 mb-4" name="add">Add Course</button>
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th style="width: 140px;" class="text-center"><i class="fas fa-tasks"></i>&nbsp;Actions&nbsp;&nbsp;</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Course Name</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Course Code</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Credit Hours</th>
			</tr>
		</thead>
		<?php
		$fetch_course = $this->Admin_model->fetch_courses();
		if($fetch_course) {
			foreach($fetch_course as $course) {
		?>
		<tr>
			<td class="text-center"><a href="<?php echo base_url();?>admin/Courses/Update_Course?id=<?php echo $course->course_id?>" title="update"><i class="fas fa-edit text-primary" style="font-size: 18px"></i></a>
			</td>
			<td class="text-center"><?php echo $course->course_name;?></td>
			<td class="text-center"><?php echo $course->course_code;?></td>
			<td class="text-center"><?php echo $course->cred_hours;?></td>
		</tr>
		<?php }} ?>
	
		</table>
	</div>
	</div>
</div>
</div>
</form>
<!-- <script>
	$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

<?php
if(isset($_POST['add'])) {
	redirect('admin/Courses/Add_Course');
}

if($this->input->post('delete')) {
	$id = $this->input->post('delete');
	$delete = $this->Admin_model->delete_student($id);
	if($delete) {
		// echo '<script type="text/javascript">window.alert("Student Successfully Deleted")</script>';
		redirect(base_url().'admin/Students');
	} else {
		echo '<script type="text/javascript">window.alert("Student Could Not Be Deleted. Try Again")</script>';
	}
}
?>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>